<?php

namespace Modules\LMS\Repositories\Testimonial;

use Modules\LMS\Models\Testimonial;
use Modules\LMS\Repositories\BaseRepository;

class TestimonialRepository extends BaseRepository
{
    protected static $model = Testimonial::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['image', '_token', 'locale'],
        'update' => ['image', '_token', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|string',
            'designation' => 'required|string',
            'rating' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
            'comments' => 'required',
        ],
        'update' => [
            'name' => 'required|string',
            'designation' => 'required|string',
            'rating' => 'required',
            'comments' => 'required',
        ],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        if ($request->hasFile('image')) {
            $profileImg = parent::upload($request, fieldname: 'image', file: '', folder: 'lms/testimonials');
            $request->request->add(['profile_image' => $profileImg]);
        }
        $response = parent::save($request->all());
        $testimonial = $response['data'] ?? null;
        if ($response['status'] === 'success' && $testimonial) {
            $data = self::translateData($request->all());
            self::translate($testimonial, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {
        
        $testimonialResponse = parent::first(value: $id);
        $testimonial = $testimonialResponse['data'] ?? null;

        if (! $testimonial) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        $data = self::translateData($request->all());
        $defaultLanguage = app()->getLocale();
        self::translate(testimonial: $testimonial,  data: $data, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage !== $request->locale) {
            return [
                'status' => 'success',
                'data' => $testimonial,
            ];
        }

        if ($request->hasFile('image')) {
            static::$rules['update'] = [
                'image' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
            ];
            $profileImg = parent::upload($request, fieldname: 'image', file: $testimonial?->profile_image, folder: 'lms/testimonials');
            $request->request->add([
                'profile_image' => $profileImg,
            ]);
        }

        $testimonial = parent::update($id, $request->all());

        return $testimonial;
    }

    /**
     *  delete
     *
     * @param  $id  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $response = parent::first($id, withTrashed: true);
        $testimonial = $response['data'] ?? null;
        if ($response['status'] == 'success' && $testimonial) {

            $isDeleteAble = true;
            if (static::isSoftDeleteEnable() && ! $testimonial->trashed()) {
                $isDeleteAble = false;
            }

            if ($isDeleteAble) {
                parent::fileDelete(folder: 'lms/testimonials', file: $testimonial->profile_image);
            }
            return parent::delete($id, $data);
        }
        return $response;
    }

    /**
     *  statusChange
     */
    public function statusChange($id): array
    {
        $testimonial = parent::first($id);
        $testimonial = $testimonial['data'];
        $testimonial->status = ! $testimonial->status;
        $testimonial->update();

        return [
            'status' => 'success',
            'message' => translate('Status Change Successfully')
        ];
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
            'designation' => $data['designation'],
            'rating' => $data['rating'],
            'comments' => $data['comments'],
        ];

        return $data;
    }

    public static function translate($testimonial, $data, $locale)
    {
        $testimonial->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
