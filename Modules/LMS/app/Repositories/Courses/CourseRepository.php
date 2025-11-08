<?php

namespace Modules\LMS\Repositories\Courses;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Modules\LMS\Models\Outcomes;
use Illuminate\Support\Facades\DB;
use Modules\LMS\Enums\CourseStatus;
use Modules\LMS\Models\Courses\Tag;
use Illuminate\Support\Facades\Auth;
use Modules\LMS\Classes\EmailFormat;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Courses\Review;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Models\Courses\CourseFaq;
use Modules\LMS\Models\Courses\CoursePrice;
use Modules\LMS\Models\Courses\Requirement;
use Modules\LMS\Models\Courses\Topics\Quiz;
use Illuminate\Support\Facades\Notification;
use Modules\LMS\Models\Courses\Topics\Video;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\Courses\CourseSetting;
use Modules\LMS\Models\Courses\Topics\Reading;
use Modules\LMS\Models\Courses\CourseNoticeboard;
use Modules\LMS\Models\Courses\Topics\Assignment;
use Modules\LMS\Models\Courses\Topics\Supplement;
use Modules\LMS\Notifications\NotifyCourseStatus;
use Modules\LMS\Models\Courses\CourseMeetProvider;
use Modules\LMS\Models\Courses\CoursePreviewImage;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Repositories\Category\CategoryRepository;

class CourseRepository extends BaseRepository
{
    protected static $model = Course::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'locale'],
        'update' => ['_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:courses,name',
        ],
        'update' => [],
    ];

    public function __construct(protected CategoryRepository $category) {}

    /**
     * Get a model.
     *
     * @param  int  $id
     * @param  array  $realtions
     */
    public static function first($value, $field = 'id', $relations = [], $options = [], $withTrashed = false): array
    {

        $options[$field] = $value;

        if (isOrganization()) {
            $options['organization_id'] = authCheck()->id;
        }
        $model = static::$model::withTrashed()->where($options)->with($relations)->first();
        if ($model) {
            return [
                'status' => 'success',
                'data' => $model,
            ];
        }

        // Return error if model doesn't find.
        return [
            'status' => 'error',
            'data' => '404',
        ];
    }

    /**
     * Delete a model.
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {

        if (! is_array($options)) {
            $options = (array) $options;
        }

        $options = array_merge([
            'withTrashed' => [],
        ], $options);
        // Get Model instance by $id.
        $response = parent::first(value: $id, options: $options);

        $model = $response['data'] ?? null;
        // Return model if saved successfully.
        if ($model) {

            if (! is_array($data)) {
                $data = (array) $data;
            }
            foreach ($data as $field => $value) {
                $model->{$field} = $value;
            }
            // This will helpful for soft delete. E.g: update status column.
            $model->save();

            $is_deleted = $model->trashed() ? $model->forceDelete() : $model->delete();

            if ($is_deleted) {
                return [
                    'status' => 'success',
                    'data' => $model,
                ];
            }
        }

        return [
            'status' => 'success',
            'data' => '',
        ];
    }

    /**
     * getFirst
     */
    public static function getFirst($id, $withTrashed = false)
    {

        $model = static::$model::query();
        if ($withTrashed) {
            $model->withTrashed();
        }
        $course = $model->withWhereHas(
            'instructors',
            function ($query) {
                $query->where('instructor_id', authCheck()->id);
            }
        )->with(
            'levels',
            'languages',
            'courseTags',
            'courseRequirements',
            'courseOutComes',
            'courseFaqs',
            'coursePrice',
            'courseSetting',
            'coursePreviews',
            'chapters.topics.topicable.topic_type',
            'courseNotes',
            'meetProvider'
        )
            ->firstWhere('id', $id);

        if (! $course) {

            return [
                'status' => 'error',
                'data' => '404',
            ];
        }

        return [
            'status' => 'success',
            'data' => $course,
        ];
        // Return error if model doesn't find.

    }

    /**
     * curseSave
     *
     * @param  mixed  $request
     */
    public function store($request): array
    {
        return match ($request->form_key) {
            'basic' => $this->handleBasicForm($request),
            'additional_information' => $this->handleAdditionalInformation($request),
            'pricing' => $this->handlePricing($request),
            'meet-provider' => $this->handleMeetProvider($request),
            'curriculum' => $this->handleCurriculum($request),
            'media' => $this->handleMedia($request),
            'noticeboard' => $this->handleNoticeboard($request),
            'setting' => $this->handleSetting($request),
            default => $this->errorResponse(),
        };
    }

    // Handle basic form submission
    private function handleBasicForm($request)
    {

        $response = parent::first(value: $request->course_id);
        $course = $response['status'] === 'success' ? $response['data'] : null;
        $slug = $course->slug ?? null;
        $customSlug = $this->getBySlug(Str::slug($request->title));

        if ($request->hasFile('short_video') && $request->video_src_type == 'local') {
            $video = parent::upload($request, fieldname: 'short_video', file: $course->short_video ?? '', folder: 'lms/courses/demo-videos');
            $request->merge(['system_video' => $video]);
        } else {
            $request->video_src_type == 'local' ? $request->merge(['system_video' => $course->short_video ?? null]) : null;
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $this->handleThumbnailUpload($request, $course->thumbnail ?? '');
        }

        $request->merge(['image' => $thumbnail ?? $course->thumbnail ?? '']);
        $formaData = $this->prepareCourseData($request, $slug, $customSlug);

        if (! $course) {
            $course = static::$model::create($formaData);
        }

        if (! $course) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $translateData = [
            'title' => $formaData['title'] ?? '',
            'short_description' => $formaData['short_description'] ?? '',
            'description' => $formaData['description'] ?? '',
        ];
        $defaultLanguage = app()->getLocale();
        self::translate(course: $course,  data: $translateData, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage === $request->locale) {
            $course->update($formaData);
        }

        // Sync related models
        $this->syncCourseRelations($course, $request);

        return $this->successResponse($course->id, $request->form_key);
    }

    // Handle additional information form submission
    private function handleAdditionalInformation($request)
    {
        $course = parent::first(value: $request->course_id)['data'];
        $requirementId = $this->handleRequirements($request->requirements);
        $outcomeId = $this->handleOutcomes($request->outcomes);
        $this->handleFAQs($request->faqs, $course->id);

        // Sync outcomes and requirements
        $course->courseOutComes()->sync($outcomeId);
        $course->courseRequirements()->sync($requirementId);
        $course->courseTags()->sync($request->tags);

        return $this->successResponse($course->id, $request->form_key);
    }

    // Handle pricing form submission
    private function handlePricing($request)
    {
        $response = parent::first(value: $request->course_id, relations: ['instructors']);
        $course = $response['status'] === 'success' ? $response['data'] : null;

        $coursePrice = CoursePrice::updateOrCreate(
            ['course_id' => $request->course_id ?? ''],
            $this->preparePricingData($request)
        );

        $course->update(['is_multiple_instructor'  => $request->is_multiple_instructor == "on" ? 1  : 0]);
        if ($request->is_multiple_instructor == "on") {
            foreach ($request->instructors as  $instructor) {
                DB::table('course_instructors')
                    ->where(['course_id' => $request->course_id, 'instructor_id' => $instructor['id']])
                    ->update([
                        'percentage' => $instructor['percentage'],
                        'is_main' =>  isset($instructor['is_main']) && $instructor['is_main'] == 'on' ? 1 : null
                    ]);
            }
        }
        return $this->successResponse($coursePrice->course_id, $request->form_key, $coursePrice->id);
    }

    // Handle meet provider form submission
    private function handleMeetProvider($request)
    {
        if (isset($request->meet_provider_id)) {
            CourseMeetProvider::updateOrCreate(
                ['course_id' => $request->course_id],
                $this->prepareMeetProviderData($request)
            );
        }

        return $this->successResponse($request->course_id, $request->form_key);
    }

    // Handle curriculum form submission
    private function handleCurriculum($request)
    {
        return $this->successResponse($request->course_id, $request->form_key);
    }

    // Handle media form submission
    private function handleMedia($request)
    {
        $course = parent::first(value: $request->course_id)['data'];
        $course->thumbnail = $this->handleThumbnailUpload($request, $course->thumbnail);
        $course->update();
        $this->previewImage($course->id, $request->preview_image);

        return $this->successResponse($request->course_id, $request->form_key);
    }

    // Handle noticeboard form submission
    private function handleNoticeboard($request)
    {
        if (isset($request->notice_title, $request->notice_description)) {
            CourseNoticeboard::create([
                'course_id' => $request->course_id,
                'title' => $request->notice_title,
                'description' => $request->notice_description,
                'is_mailable' => $request->is_mailable == 'on' ? 1 : 0,
            ]);
        }

        return $this->successResponse($request->course_id, $request->form_key);
    }

    // Handle settings form submission
    private function handleSetting($request)
    {
        $course = parent::first(value: $request->course_id)['data'];
        $setting = CourseSetting::updateOrCreate(
            ['course_id' => $request->course_id],
            $this->prepareSettingData($request)
        );

        // Sync related courses if provided
        if ($request->relatedCourses) {
            $course->relatedCourse()->sync($request->relatedCourses);
        }

        return $this->successResponse($setting->course_id, $request->form_key);
    }

    // Common response formatter for success
    private function successResponse($courseId, $formKey, $additionalId = null)
    {
        return [
            'status' => 'success',
            'course_id' => $courseId,
            'form-key' => $formKey,
            'price_id' => $additionalId,
        ];
    }

    // Common response formatter for error
    private function errorResponse()
    {
        return [
            'status' => 'error',
            'course_id' => '',
            'form-key' => '',
        ];
    }

    // Helper methods for specific tasks

    private function getExistingCourseSlug($courseId)
    {
        return isset($courseId) ? parent::first($courseId)['data']->slug : '';
    }

    /**
     *  prepareCourseData
     *
     * @param  Request  $request
     * @param  string  $slug
     * @param  string  $customSlug
     */
    private function prepareCourseData($request, $slug, $customSlug)
    {
        return [
            'title' => $request->title,
            'slug' => $this->generateSlug($slug, $customSlug, $request->title),
            'time_zone_id' => $request->time_zone_id,
            'subject_id' => $request->subject_id,
            'organization_id' => $request->organization_id == 'no-select' ? null : $request->organization_id,
            'category_id' => $this->category->getCategoryId($request->category_id) ?? $request->category_id,
            'subcategory_id' => $request->category_id,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'duration' => $request->duration,
            'video_src_type' => $request->video_src_type,
            'short_video' => $request->system_video ?? null,
            'demo_url' => $request->demo_url,
            'thumbnail' => $request->image,
            'admin_id' => (authCheck()?->guard == 'instructor' || authCheck()?->guard == 'organization') ? null : Auth::guard('admin')->user()->id,
            'status' => CourseStatus::PENDING,
        ];
    }

    /**
     *  generateSlug
     *
     * @param  string  $slug
     * @param  string  $customSlug
     * @param  string  $title
     */
    private function generateSlug($slug, $customSlug, $title)
    {
        return ! empty($slug) ? $slug : ($customSlug ? $customSlug . '-' . Str::random(2) : Str::slug($title));
    }

    /**
     *  syncCourseRelations
     *
     * @param  object  $course
     * @param  Request  $request
     */
    private function syncCourseRelations($course, $request)
    {
        $course->levels()->sync($request->levels);
        $course->instructors()->sync($request->instructors);
        $course->languages()->sync($request->languages);
    }

    /**
     *  handleRequirements
     *
     * @param  array  $requirements
     */
    private function handleRequirements($requirements): array
    {
        $requirementId = [];
        if ($requirements) {
            foreach ($requirements as $requirement) {
                if (isset($requirement['title'])) {
                    $requirement = Requirement::updateOrCreate(
                        ['title' => $requirement['title']],
                        ['slug' => Str::slug($requirement['title'])]
                    );
                    $requirementId[] = $requirement->id;
                }
            }
        }

        return $requirementId;
    }

    /**
     *  outcomes
     *
     * @param  array  $outcomes
     */
    private function handleOutcomes($outcomes): array
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
     *  handleFAQs
     *
     * @param  array  $faqs
     * @param  int  $courseId
     */
    private function handleFAQs($faqs, $courseId)
    {
        if ($faqs) {
            CourseFaq::where('course_id', $courseId)->delete();
            foreach ($faqs as $faq) {
                if (isset($faq['title'], $faq['answer'])) {
                    CourseFaq::updateOrCreate(
                        ['id' => $faq['id'] ?? ''],
                        [
                            'course_id' => $courseId,
                            'title' => $faq['title'],
                            'answer' => $faq['answer'],
                        ]
                    );
                }
            }
        }
    }

    /**
     *  preparePricingData
     *
     * @param  Request  $request
     */
    private function preparePricingData($request)
    {
        return [
            'course_id' => $request->course_id,
            'price' => $request->price,
            'platform_fee' => $request->platform_fee,
            'currency' => $request->currency,
            'discount_flag' => $request->discount_flag == 'on' ? 1 : 0,
            'discounted_price' => $request->discount_flag == 'on' ? $request->discounted_price : null,
            'discount_period' => $request->discount_flag == 'on' ? $request->discount_period : null,
            'expiration_date' => $request->discount_flag == 'on' ? $request->expiration_date : null,
        ];
    }

    /**
     * prepareMeetProviderData
     *
     * @param  Request  $request
     */
    private function prepareMeetProviderData($request): array
    {
        return [
            'meet_provider_id' => $request->meet_provider_id,
            'meeting_id' => $request->meeting_id,
            'moderator_pw' => $request->moderator_pw,
            'class_schedule_date' => $request->class_schedule_date,
            'class_schedule_time' => $request->class_schedule_time,
            'instruction' => $request->instruction,
        ];
    }

    /**
     *  prepareSettingData.
     *
     * @param  Request  $request
     */
    private function prepareSettingData($request): array
    {
        return [
            'course_id' => $request->course_id,
            'access_days' => $request->access_days,
            'sale_count_number' => $request->sale_count_number,
            'seat_capacity' => $request->seat_capacity,
            'has_support' => $request->has_support == 'on' ? 1 : 0,
            'is_certificate' => $request->is_certificate == 'on' ? 1 : 0,
            'is_downloadable' => $request->is_downloadable == 'on' ? 1 : 0,
            'has_course_forum' => $request->has_course_forum == 'on' ? 1 : 0,
            'has_subscription' => $request->has_subscription == 'on' ? 1 : 0,
            'is_wait_list' => $request->is_wait_list == 'on' ? 1 : 0,
            'is_free' => $request->is_free == 'on' ? 1 : 0,
            'is_upcoming' => $request->is_upcoming == 'on' ? 1 : 0,
            'is_live' => $request->is_live == 'on' ? 1 : 0,
            'is_subscribe' => $request->is_subscribe == 'on' ? 1 : 0,
        ];
    }

    /**
     *  handleThumbnailUpload
     *
     * @param  Request  $request
     * @param  string  $thumbnail
     */
    protected function handleThumbnailUpload($request, $thumbnail)
    {

        if ($request->hasFile('thumbnail')) {
            return parent::upload($request, 'thumbnail', file: $thumbnail ?? '', folder: 'lms/courses/thumbnails');
        }

        return $thumbnail;
    }

    /**
     * previewImage
     *
     * @param  int  $courseId
     * @param  array  $previewImages
     * @return void
     */
    public function previewImage($courseId, $previewImages)
    {

        $allowedfileExtension = ['svg', 'jpg', 'png', 'webp', 'jpeg'];
        if (! empty($previewImages)) {
            foreach ($previewImages as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $image = Str::random(8) . '.' . str_replace(' ', '-', $file->getClientOriginalName());
                    $file->storeAs('public/lms/courses/previews/', $image, 'LMS');
                    CoursePreviewImage::create(
                        [
                            'course_id' => $courseId,
                            'image' => $image,
                        ]
                    );
                }
            }
        }
    }

    /**
     * requirementSearch
     */
    public function requirementSearch($request)
    {
        return Requirement::where('title', 'like', '%' . $request->key . '%')->get();
    }

    /**
     *  tagSearch
     *
     * @param  mixed  $request
     */
    public function tagSearch($request): array
    {
        $tags = Tag::where('name', 'like', '%' . $request->q . '%')->get();

        return [
            'items' => $tags,
        ];
    }

    /**
     *  Delete information based on the provided key and ID.
     *
     * @param  mixed  $request
     */
    public function deleteInformation($request): array
    {
        return match ($request->key) {
            'faq' => CourseFaq::where('id', $request->id)->delete()
                ? ['status' => 'success']
                : ['status' => 'error'],
            default => ['status' => 'error'],
        };
    }

    /**
     *  deleteImage
     *
     *
     * @return array
     */
    public function deleteImage($id)
    {
        $preview = CoursePreviewImage::where('id', $id)->first();
        if (! $preview) {
            return ['status' => 'error'];
        }
        parent::fileDelete(file: $preview->image, folder: 'lms/courses/previews');
        $preview->delete();

        return [
            'status' => 'success',
        ];
    }

    /**
     * getBySlug
     *
     * @param  string  $slug
     */
    public function getBySlug($slug)
    {
        $course = static::$model::firstWhere('slug', $slug);
        if (! $course) {
            return false;
        }

        return $course->slug;
    }

    /**
     * getOrganizationCourse
     *
     * @param  int  $item
     */
    public function getOrganizationCourse($item = 10)
    {
        return static::$model::where('organization_id', authCheck()->id)->paginate($item);
    }

    /**
     * Update course status and notify instructors.
     *
     * @param  int  $id
     */
    public function statusChange($id, Request $request): array
    {
        $course = static::$model::with('instructors')->firstWhere('id', $id);

        if (! $course) {
            return [
                'status' => 'error',
                'message' => 'Something went wrong!',
            ];
        }

        // Update course status
        $this->updateCourseStatusAndSave($course, $request->status);

        // Notify instructors if they exist
        if (isset($course->instructors) && ! empty($course->instructors)) {
            $this->sendCourseStatusEmailToInstructors($course);
            $this->sendCourseStatusNotification($course);
        }

        return [
            'status' => 'success',
            'type' => true,
        ];
    }

    /**
     * Update the course status and save it to the database.
     *
     * @param  mixed  $course
     */
    private function updateCourseStatusAndSave($course, string $status): void
    {
        $course->status = $status;
        $course->update();
    }

    /**
     * Send course status email to each instructor.
     *
     * @param  mixed  $course
     */
    private function sendCourseStatusEmailToInstructors($course): void
    {
        foreach ($course->instructors as $instructor) {
            $data = [
                'user_name' => $instructor?->userable?->first_name . ' ' . $instructor?->userable?->last_name,
                'email' => $instructor->email,
                'app_name' => env('APP_NAME') ?? 'EduLab',
                'course_title' => $course->title,
                'course_status' => $course->status,
            ];
            EmailFormat::statusCourse($data);
        }
    }

    /**
     * Send course status notification to all instructors.
     *
     * @param  mixed  $course
     */
    private function sendCourseStatusNotification($course): void
    {
        $notificationData = [
            'course_status' => $course->status,
            'course_title' => $course->title,
            'slug' => $course->slug,
        ];
        Notification::send($course->instructors, new NotifyCourseStatus($notificationData));
    }

    /**
     * getLiveClass
     */
    public function getLiveClass()
    {

        return static::$model::whereHas(
            'courseSetting',
            function ($query) {
                $query->where('is_live', 1);
            }
        )->with('instructors.userable', 'coursePrice', 'levels', 'enrollments')->paginate(10);
    }

    /**
     * courseList
     *
     * @param  mixed  $request
     */
    public function courseList($request, $item = 6)
    {
        $realtions = [
            'courseSetting',
            'coursePreviews',
            'reviews',
            'levels',
            'chapters',
            'category',
            'courseSetting',
            'coursePrice',
            'totalPurchases',
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            },
            'category.translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            },
            'levels.translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ];
        $courses = static::$model::query();
       
        // Apply Filters
        if (isset($request->q)) {
            $this->filterByTitle($courses, $request->q);
        }

        if (isset($request->title)) {
            $this->filterByTitle($courses, $request->title);
        }
        if (isset($request->instructors)) {
            $this->filterByInstructors($courses, $request->instructors);
        }
        if (isset($request->languages)) {
            $this->filterByLanguages($courses, $request->languages);
        }
        if (isset($request->levels)) {
            $this->filterByLevels($courses, $request->levels);
        }
        if (isset($request->categories)) {
            $this->filterByCategories($courses, $request->categories, 'category_id');
        }
        if (isset($request->subcategories)) {
            $this->filterByCategories($courses, $request->subcategories, 'sub_category_id');
        }
        if (isset($request->subjects)) {
            $this->filterBySubjects($courses, $request->subjects);
        }
        if (isset($request->data_range)) {
            $this->filterByDateRange($courses, $request->data_range);
        }
        if (isset($request->min_price, $request->min_price)) {
            $this->filterByPriceRange($courses, $request->min_price, $request->max_price);
        }
        if (isset($request->sorted_by)) {
            $this->applySorting($courses, $request->sorted_by);
        }
        if (isset($request->organizations)) {

            $this->filterByOrganization($courses, $request->organizations);
        }
        if (isset($request->courseType)) {
            $this->filterByCourseType($courses, $request->courseType);
        }
        if (isset($request->is_upcoming)) {
            $this->filterByUpcoming($courses, $request->is_upcoming);
        }
        if (isset($request->course_id)) {
            $this->filterByCourseId($courses, $request->course_id);
        }
        if (empty($request->instructors)) {
            $this->filterByVerifiedInstructors($courses);
        }

        $courses->with($realtions)
            ->where('status', CourseStatus::APPROVED)
            ->latest();

        return $item ? $courses->paginate($item) : $courses->get();
    }

    /**
     * courseDetail
     *
     * @param  string  $slug
     */
    public function courseDetail($slug)
    {
        return static::$model::with(
            'instructors.userable',
            'courseSetting',
            'coursePrice',
            'subject',
            'courseOutComes',
            'relatedCourse',
            'chapters.topics.topicable.topic_type',
            'courseRequirements',
            'courseTags',
            'courseFaqs',
            'coursePreviews',
            'levels'
        )
            ->with('reviews')
            ->where('slug', $slug)
            ->first();
    }

    /**
     * courseBundle
     */
    public function courseBundle(Request $request, $item = 10)
    {
        $courseBundles = CourseBundle::query();
        $courseBundles->withWhereHas(
            'courses',
            function ($query) {
                $query->where('status', CourseStatus::APPROVED)
                    ->withWhereHas(
                        'instructors',
                        function ($query1) {
                            $query1->where('is_verify', 1)
                                ->with(
                                    'userable',
                                    function ($query2) {
                                        $query2->where('status', 1);
                                    }
                                );
                        }
                    )
                    ->with('courseSetting', 'coursePrice', 'reviews', 'translations');
            }
        );

        if (isset($request->title)) {
            $courseBundles->where('title', 'LIKE', '%' . $request->title . '%');
        }
        $courseBundles->with('translations');

        return $item ? $courseBundles->paginate($item) : $courseBundles->get();
    }

    /**
     * courseBundleDetail
     *
     * @param  string  $slug
     */
    public function courseBundleDetail($slug)
    {
        return CourseBundle::withWhereHas(
            'courses',
            function ($query) {
                $query->with([
                    'category',
                    'instructors.userable',
                    'coursePrice',
                    'subject',
                    'courseOutComes',
                    'courseRequirements',
                    'courseTags',
                    'courseFaqs',
                    'chapters.topics.topicable.topic_type',
                ]);
            }
        )->where('slug', $slug)->firstOrFail();
    }

    /**
     * courseReport
     */
    public function courseReport()
    {
        $data['total_course'] = count(parent::get()['data']);
        $data['total_approved'] = $this->getCourseByStatus(['status' => 'Approved'])->count();
        $data['total_rejected'] = $this->getCourseByStatus(['status' => 'Rejected'])->count();
        $data['total_pending'] = $this->getCourseByStatus(['status' => 'Pending'])->count();
        $data['total_paid'] = $this->paidCourse()->count();
        $data['total_free'] = $this->freeCourse()->count();

        return $data;
    }

    /**
     * getCourseByStatus
     *
     * @param  array  $status
     */
    public function getCourseByStatus($status)
    {
        return static::$model::where($status)->get();
    }

    /**
     * paidCourse
     */
    public function paidCourse()
    {
        return static::$model::withWhereHas(
            'courseSetting',
            function ($query) {
                $query->where('is_free', 0);
            }
        )->get();
    }

    /**
     * paidCourse
     */
    public function freeCourse()
    {
        return static::$model::withWhereHas(
            'courseSetting',
            function ($query) {
                $query->where('is_free', 1);
            }
        )->get();
    }

    /**
     * dashboardCourseFilter
     */
    public static function dashboardCourseFilter($request, $item = 10, $options = [])
    {

        if (! is_array($options)) {
            $options = [$options];
        }

        $options = array_merge([
            'orderBy' => ['updated_at', 'DESC'],
        ], $options);

        $courses = static::$model::query();

        // Set options.
        foreach ($options as $option => $value) {
            if (is_array($value)) {
                $courses->{$option}(...$value);
            } else {
                $courses->{$option}($value);
            }
        }
        if (! empty($request->categories)) {
            $courses->whereIn('category_id', $request->categories);
        }

        if (! empty($request->subcategories)) {
            $courses->whereIn('subcategory_id', $request->subcategories);
        }

        if (! empty($request->course_status) && $request->course_status != 'all') {
            $courses->where('status', $request->course_status);
        }
        if (! empty($request->course_type) && $request->course_type != 'all') {
            $type = $request->course_type == 'paid' ? 0 : 1;
            $courses->withWhereHas(
                'courseSetting',
                function ($query) use ($type) {
                    $query->where('is_free', $type);
                }
            );
        }
        if (! empty($request->organizations) && $request->organizations != 'no-select') {
            $courses->where(
                function ($query) use ($request) {
                    if ($request->organizations && ($request->instructors && $request->instructors != 'no-select')) {
                        $query->withWhereHas(
                            'organization.organizationInstructors',
                            function ($query) use ($request) {
                                $query->whereIn('id', $request->instructors);
                                $query->with('userable');
                            }
                        );
                    } else {
                        $query->where('organization_id', $request->organizations);
                    }
                }
            );
            $courses->with('courseSetting');
        } else {
            if (! empty($request->instructors) && $request->instructors != 'no-select') {
                $courses->withWhereHas(
                    'instructors',
                    function ($query) use ($request) {
                        $query->whereIn('instructor_id', $request->instructors);
                        $query->with('userable.translations');
                    }
                );
            }
        }
        $courses->with([
            'coursePrice',
            'levels.translations',
            'instructors.userable.translations',
            'courseSetting',
            'enrollments',
            'translations' => function ($query) {
                $query->where('locale', app()->getLocale());
            }
        ]);

        return $item ? $courses->paginate($item) : $courses->get();
    }

    /**
     * getCourseTopicByType
     *
     * @param  Request  $request
     */
    public function getCourseTopicByType($request)
    {

        $id = $request->id;
        $type = $request->type;

        // Fetch model and related data based on type
        $topic['data'] = $this->fetchContentByType($type, $id);

        if (! $topic['data']) {
            return [
                'status' => 'error',
                'message' => translate('Content not found'),
            ];
        }

        // Additional data for quiz type
        if ($type === 'quiz') {
            $topic['courseId'] = $request->course_id ?? null;
            $topic['topicId'] = $request->topic_id ?? null;
            $topic['chapterId'] = $request->chapter_id ?? null;
        }
        // Render view
        $view = view('theme::course.course-learn', compact('topic', 'type'))->render();

        return [
            'status' => 'success',
            'view' => $view,
            'learn' => true,
        ];
    }

    /**
     * Fetch content based on type and ID.
     *
     * @return mixed
     */
    private function fetchContentByType(string $type, int $id)
    {
        switch ($type) {
            case 'video':
                return Video::find($id);
            case 'reading':
                return Reading::find($id);
            case 'supplement':
                return Supplement::with('topic')->find($id);
            case 'assignment':
                return Assignment::with('topic')->find($id);
            case 'quiz':
                return Quiz::with('topic')->find($id);
            default:
                return;
        }
    }

    /**
     * review
     *
     * @param  Request  $request
     */
    public function review($request)
    {
        static::$rules['save'] = [
            'content_quality' => 'required',
            'instructor_skills' => 'required',
            'support_quality' => 'required',
            'content' => 'required',
        ];
        $validator = Validator::make($request->all(), static::$rules['save']);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'errors' => $validator->errors()->toArray(),
            ];
        }

        if (! Review::where(['user_id' => authCheck()->id, 'course_id' => $request->course_id])->first()) {
            Review::create([
                'user_id' => authCheck()->id,
                'course_id' => $request->course_id,
                'content_quality' => $request->content_quality,
                'support_quality' => $request->support_quality,
                'instructor_skills' => $request->instructor_skills,
                'content' => $request->content,
            ]);

            return [
                'status' => 'success',
            ];
        }

        return [
            'status' => 'error',
            'message' => translate('Already given the Review'),
        ];
    }

    /**
     *  getCoursesId
     *
     * @param  Request  $request  [ filter by  instructor, organization]
     */
    public static function getCoursesId($request)
    {
        $allCourse = self::dashboardCourseFilter($request, null);

        return $allCourse->count() > 0 ? $allCourse->pluck('id')->toArray() : null;
    }

    /**
     * Filter courses by title.
     */
    private function filterByTitle($query, ?string $title): void
    {
        if (! empty($title)) {
            $query->where('title', 'like', '%' . $title . '%');
        }
    }

    /**
     * Filter courses by instructors.
     */
    private function filterByInstructors($query, ?string $instructors): void
    {
        if (! empty($instructors)) {
            $query->whereHas('instructors', function ($query) use ($instructors) {
                $query->whereIn('instructor_id', explode(',', $instructors))
                    ->where('is_verify', 1)
                    ->whereHas('userable', function ($query) {
                        $query->where('status', 1);
                    });
            });
        }
    }

    /**
     * Filter courses by languages.
     */
    private function filterByLanguages($query, ?string $languages): void
    {
        if (! empty($languages)) {
            $query->whereHas('languages', function ($query) use ($languages) {
                $query->whereIn('language_id', explode(',', $languages));
            });
        }
    }

    /**
     * Filter courses by levels.
     */
    private function filterByLevels($query, ?string $levels): void
    {
        if (! empty($levels)) {
            $query->whereHas('levels', function ($query) use ($levels) {
                $query->whereIn('level_id', explode(',', $levels));
            });
        }
    }

    /**
     * Filter courses by category or subcategory.
     */
    private function filterByCategories($query, ?string $categories, string $column): void
    {
        if (! empty($categories)) {
            $query->whereIn($column, explode(',', $categories));
        }
    }

    /**
     * Filter courses by subject.
     */
    private function filterBySubjects($query, ?string $subjects): void
    {
        if (! empty($subjects)) {
            $query->whereHas('subject', function ($query) use ($subjects) {
                $query->whereIn('subject_id', explode(',', $subjects));
            });
        }
    }

    /**
     * Filter courses by date range.
     */
    private function filterByDateRange($query, ?string $dateRange): void
    {
        if (! empty($dateRange)) {
            $query->whereBetween('created_at', [$dateRange, Carbon::now()]);
        }
    }

    /**
     * Filter courses by price range.
     */
    private function filterByPriceRange($query, ?string $minPrice, ?string $maxPrice): void
    {
        if (isset($minPrice, $maxPrice)) {
            $query->whereHas('coursePrice', function ($query) use ($minPrice, $maxPrice) {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }
    }

    /**
     * Apply sorting to the query.
     */
    private function applySorting($query, ?string $sortedBy): void
    {
        if (! empty($sortedBy)) {
            $query->orderBy('id', $sortedBy);
        }
    }

    /**
     * Filter courses by organization.
     */
    private function filterByOrganization($query, ?string $organizations): void
    {
        if (! empty($organizations)) {
            $query->whereIn('organization_id', explode(',', $organizations));
        }
    }

    /**
     * Filter courses by type (free or paid).
     */
    private function filterByCourseType($query, ?string $courseType): void
    {
        if (! empty($courseType) && $courseType !== 'all') {
            $query->whereHas('courseSetting', function ($query) use ($courseType) {
                $query->where('is_free', $courseType === 'free' ? 1 : 0);
            });
        }
    }

    /**
     * Filter courses to include only verified instructors.
     */
    private function filterByVerifiedInstructors($query): void
    {
        $query->whereHas('instructors', function ($query) {
            $query->where('is_verify', 1)
                ->with('userable', function ($query) {
                    $query->where('status', 1);
                });
        });
    }

    protected function filterByUpcoming($query, ?string $courseType)
    {
        if (! empty($courseType)) {
            $query->whereHas('courseSetting', function ($query) {
                $query->where('is_upcoming', 1);
            });
        }
    }

    protected function filterByCourseId($query, $courseId)
    {
        if (! empty($courseId)) {
            $query->whereNot('id', $courseId);
        }
    }

    /**
     * Count models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function getCourseByUser($request, $options = [], $relations = []): array
    {
        try {

            // Get Model query instance.
            $model = static::$model::query();
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $model->{$option}(...$value);
                } elseif (empty($value)) {
                    $model->{$option}();
                } else {
                    $model->{$option}($value);
                }
            }

            if (! empty($request->organizations)) {
                $model->where(
                    function ($query) use ($request) {
                        if ($request->organizations) {
                            $query->withWhereHas(
                                'organization.organizationInstructors',
                                function ($query) use ($request) {
                                    $query->whereIn('id', $request->instructors);
                                }
                            );
                        } else {
                            $query->where('organization_id', $request->organizations);
                        }
                    }
                );
            } else {
                if (! empty($request->instructors)) {
                    $model->withWhereHas(
                        'instructors',
                        function ($query) use ($request) {
                            $query->whereIn('instructor_id', $request->instructors);
                            $query->with('userable');
                        }
                    );
                }
            }
            $countData = $model->withTrashed()->selectRaw('
          COUNT(*) as total,
          SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) as published,
          SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) as trashed
      ')->first();

            return [
                'status' => 'success',
                'data' => $countData,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Restore a model.
     *
     * @param  int  $id
     */
    public static function restoreUserCourse($id): array
    {
        // Get Model instance by $id.
        $response = parent::first($id);
        $model = $response['data'] ?? null;
        // Return model if saved successfully.
        if ($model && $model->trashed()) {
            $model->restore();
            return ['status' => 'success'];
        }
        return ['status' => 'success'];
    }

    public static function translate($course, $data, $locale)
    {
        $course->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
