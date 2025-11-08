# Fix Storage 404 Error

## Current Issues
1. **Symlink Missing**: `public/storage` symlink doesn't exist
2. **File Not Found**: The requested file `lms-UcJoN6FigA.png` doesn't exist in storage

## Solution Steps

### Step 1: Create the Storage Symlink

**Run PowerShell as Administrator** and execute:

```powershell
cd D:\Abdirizak\Projects\elearning\backend

# Remove if exists (as directory)
if (Test-Path "public\storage") {
    Remove-Item "public\storage" -Recurse -Force
}

# Create symlink
New-Item -ItemType SymbolicLink -Path "public\storage" -Target "Modules\LMS\storage\app\public"
```

**OR use Command Prompt as Administrator:**

```cmd
cd D:\Abdirizak\Projects\elearning\backend
rmdir /s /q public\storage
mklink /D public\storage Modules\LMS\storage\app\public
```

### Step 2: Verify Symlink

```powershell
Get-Item public\storage | Select-Object Target, LinkType
```

Should show:
- **LinkType**: SymbolicLink
- **Target**: Modules\LMS\storage\app\public

### Step 3: Check File Existence

The file `lms-UcJoN6FigA.png` should exist at:
```
Modules\LMS\storage\app\public\lms\theme-options\lms-UcJoN6FigA.png
```

If it doesn't exist, the upload might have failed. Check:
1. Laravel logs: `storage\logs\laravel.log`
2. File permissions on `Modules\LMS\storage\app\public`
3. Upload functionality - try uploading again

### Step 4: Test Access

After creating the symlink, test:
```
http://127.0.0.1:8000/storage/lms/theme-options/lms-UcJoN6FigA.png
```

## Alternative: Use Route-Based File Serving

If symlinks don't work on Windows, you can configure Laravel to serve files via routes by updating `config/filesystems.php`:

```php
'public' => [
    'driver' => 'local',
    'root' => base_path('Modules/LMS/storage/app/public'),
    'url' => env('APP_URL') . '/storage',
    'visibility' => 'public',
    'throw' => false,
    'serve' => true, // Add this
],
```

But the symlink method is recommended.

## Troubleshooting

### Permission Denied
- Run PowerShell/CMD as **Administrator**
- Check folder permissions on `Modules\LMS\storage\app\public`

### File Still Not Found
1. Check if file was actually saved
2. Check Laravel logs for upload errors
3. Verify base64 upload is working
4. Check file permissions

### Still Getting 404
1. Clear Laravel cache: `php artisan cache:clear`
2. Clear route cache: `php artisan route:clear`
3. Restart web server
4. Check `.htaccess` or web server configuration

