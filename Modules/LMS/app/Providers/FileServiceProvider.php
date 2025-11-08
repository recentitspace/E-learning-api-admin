<?php

namespace Modules\LMS\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        $this->registerStorage();
        $this->registerStorageRoutes();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    protected function registerStorage()
    {
        $module = 'LMS';
        Config::set(
            'filesystems.disks.'.$module,
            [
                'driver' => 'local',
                'root' => module_path($module).DIRECTORY_SEPARATOR.'storage'.DIRECTORY_SEPARATOR.'app',
                'url' => env('APP_URL').'/storage',
                'visibility' => 'public',
                'throw' => false,
            ]
        );
    }

    /**
     * Register routes to serve files from LMS storage
     * This allows files to be accessed via /storage/lms/... without requiring symlinks
     */
    protected function registerStorageRoutes()
    {
        // Register route to serve files from LMS storage
        // Use booted callback to ensure routes are registered after app is fully booted
        $this->app->booted(function () {
            Route::get('/storage/lms/{path}', function (Request $request, string $path) {
                try {
                    $disk = Storage::disk('LMS');
                    // Path comes as: courses/thumbnails/filename.jpg (without 'lms/' prefix)
                    // File is stored at: public/lms/courses/thumbnails/filename.jpg
                    // So we need: public/lms/ + path
                    $cleanPath = ltrim($path, '/');
                    $filePath = 'public/lms/' . $cleanPath;
                    
                    // Check if file exists
                    if (!$disk->exists($filePath)) {
                        \Log::warning('File not found in LMS storage', [
                            'path' => $filePath,
                            'request_path' => $path
                        ]);
                        abort(404, 'File not found');
                    }
                    
                    // Get file contents
                    $fileContents = $disk->get($filePath);
                    
                    if ($fileContents === false || empty($fileContents)) {
                        \Log::error('Failed to read file from LMS storage', [
                            'path' => $filePath
                        ]);
                        abort(500, 'Failed to read file');
                    }
                    
                    // Determine file extension for proper content type
                    $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    $contentTypes = [
                        'jpg' => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'gif' => 'image/gif',
                        'webp' => 'image/webp',
                        'svg' => 'image/svg+xml',
                        'pdf' => 'application/pdf',
                        'mp4' => 'video/mp4',
                        'mp3' => 'audio/mpeg',
                        'wav' => 'audio/wav',
                        'ogg' => 'audio/ogg',
                    ];
                    
                    $contentType = $contentTypes[$extension] ?? $disk->mimeType($filePath) ?? 'application/octet-stream';
                    
                    return response($fileContents, 200)
                        ->header('Content-Type', $contentType)
                        ->header('Cache-Control', 'public, max-age=31536000')
                        ->header('Content-Length', strlen($fileContents))
                        ->header('Accept-Ranges', 'bytes');
                } catch (\Exception $e) {
                    \Log::error('Error serving file from LMS storage', [
                        'path' => $path,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    abort(500, 'Error serving file');
                }
            })->where('path', '.*')->name('lms.storage');
        });
    }
}
