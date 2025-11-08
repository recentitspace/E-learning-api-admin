# Frontend API Guide - Course Update with Base64 Thumbnail

## Endpoint
**URL:** `POST /admin/course` (or your admin course route)  
**Route Name:** `course.store`

## Request Headers (IMPORTANT)
Always include these headers to ensure JSON response:

```javascript
{
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN': 'your-csrf-token' // If using web routes
}
```

## Request Body Format

### Creating/Updating Course with Base64 Thumbnail

```javascript
{
  "form_key": "basic", // or "media" for updating thumbnail only
  "course_id": 1, // Include if updating existing course
  "title": "Course Title",
  "category_id": 1,
  "short_description": "Short description",
  "description": "Full description",
  "duration": "10 hours",
  "time_zone_id": 1,
  "video_src_type": "youtube", // or "local"
  "subject_id": 1,
  "levels": [1, 2], // Array of level IDs
  "instructors": [1], // Array of instructor IDs
  "languages": [1], // Array of language IDs
  "thumbnail": "data:image/png;base64,iVBORw0KGgoAAAANS..." // Base64 string
}
```

## Example: JavaScript/Fetch

```javascript
// Convert file to base64
const fileToBase64 = (file) => {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
};

// Update course with thumbnail
const updateCourse = async (courseId, courseData, thumbnailFile) => {
  let thumbnailBase64 = null;
  
  // Convert thumbnail to base64 if provided
  if (thumbnailFile) {
    thumbnailBase64 = await fileToBase64(thumbnailFile);
  }
  
  const requestData = {
    form_key: 'basic',
    course_id: courseId,
    title: courseData.title,
    category_id: courseData.categoryId,
    short_description: courseData.shortDescription,
    description: courseData.description,
    duration: courseData.duration,
    time_zone_id: courseData.timeZoneId,
    video_src_type: courseData.videoSrcType,
    subject_id: courseData.subjectId,
    levels: courseData.levels,
    instructors: courseData.instructors,
    languages: courseData.languages,
    thumbnail: thumbnailBase64, // Base64 string
  };

  try {
    const response = await fetch('http://127.0.0.1:8000/admin/course', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        // Add CSRF token if needed
        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      credentials: 'include', // Include cookies for session
      body: JSON.stringify(requestData),
    });

    const result = await response.json();
    
    if (result.status === 'success') {
      console.log('Course updated successfully:', result);
      return result;
    } else {
      console.error('Error:', result.message, result.errors);
      return result;
    }
  } catch (error) {
    console.error('Network error:', error);
    return { status: 'error', message: 'Network error' };
  }
};
```

## Response Format

### Success Response (200)
```json
{
  "status": "success",
  "course_id": 1,
  "form-key": "basic",
  "message": "Update Successfully",
  "url": "http://127.0.0.1:8000/admin/course/1/edit" // Only if new course
}
```

### Error Response (422 - Validation Error)
```json
{
  "status": "error",
  "message": "Validation failed",
  "data": {
    "title": ["The title field is required."],
    "category_id": ["The category id field is required."]
  },
  "errors": {
    "title": ["The title field is required."]
  }
}
```

### Error Response (403 - Permission)
```json
{
  "status": "error",
  "message": "You have no permission."
}
```

### Error Response (500 - Server Error)
```json
{
  "status": "error",
  "message": "Error message here",
  "data": []
}
```

## Important Notes

1. **Always include `Accept: application/json` header** - This ensures you get JSON instead of HTML
2. **Include CSRF token** if your routes require it (web middleware)
3. **Use `credentials: 'include'`** to send session cookies
4. **Base64 format**: Can be `data:image/png;base64,...` or just the base64 string
5. **form_key**: 
   - `"basic"` - For creating/updating basic course info (including thumbnail)
   - `"media"` - For updating only media (thumbnail, preview images)

## Troubleshooting

### Getting HTML instead of JSON?
- ✅ Add `Accept: application/json` header
- ✅ Add `X-Requested-With: XMLHttpRequest` header
- ✅ Check if you're authenticated
- ✅ Verify CSRF token if required

### Validation Errors?
- Check the `errors` or `data` field in the response
- Ensure all required fields are provided
- For `form_key: 'basic'`, thumbnail is required if creating new course

### Thumbnail Not Saving?
- Verify base64 string is valid
- Check Laravel logs: `storage/logs/laravel.log`
- Ensure directory exists: `Modules/LMS/storage/app/public/lms/courses/thumbnails/`

