<?php

/**
 * Thumbnail Debug Test Script
 * 
 * Run this to check if thumbnails are uploading and fetching correctly
 * Usage: php test_thumbnail_debug.php [course_id]
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$courseId = $argv[1] ?? 1;

echo "========================================\n";
echo "THUMBNAIL DEBUG TEST\n";
echo "========================================\n\n";

try {
    // Get course
    $course = \Modules\LMS\app\Models\Course::find($courseId);
    
    if (!$course) {
        echo "❌ Course ID {$courseId} not found!\n";
        exit(1);
    }
    
    echo "✅ Course Found:\n";
    echo "   ID: {$course->id}\n";
    echo "   Title: {$course->title}\n";
    echo "   Updated: {$course->updated_at}\n\n";
    
    // Check database
    echo "📊 DATABASE CHECK:\n";
    $thumbnail = $course->thumbnail;
    if (empty($thumbnail)) {
        echo "   ❌ Thumbnail field is EMPTY in database\n";
    } else {
        echo "   ✅ Thumbnail in DB: {$thumbnail}\n";
    }
    echo "\n";
    
    // Check file exists
    echo "📁 FILE SYSTEM CHECK:\n";
    if ($thumbnail) {
        $filePath = 'Modules/LMS/storage/app/public/lms/courses/thumbnails/' . $thumbnail;
        $fullPath = __DIR__ . '/' . $filePath;
        
        if (file_exists($fullPath)) {
            $fileSize = filesize($fullPath);
            $fileTime = date('Y-m-d H:i:s', filemtime($fullPath));
            echo "   ✅ File EXISTS on disk\n";
            echo "      Path: {$filePath}\n";
            echo "      Size: " . number_format($fileSize) . " bytes\n";
            echo "      Modified: {$fileTime}\n";
        } else {
            echo "   ❌ File NOT FOUND on disk\n";
            echo "      Expected: {$fullPath}\n";
        }
    } else {
        echo "   ⚠️  Cannot check file - no thumbnail in database\n";
    }
    echo "\n";
    
    // Check storage disk
    echo "💾 STORAGE DISK CHECK:\n";
    try {
        $disk = \Illuminate\Support\Facades\Storage::disk('LMS');
        if ($thumbnail) {
            $storagePath = 'public/lms/courses/thumbnails/' . $thumbnail;
            if ($disk->exists($storagePath)) {
                echo "   ✅ File exists in Storage disk\n";
                echo "      Storage path: {$storagePath}\n";
                $size = $disk->size($storagePath);
                echo "      Size: " . number_format($size) . " bytes\n";
            } else {
                echo "   ❌ File NOT found in Storage disk\n";
                echo "      Storage path: {$storagePath}\n";
            }
        } else {
            echo "   ⚠️  Cannot check storage - no thumbnail in database\n";
        }
    } catch (\Exception $e) {
        echo "   ❌ Storage disk error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // Check URL generation
    echo "🔗 URL GENERATION CHECK:\n";
    if ($thumbnail) {
        try {
            $url = url('storage/lms/lms/courses/thumbnails/' . $thumbnail);
            echo "   ✅ URL generated: {$url}\n";
            
            // Test if route exists
            $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('lms.storage');
            if ($route) {
                echo "   ✅ Storage route is registered\n";
            } else {
                echo "   ⚠️  Storage route not found (might use symlink)\n";
            }
        } catch (\Exception $e) {
            echo "   ❌ URL generation error: " . $e->getMessage() . "\n";
        }
    } else {
        echo "   ⚠️  Cannot generate URL - no thumbnail in database\n";
    }
    echo "\n";
    
    // Check helper function
    echo "🛠️  HELPER FUNCTION CHECK:\n";
    try {
        if (function_exists('getThumbnailUrl')) {
            $helperUrl = getThumbnailUrl($thumbnail, 'lms/courses/thumbnails');
            echo "   ✅ Helper function exists\n";
            echo "   Helper URL: {$helperUrl}\n";
        } else {
            echo "   ⚠️  getThumbnailUrl() helper not found\n";
        }
    } catch (\Exception $e) {
        echo "   ❌ Helper function error: " . $e->getMessage() . "\n";
    }
    echo "\n";
    
    // Check recent logs
    echo "📝 RECENT LOGS CHECK:\n";
    $logFile = storage_path('logs/laravel.log');
    if (file_exists($logFile)) {
        $logs = file_get_contents($logFile);
        $thumbnailLogs = [];
        $lines = explode("\n", $logs);
        $thumbnailLines = array_filter($lines, function($line) {
            return stripos($line, 'thumbnail') !== false;
        });
        
        $recentLogs = array_slice($thumbnailLines, -10);
        if (!empty($recentLogs)) {
            echo "   ✅ Found thumbnail-related logs:\n";
            foreach ($recentLogs as $log) {
                echo "      " . substr($log, 0, 100) . "...\n";
            }
        } else {
            echo "   ⚠️  No recent thumbnail logs found\n";
        }
    } else {
        echo "   ⚠️  Log file not found: {$logFile}\n";
    }
    echo "\n";
    
    // Summary
    echo "========================================\n";
    echo "SUMMARY:\n";
    echo "========================================\n";
    
    $issues = [];
    if (empty($thumbnail)) {
        $issues[] = "❌ No thumbnail in database";
    }
    if ($thumbnail && !file_exists(__DIR__ . '/Modules/LMS/storage/app/public/lms/courses/thumbnails/' . $thumbnail)) {
        $issues[] = "❌ File not found on disk";
    }
    
    if (empty($issues)) {
        echo "✅ Everything looks good!\n";
        echo "   If images still not showing, check:\n";
        echo "   1. Browser cache (Ctrl+F5)\n";
        echo "   2. Route registration (php artisan route:list | findstr lms.storage)\n";
        echo "   3. File permissions\n";
    } else {
        echo "⚠️  Issues found:\n";
        foreach ($issues as $issue) {
            echo "   {$issue}\n";
        }
        echo "\n";
        echo "Next steps:\n";
        echo "1. Check Laravel logs: storage/logs/laravel.log\n";
        echo "2. Try uploading a new thumbnail\n";
        echo "3. Check file permissions on storage directory\n";
    }
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

echo "\n";

