<?php

namespace Modules\LMS\Repositories;

/**
 * BaseRepository class
 *
 * @author  Md Abu Ahsan Basir <abasir@nobilisgroup.com>
 */


use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Modules\LMS\Contracts\Repository;

abstract class BaseRepository implements Repository
{
    protected static $model;

    protected static $rules = [
        'save' => [],
        'update' => [],
    ];

    protected static $exactSearchFields = ['id'];

    protected static $excludedFields = [
        'save' => [],
        'update' => [],
    ];

    /**
     * Get all models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function all($options = [], $relations = []): array
    {
        return static::get($options, $relations);
    }

    /**
     * Get models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function get($options = [], $relations = [], $withTrashed = false): array
    {
        try {
            if (!is_array($options)) {
                $options = array($options);
            }

            if (! isset($options['latest']) && ! isset($options['groupBy'])) {
                $options = array_merge([
                    'orderBy' => ['updated_at', 'DESC'],
                ], $options);
            }

            // Get Model query instance.
            $query = static::$model::query();
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            if ($withTrashed && static::isSoftDeleteEnable()) {
                $query->withTrashed();
            }

            $models = $query->with($relations)->get();

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Count models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function trashCount($options = []): array
    {
        try {
            // Get Model query instance.
            $query = static::$model::query();
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            $countData = $query->withTrashed()->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN deleted_at IS NULL THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN deleted_at IS NOT NULL THEN 1 ELSE 0 END) as trashed
            ")->first();

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
     * Count models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function count($options = [], $relations = [], $withTrashed = false): array
    {
        try {
            if (!is_array($options)) {
                $options = array($options);
            }

            $options = array_merge([
                'orderBy' => ['updated_at', 'DESC'],
            ], $options);

            // Get Model query instance.
            $query = static::$model::query();
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            if ($withTrashed && static::isSoftDeleteEnable()) {
                $query->withTrashed();
            }

            $models = $query->with($relations)->count();

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Get models.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function paginate($item = 10, $relations = [], $options = [], $withTrashed = false): array
    {
        try {

            if (!is_array($options)) {
                $options = array($options);
            }

            $options = array_merge([
                'orderBy' => ['updated_at', 'DESC'],
            ], $options);

            // Get Model query instance.
            $query = static::$model::query();
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            if ($withTrashed && static::isSoftDeleteEnable()) {
                $query->withTrashed();
            }

            $models = $query->with($relations)->paginate($item);

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Get a model.
     *
     * @param  int  $id
     * @param  array  $relations
     */
    public static function first($value, $field = 'id', $relations = [], $options = [], $withTrashed = false): array
    {
        try {
            // Get first result.
            $query = static::$model::query();

            if (!is_array($options)) {
                $options = array($options);
            }

            $options = array_merge([
                'where' => [$field, $value],
            ], $options);

            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            if ($withTrashed && static::isSoftDeleteEnable()) {
                $query->withTrashed();
            }

            $model = $query->with($relations)->first();

            // Return model if data fetched successfully.
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
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Search model.
     *
     * @param  array  $data
     * @param  array  $options
     * @param  array  $relations
     */
    public static function search($data = [], $options = [], $relations = []): array
    {
        try {
            // Get Model query instance.
            $query = static::$model::query();
            // Set fields
            foreach ($data as $field => $value) {
                switch ($field) {
                    case in_array($field, static::$exactSearchFields):
                        $query->where($field, $value);
                        break;
                    default:
                        $query->where($field, 'LIKE', "%{$value}%");
                        break;
                }
            }
            // Set options.
            foreach ($options as $option => $value) {

                $keys = is_array($value) ? array_keys($value) : [];

                if ($keys && count($keys) === count(array_filter($keys, 'is_int'))) {
                    $query->{$option}(...$value);
                } else if (empty($value)) {
                    $query->{$option}();
                } else {
                    $query->{$option}($value);
                }
            }

            $models = $query->with($relations)->get();

            return [
                'status' => 'success',
                'data' => $models,
            ];
        } catch (Exception $ex) {
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Create a model.
     *
     * @param  array|object  $data
     */
    public static function save($data): array
    {
        try {
            // Check $data either array nor object otherwise return the error.
            if (! is_array($data) && ! is_object($data)) {
                return [
                    'status' => 'error',
                    'data' => ['You must provide data as associative array or object.'],
                ];
            }
            // If $data is object then convert into array.
            if (is_object($data)) {
                $data = (array) $data;
            }
            // Check validation.
            $rules = static::$rules['save'] ?? [];
            $validator = Validator::make($data, $rules);
            // If validation failed then return the error.
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()->toArray(),
                ];
            }
            // Create new Model instance.
            $model = new static::$model;
            $excludeRules = static::$excludedFields['save'] ?? [];
            // Bind all fields and values into model instance.
            foreach ($data as $field => $value) {
                if (! in_array($field, $excludeRules)) {
                    $model->{$field} = $value;
                }
            }
            // Save the model.
            $model->save();
            // Return model if saved successfully.
            if ($model) {
                return [
                    'status' => 'success',
                    'data' => $model,
                ];
            }

            // Return error if model not created successfully.
            return [
                'status' => 'error',
                'data' => 'There is a problem to create new model please check manually.',
            ];
        } catch (Exception $ex) {
            // Return exception error if someything happen wrong.
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Update a model.
     *
     * @param  int  $id
     * @param  array|object  $data
     */
    public static function update($id, $data): array
    {
        try {
            // Check $data either array nor object otherwise return the error.
            if (! is_array($data) && ! is_object($data)) {
                return [
                    'status' => 'error',
                    'data' => ['You must provide data as associative array or object.'],
                ];
            }
            // If $data is object then convert into array.
            if (is_object($data)) {
                $data = (array) $data;
            }
            // Check validation.
            $rules = static::$rules['update'] ?? [];
            $validator = Validator::make($data, $rules);
            // If validation failed then return the error.
            if ($validator->fails()) {
                return [
                    'status' => 'error',
                    'data' => $validator->errors()->toArray(),
                ];
            }
            // Create new Model instance.
            $model = static::$model::find($id);
            $excludeRules = static::$excludedFields['update'] ?? [];
            // Bind all fields and values into model instance.
            foreach ($data as $field => $value) {
                if (! in_array($field, $excludeRules)) {
                    $model->{$field} = $value;
                }
            }
            // Save the model.
            $model->save();
            // Return model if saved successfully.
            if ($model) {
                return [
                    'status' => 'success',
                    'data' => $model,
                ];
            }

            // Return error if model not created successfully.
            return [
                'status' => 'error',
                // 'data' => "Illuminate\Database\Eloquent\ModelNotFoundException with message No query results for model " . $model::class . " " . $id
                'data' => '404',
            ];
        } catch (Exception $ex) {
            // Return exception error if someything happen wrong.
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
            ];
        }
    }

    /**
     * Delete a model.
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        try {

            $isSoftDelete = static::isSoftDeleteEnable();

            if (!is_array($options)) {
                $options = (array) $options;
            }

            if ($isSoftDelete) {
                $options = array_merge([
                    'withTrashed' => [],
                ], $options);
            }

            if (! is_array($relations)) {
                $relations = (array) $relations;
            }

            if (method_exists(static::$model, 'translations')) {
                $relations[] = 'translations';
            }

            // Get Model instance by $id.
            $response = static::first(value: $id, options: $options, relations: $relations);
            $model = $response['data'] ?? null;
            // Return model if saved successfully.
            if ($model) {

                if ($isSoftDelete) {
                    if (! is_array($data)) {
                        $data = (array) $data;
                    }

                    foreach ($data as $field => $value) {

                        if (!property_exists($model, $field)) {
                            continue;
                        }

                        $model->{$field} = $value;
                    }

                    // This will helpful for soft delete. E.g: update status column.
                    $model->save();
                }

                $isTrashed = $isSoftDelete && $model->trashed();

                if (!$isSoftDelete || $isTrashed) {

                    foreach ($relations as $relation) {

                        if (method_exists($model, $relation)) {

                            $relationInstance = $model->{$relation}();

                            if ($relationInstance instanceof BelongsToMany || $relationInstance instanceof MorphToMany) {
                                $relationInstance->detach();
                                continue;
                            }

                            if ($relationInstance instanceof HasMany || $relationInstance instanceof MorphMany) {
                                $relationInstance->delete();
                                continue;
                            }

                            if ($relationInstance instanceof HasOne || $relationInstance instanceof MorphOne) {
                                optional($relationInstance->first())->delete();
                                continue;
                            }

                            if ($relationInstance instanceof BelongsTo) {
                                $foreignKey = $relationInstance->getForeignKeyName();
                                $model->{$foreignKey} = null;
                                $model->save();
                            }
                        }
                    }
                }

                $isDeleted = $isTrashed ? $model->forceDelete() : $model->delete();

                if ($isDeleted) {
                    return [
                        'status' => 'success',
                        'data' => $model,
                    ];
                }
            }

            // Return error if model not created successfully.
            return [
                'status' => 'error',
                // 'data' => "Illuminate\Database\Eloquent\ModelNotFoundException with message No query results for model " . $model::class . " " . $id
                'data' => '404',

            ];
        } catch (Exception $ex) {
            // Return exception error if someything happen wrong.
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
    public static function restore($id): array
    {
        try {

            if (! static::isSoftDeleteEnable()) {
                return [
                    'status' => 'error',
                    'data' => 'The model doesn\'t enable soft delete',
                ];
            }
            // Get Model instance by $id.
            $model = static::$model::where('id', $id)->withTrashed()->first();

            // Return model if saved successfully.
            if ($model && $model->trashed()) {
                $model->restore();

                return [
                    'status' => 'success',
                    'data' => $model,
                ];
            }

            // Return error if model not created successfully.
            return [
                'status' => 'error',
                // 'data' => "Illuminate\Database\Eloquent\ModelNotFoundException with message No query results for model " . $model::class . " " . $id
                'data' => '404',

            ];
        } catch (Exception $ex) {
            // Return exception error if someything happen wrong.
            return [
                'status' => 'error',
                'data' => $ex->getMessage(),
                'file' => $ex->getFile(),
                'line' => $ex->getLine(),
            ];
        }
    }

    public static function isSoftDeleteEnable($model = null)
    {
        if (! $model) {
            $model = static::$model;
        }
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(static::$model));
    }

    /**
     * Method upload
     *
     * @param  mixed  $request
     * @param  string  $fieldname
     * @param  string  $file
     * @param  string  $folder
     */
    public static function upload($request, $fieldname, $file, $folder)
    {
        if ($request->hasFile($fieldname)) {
            $source = $request->file($fieldname);
            $image_name = 'lms' . '-' . Str::random(8) . '.' . str_replace(' ', '-', $source->getClientOriginalExtension());
            if ($file != '') {
                if (Storage::disk('LMS')->exists('public/' . $folder . '/' . $file)) {
                    Storage::disk('LMS')->delete('public/' . $folder . '/' . $file);
                }
            }
            $source->storeAs('public/' . $folder, $image_name, 'LMS');

            return $image_name;
        }
    }

    /**
     *  base64ImgUpload
     *
     * @param  string  $requesFile
     * @param  string  $file
     * @param  string  $folder
     */
    public static function base64ImgUpload($requesFile, $file, $folder)
    {
        $count = 0;
        $extension = explode('/', mime_content_type($requesFile))[1];
        str_replace('data:image/svg+xml;base64,', '', $requesFile, $count);
        if ($count > 0) {
            $image = base64_decode(str_replace('data:image/svg+xml;base64,', '', $requesFile));
            $imageName = 'lms' . '-' . Str::random(10) . '.svg';
        } else {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $requesFile));
            $imageName = 'lms' . '-' . Str::random(10) . '.' . 'webp';
        }
        if ($file != '') {
            if (Storage::disk('LMS')->exists('public/' . $folder . '/' . $file)) {
                Storage::disk('LMS')->delete('public/' . $folder . '/' . $file);
            }
        }

        Storage::disk('LMS')->put('public/' . $folder . '/' . $imageName, contents: $image);

        return [
            'imageName' => $imageName,
            'path' => asset('storage/' . $folder . '/' . $imageName),
        ];
    }

    /**
     * file delete
     *
     * @param  string folderName
     * @param  string file
     * @return true|false
     */
    public static function fileDelete($folder, $file)
    {
        if (Storage::disk('LMS')->exists('public/' . $folder . '/' . $file)) {
            Storage::disk('LMS')->delete('public/' . $folder . '/' . $file);
        }

        return true;
    }


    public function restoreOrTrash($id)
    {
        $data = static::$model::withTrashed()->find($id);
        $data->trashed() ?  $data->restore() :  $data->delete();
        return [
            'status' => 'success',
        ];
    }
}
