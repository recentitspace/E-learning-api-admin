<?php

namespace Modules\LMS\Repositories\General;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Repositories\BaseRepository;

class ThemeSettingRepository extends BaseRepository
{
    protected static $model = ThemeSetting::class;

    protected static $exactSearchFields = [];

    /**
     *  updateOrCreate
     *
     * @param  mixed  $request
     * @return array
     */
    public function updateOrCreate($request): array
    {
        static::$model::updateOrCreate(['key' => $request->key ?? ''], [
            'key' => $request->key,
            'content' => json_encode($request->except('_method', '_token', 'key')),
        ]);

        return [
            'status' => 'success',
            'message' => translate('Change Successfully')
        ];
    }


    public static function base64ImgUpload($requesFile, $file, $folder)
    {

        if (preg_match('/^data:image\/(\w+);base64,/', $requesFile, $matches)) {
            $extension = $matches[1]; // Extracts "png", "jpg", etc.
        } else {
            $extension = 'webp'; // Default fallback
        }
        // Remove the Base64 prefix
        $base64String = preg_replace('#^data:image/\w+;base64,#i', '', $requesFile);

        // Decode Base64
        $image = base64_decode($base64String);

        if ($image === false) {

            return [
                'status' => 'error',
                'message' => translate('Invalid Base64 image data.'),
            ];
        }
        // Generate Image Name
        $imageName = 'lms-' . Str::random(10) . '.' . ($extension === 'svg+xml' ? 'svg' : $extension);

        // Handle File Storage
        if (!empty($file)) {
            $filePath = 'public/' . $folder . '/' . $file;
            if (Storage::disk('LMS')->exists($filePath)) {
                Storage::disk('LMS')->delete($filePath);
            }
        }
        // Save the image
        Storage::disk('LMS')->put('public/' . $folder . '/' . $imageName, $image);

        return [
            'imageName' => $imageName,
            'path' => asset('storage/' . $folder . '/' . $imageName),
        ];
    }
    /**
     *  statusChange
     *
     * @param  int  $id
     * @return array
     */
    public function statusChange($id)
    {
        $language = parent::first($id);
        $language = $language['data'];
        $language->status = ! $language->status;
        $language->update();

        return ['status' => 'success', 'message' => translate('Status Change Successfully')];
    }
}
