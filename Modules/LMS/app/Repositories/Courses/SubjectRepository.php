<?php

namespace Modules\LMS\Repositories\Courses;

use Modules\LMS\Models\Courses\Subject;
use Modules\LMS\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository
{
    protected static $model = Subject::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'thumbnail', 'locale'],
        'update' => ['_token', 'thumbnail', '_method', 'locale'],
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required|unique:subjects,name',
            'thumbnail' => 'required|image|mimes:webp,jpeg,jpg,png,svg',

        ],
        'update' => [],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        $image = parent::upload($request, fieldname: 'thumbnail', file: '', folder: 'lms/subjects');
        $request->request->add([
            'image' => $image,
        ]);

        $response = parent::save($request->all());
        $subject = $response['data'] ?? null;

        if ($response['status'] === 'success' && $subject) {
            $data = self::translateData($request->all());
            self::translate($subject, $data, locale: $request->locale ?? app()->getLocale());
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $request): array
    {

        $subject = parent::first($id);
        $subject = $subject['data'];

        if (! $subject) {
            return [
                'status' => 'error',
                'data' => 'The model not found.',
            ];
        }

        if ($request->hasFile('thumbnail')) {
            static::$rules['update'] = [
                'thumbnail' => 'required|image|mimes:webp,jpeg,jpg,png,svg',
            ];
            $image = parent::upload($request, fieldname: 'thumbnail', file: $subject?->image, folder: 'lms/subjects');
            $request->request->add([
                'image' => $image,
            ]);
        }
        static::$rules['update'] = [
            'name' => 'required|unique:subjects,name,' . $id,
        ];

        $data = self::translateData($request->all());
        $defaultLanguage = app()->getLocale();
        self::translate(subject: $subject,  data: $data, locale: $request->locale);

        if ($request->locale &&  $defaultLanguage !== $request->locale) {
            return [
                'status' => 'success',
                'data' => $subject,
            ];
        }

        return parent::update($id, $request->all());
    }
    /**
     *  delete
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $response = parent::first($id, withTrashed: true);
        $subject = $response['data'] ?? null;
        if ($subject && $response['status'] == 'success') {
            $isDeleteAble = true;
            if (static::isSoftDeleteEnable() && ! $subject->trashed()) {
                $isDeleteAble = false;
            }

            if ($isDeleteAble) {
                parent::fileDelete(folder: 'lms/subjects', file: $subject->thumbnail);
            }

            return parent::delete(id: $id);
        }

        return $response;
    }

    public static function translateData(array $data)
    {
        $data = [
            'name' => $data['name'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
        ];

        return $data;
    }

    public static function translate($subject, $data, $locale)
    {
        $subject->translations()->updateOrCreate(['locale' => $locale], [
            'locale' => $locale,
            'data' => $data
        ]);
    }
}
