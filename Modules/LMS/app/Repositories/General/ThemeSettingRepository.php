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
        // Extract mime type and base64 data
        if (preg_match('/^data:image\/(\w+);base64,/', $requesFile, $matches)) {
            $extension = $matches[1]; // Extracts "png", "jpg", etc.
            $base64String = preg_replace('#^data:image/\w+;base64,#i', '', $requesFile);
        } else {
            // If no data URI prefix, assume it's raw base64
            $base64String = $requesFile;
            $extension = 'png'; // Default fallback
        }

        // Decode Base64
        $image = base64_decode($base64String, true); // Use strict mode

        if ($image === false || empty($image)) {
            return [
                'status' => 'error',
                'message' => translate('Invalid Base64 image data.'),
            ];
        }
        
        // Generate Image Name
        $imageName = 'lms-' . Str::random(10) . '.' . ($extension === 'svg+xml' ? 'svg' : $extension);

        // Ensure directory exists
        $directoryPath = 'public/' . $folder;
        if (!Storage::disk('LMS')->exists($directoryPath)) {
            Storage::disk('LMS')->makeDirectory($directoryPath);
        }

        // Handle File Storage - delete old file if exists
        if (!empty($file) && $file != null) {
            $oldFilePath = 'public/' . $folder . '/' . $file;
            if (Storage::disk('LMS')->exists($oldFilePath)) {
                Storage::disk('LMS')->delete($oldFilePath);
            }
        }
        
        // Save the image
        $filePath = 'public/' . $folder . '/' . $imageName;
        $saved = Storage::disk('LMS')->put($filePath, $image);
        
        if (!$saved) {
            return [
                'status' => 'error',
                'message' => translate('Failed to save image file to storage.'),
            ];
        }
        
        // Verify file was actually saved
        if (!Storage::disk('LMS')->exists($filePath)) {
            return [
                'status' => 'error',
                'message' => translate('File was not saved - verification failed.'),
            ];
        }

        return [
            'imageName' => $imageName,
            'path' => url('storage/lms/' . ltrim($folder, '/') . '/' . $imageName),
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
