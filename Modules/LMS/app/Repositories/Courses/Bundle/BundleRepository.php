<?php

namespace Modules\LMS\Repositories\Courses\Bundle;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\LMS\Models\Outcomes;
use Illuminate\Support\Facades\Auth;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\Courses\Bundle\BundleFaq;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Repositories\Category\CategoryRepository;

class BundleRepository extends BaseRepository
{
    protected static $model = CourseBundle::class;
    protected static $exactSearchFields = [];



    /**
     * curseSave
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        return match ($request->form_key) {
            'basic' => self::handleBasicForm($request),
            'pricing' => self::handlePricing($request),
            'media' => self::handleMedia($request),
            'courses' => self::handleCourse($request),
            'additional_information' => self::handleAdditionalInformation($request),
            default => self::errorResponse(),
        };
    }

    // Common response formatter for error
    private static function errorResponse()
    {
        return [
            'status' => 'error',
            'bundle_id' => '',
            'form-key' => '',
        ];
    }

    // Handle basic form submission
    private static function handleBasicForm($request)
    {
        $response = parent::first(value: $request->bundle_id);
        $bundle = $response['status'] === 'success' ? $response['data'] : null;
        $slug = $bundle->slug ?? null;
        $customSlug = self::getBySlug(slug: Str::slug($request->title));
        $formaData = self::prepareCourseData($request, $slug, $customSlug);

        if (! $bundle) {
            $bundle = static::$model::create($formaData);
        }

        if (! $bundle) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }
        $translateData = [
            'title' => $formaData['title'] ?? '',
            'details' => $formaData['details'] ?? '',
        ];
        $defaultLanguage = app()->getLocale();
        self::translate($bundle, $translateData, locale: $request->locale);
        if ($request->locale &&  $defaultLanguage === $request->locale) {
            $bundle->update($formaData);
        }
        // Sync related models
        self::syncCourseRelations($bundle, $request);

        return self::successResponse($bundle->id, $request->form_key);
    }

    // Handle media form submission
    private static function handleMedia($request)
    {
        $bundle = parent::first(value: $request->bundle_id)['data'];
        if ($request->hasFile('short_video') && $request->video_src_type == 'local') {
            $video = parent::upload($request, fieldname: 'short_video', file: $course->short_video ?? '', folder: 'lms/courses/bundles/videos');
        } else {
            $video = $bundle->video_demo;
        }

        $bundle->thumbnail = self::handleThumbnailUpload($request, $bundle->thumbnail);
        $bundle->video_src_type = $request->video_src_type;
        $bundle->video_demo = $request->video_src_type == 'local' ?  $video : $request->demo_url;
        $bundle->update();
        return self::successResponse($request->course_id, $request->form_key);
    }



    /**
     * handleCourse
     * @param Request $request 
     *
     */
    private static function handleCourse($request)
    {
        $response = parent::first(value: $request->bundle_id);
        $bundle = $response['status'] === 'success' ? $response['data'] : null;
        $bundle->is_subscribe = $request->is_subscribe == 'on' ? 1 : 0;
        $bundle->is_certificate = $request->is_certificate == 'on' ? 1 : 0;
        $bundle->update();
        $bundle->courses()->sync($request->courseId);
        return self::successResponse($bundle->id, $request->form_key);
    }

    /**
     *  handleThumbnailUpload
     *
     * @param  Request  $request
     * @param  string  $thumbnail
     */
    protected static function handleThumbnailUpload($request, $thumbnail)
    {
        if ($request->hasFile('thumbnail')) {
            return parent::upload($request, 'thumbnail', file: $thumbnail ?? '', folder: 'lms/courses/bundles');
        }
        return $thumbnail;
    }

    /**
     *  syncCourseRelations
     *
     * @param  object  $course
     * @param  Request  $request
     */
    private static function syncCourseRelations($bundle, $request)
    {
        $bundle->levels()->sync($request->levels);
    }

    /**
     *  prepareCourseData
     *
     * @param  Request  $request
     * @param  string  $slug
     * @param  string  $customSlug
     */
    private  static function prepareCourseData($request, $slug, $customSlug)
    {
        $type = "admin";
        if (isInstructor()) {
            $type = "instructor";
        }
        if (isOrganization()) {
            $type = "org";
        }
        return [
            'title' => $request->title,
            'slug' => self::generateSlug($slug, $customSlug, $request->title),
            'category_id' => CategoryRepository::getCategoryId($request->category_id) ?? $request->category_id,
            'subcategory_id' => $request->category_id,
            'details' => $request->details,
            'user_id' => $request->instructor_id,
            'creator_id' => !isAdmin() ? authCheck()->id : null,
            'creator_type' =>  $type,
        ];
    }

    private static function handlePricing($request)
    {
        $response = parent::first(value: $request->bundle_id);
        $bundle = $response['status'] === 'success' ? $response['data'] : null;
        $bundle->update([
            'price' => $request->price,
            'currency' => $request->currency,
        ]);
        return self::successResponse($bundle->id, $request->form_key, $bundle->id);
    }

    // Handle additional information form submission
    private static function handleAdditionalInformation($request)
    {
        $bundle = parent::first(value: $request->bundle_id)['data'];
        $outcomeId = static::handleOutcomes($request->outcomes);
        self::handleFAQs($request->faqs, $bundle->id);
        $bundle->bundleOutComes()->sync($outcomeId);
        return self::successResponse($bundle->id, $request->form_key);
    }

    /**
     *  handleFAQs
     *
     * @param  array  $faqs
     * @param  int  $courseId
     */
    private static function handleFAQs($faqs, $bundleId)
    {
        if ($faqs) {
            BundleFaq::where('bundle_id', $bundleId)->delete();
            foreach ($faqs as $faq) {
                if (isset($faq['title'], $faq['answer'])) {
                    BundleFaq::updateOrCreate(
                        ['id' => $faq['id'] ?? ''],
                        [
                            'bundle_id' => $bundleId,
                            'question' => $faq['title'],
                            'answer' => $faq['answer'],
                        ]
                    );
                }
            }
        }
    }

    /**
     *  outcomes
     *
     * @param array $outcomes
     */
    private static function handleOutcomes($outcomes): array
    {
        $outcomeId = [];
        if ($outcomes) {
            foreach ($outcomes as $outcome) {
                if (isset($outcome['title'])) {
                    $outcome = Outcomes::updateOrCreate(
                        ['title' => $outcome['title']],
                        ['slug' => Str::slug($outcome['title'])]
                    );
                    $outcomeId[] = $outcome->id;
                }
            }
        }
        return $outcomeId;
    }

    /**
     * getBySlug
     *
     * @param  string  $slug
     */
    public static function getBySlug($slug)
    {
        $bundle = static::$model::firstWhere('slug', $slug);
        if (! $bundle) {
            return false;
        }
        return $bundle->slug;
    }
    /**
     *  generateSlug
     *
     * @param  string  $slug
     * @param  string  $customSlug
     * @param  string  $title
     */
    private static function generateSlug($slug, $customSlug, $title)
    {
        return ! empty($slug) ? $slug : ($customSlug ? $customSlug . '-' . Str::random(2) : Str::slug($title));
    }
    private static function successResponse($bundleId, $formKey, $additionalId = null)
    {
        return [
            'status' => 'success',
            'bundle_id' => $bundleId,
            'form-key' => $formKey,
            'price_id' => $additionalId,
            'menu_type' => 'bundle'
        ];
    }

    /**
     * delete
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $response = parent::first($id, withTrashed: true);
        $bundle = $response['data'] ?? null;
        if ($bundle && $response['status'] == 'success') {
            $isDeleteAble = true;
            if (static::isSoftDeleteEnable() && ! $bundle->trashed()) {
                $isDeleteAble = false;
            }
            if ($isDeleteAble) {
                parent::fileDelete(folder: 'lms/courses/bundles', file: $bundle->thumbnail);
            }
            return parent::delete(id: $id);
        }
        return $response;
    }

    /**
     * Retrieve a paginated list of bundles based on user role.
     *
     * @param int $item The number of items per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator A paginated list of bundles.
     */
    public function bundleGetByUser($item = 10, $options = [])
    {
        // Initialize the options array based on user role.
        $fields = ['user_id' => authCheck()->id];
        if (isOrganization()) {

            $fields = ['creator_id' => authCheck()->id];
        }

        // Prepare the query for the bundle model.

        if (!is_array($options)) {
            $options = array($options);
        }

        $options = array_merge([
            'orderBy' => ['updated_at', 'DESC'],
        ], $options);


        $bundle = static::$model::query();

        foreach ($options as $option => $value) {

            $keys = is_array($value) ? array_keys($value) : [];

            if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                $bundle->{$option}(...$value);
            } else if (empty($value)) {
                $bundle->{$option}();
            } else {
                $bundle->{$option}($value);
            }
        }

        // Retrieve and return a paginated list of bundles based on the determined options.
        return $bundle->with('courses')->where($fields)->paginate($item);
    }

    /**
     * Retrieve a bundle by its ID based on user role.
     *
     * @param int $id The ID of the bundle to retrieve.
     * @return mixed The bundle object if found, null otherwise.
     */
    public function bundleEdit($id, $locale = null)
    {
        // Initialize the options array based on the user's role.
        $options = ['user_id' => authCheck()->id];

        // Prepare the query for the bundle model.
        $bundle = static::$model::query();
        $bundle->with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        // Retrieve and return the first bundle that matches the given ID and options.
        return $bundle->where($options)->firstWhere('id', $id);
    }

    public function thumbnailDelete($id): array
    {
        // If the user is an instructor, set the options for instructor ID.

        $options = ['user_id' => authCheck()->id];
        $model = static::$model::query();

        if ($options) {
            $model->where($options);
        }
        $bundle =  $model->firstWhere('id', $id);
        if (!$bundle) {
            return [
                'status' => 'error'
            ];
        }
        parent::fileDelete(folder: 'lms/courses/bundles', file: $bundle->thumbnail);
        $bundle->thumbnail = null;
        $bundle->update();
        return [
            'status' => 'success'
        ];
    }




    public static function bundleDetail($slug)
    {

        $response = parent::first($slug, field: 'slug', relations: [
            'courses.category',
            'courses.levels',
            'courses.translations',
            'levels.translations',
            'category.translations',
            'bundleOutComes',
            'bundleFaqs',
            'user.userable.translations',
        ]);


        return  $response['data'];
    }

    /**
     *  Delete information based on the provided key and ID.
     *
     * @param  mixed  $request
     */
    public static function deleteInformation($request): array
    {
        return match ($request->key) {
            'faq' => BundleFaq::where('id', $request->id)->delete()
                ? ['status' => 'success']
                : ['status' => 'error'],
            default => ['status' => 'error'],
        };
    }



    public function countBundleByUser($options = [], $withTrashed = false): array
    {
        try {
            if (!is_array($options)) {
                $options = array($options);
            }

            $model = static::$model::query();

            if ($withTrashed) {
                $model->withTrashed();
            }

            if (!is_array($options)) {
                $options = array($options);
            }

            $options = array_merge([
                'orderBy' => ['updated_at', 'DESC'],
            ], $options);


            $fields = ['user_id' => authCheck()->id];
            // Set options.
            foreach ($options as $option => $value) {
                if (is_array($value)) {
                    $model->{$option}(...$value);
                } else {
                    $model->{$option}($value);
                }
            }

            $bundles = $model->with('courses')->where($fields)->get();
            return [
                'status' => 'success',
                'data' => $bundles,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    public static function translateData(array $data)
    {
        $data = [
            'title' => $data['title'],
            'details' => $data['details'],
        ];

        return $data;
    }

    public static function translate($model, $data, $locale)
    {
        $model->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }

    /**
     * @param  int  $id
     * @return array
     */
    public static function statusChange($id)
    {
        $response = parent::first($id);
        $bundle = $response['data'];
        $bundle->status = ! $bundle->status;
        $bundle->update();
        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully'),
        ];
    }
}
