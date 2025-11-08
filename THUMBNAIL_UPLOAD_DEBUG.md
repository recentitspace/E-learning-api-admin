# Thumbnail Upload Debug Guide

## Problem
Thumbnails are not uploading on both create and update operations.

## Enhanced Logging Added

I've added comprehensive logging to track the entire upload process. Check these logs to identify where the upload is failing.

## How to Debug

### 1. Check Laravel Logs
```bash
tail -f storage/logs/laravel.log | grep -i thumbnail
```

Or open: `storage/logs/laravel.log` and search for "thumbnail"

### 2. Look for These Log Entries

#### Successful Upload:
```
[INFO] handleThumbnailUpload called
[INFO] File thumbnail uploaded successfully: lms-abc123.jpg
[INFO] New thumbnail uploaded successfully
```

#### Failed Upload:
```
[ERROR] File thumbnail upload failed: [error message]
[ERROR] Base64 thumbnail upload failed: [error message]
[WARNING] Thumbnail not updated - same or empty
```

### 3. Check What's Being Sent

The logs now show:
- Whether file or base64 is being sent
- Data length and preview
- Old vs new thumbnail comparison
- Any exceptions thrown

## Common Issues & Solutions

### Issue 1: File Upload Not Detected
**Log shows:** `has_file: false`
**Solution:**
- Check form has `enctype="multipart/form-data"`
- Verify field name is `thumbnail`
- Check file size limits in `php.ini`

### Issue 2: Base64 Not Recognized
**Log shows:** `Thumbnail data does not appear to be valid base64`
**Solution:**
- Ensure base64 string is complete
- Check if it starts with `data:image/` or is raw base64
- Verify base64 string is not corrupted

### Issue 3: Directory Permissions
**Log shows:** `Failed to save image file to storage`
**Solution:**
```powershell
# Check directory exists
Test-Path "Modules\LMS\storage\app\public\lms\courses\thumbnails"

# Check permissions (Windows)
icacls "Modules\LMS\storage\app\public\lms\courses\thumbnails"
```

### Issue 4: Storage Disk Not Working
**Log shows:** Storage errors
**Solution:**
```php
// Test in tinker
php artisan tinker
Storage::disk('LMS')->put('public/lms/courses/thumbnails/test.txt', 'test');
Storage::disk('LMS')->exists('public/lms/courses/thumbnails/test.txt');
```

## Testing Steps

### 1. Test File Upload
```javascript
// In frontend
const formData = new FormData();
formData.append('thumbnail', fileInput.files[0]);
formData.append('form_key', 'basic');
formData.append('title', 'Test Course');

fetch('/admin/course', {
  method: 'POST',
  body: formData
});
```

### 2. Test Base64 Upload
```javascript
// In frontend
const base64String = 'data:image/png;base64,iVBORw0KGgo...';

fetch('/admin/course', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  },
  body: JSON.stringify({
    form_key: 'basic',
    title: 'Test Course',
    thumbnail: base64String
  })
});
```

### 3. Check Response
```javascript
const response = await fetch('/admin/course', {...});
const result = await response.json();
console.log(result); // Check for errors
```

## Manual Testing

### 1. Check Directory
```powershell
Get-ChildItem "Modules\LMS\storage\app\public\lms\courses\thumbnails"
```

### 2. Test Storage
```php
php artisan tinker

// Test write
Storage::disk('LMS')->put('public/lms/courses/thumbnails/test.txt', 'test');
echo Storage::disk('LMS')->exists('public/lms/courses/thumbnails/test.txt') ? 'OK' : 'FAIL';

// Test read
echo Storage::disk('LMS')->get('public/lms/courses/thumbnails/test.txt');
```

### 3. Check Database
```sql
SELECT id, title, thumbnail, updated_at 
FROM courses 
WHERE id = {course_id};
```

## What to Check in Logs

1. **Is handleThumbnailUpload being called?**
   - Look for: "handleThumbnailUpload called"

2. **What type of upload?**
   - `has_file: true` = File upload
   - `has_thumbnail_param: true` = Base64 upload

3. **Is upload succeeding?**
   - Look for: "uploaded successfully"
   - Or: "upload failed"

4. **Is thumbnail being saved to database?**
   - Check: "New thumbnail uploaded successfully"
   - Verify database has new filename

## Next Steps

1. **Upload a course with thumbnail**
2. **Check logs immediately**
3. **Share the log entries** so we can identify the exact issue

The enhanced logging will show exactly where the process is failing!

