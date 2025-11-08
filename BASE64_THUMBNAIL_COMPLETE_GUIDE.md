# Complete Base64 Thumbnail Guide - Frontend & Backend

This guide shows you how to use base64 for thumbnails in both frontend and backend for **creating** and **updating** courses.

## Backend (Already Implemented ✅)

The backend already supports base64 thumbnails. It handles:
- Base64 data URI format: `data:image/png;base64,iVBORw0KGgo...`
- Raw base64 strings
- File uploads (FormData)
- Automatic conversion from binary to base64

## Frontend Implementation

### Step 1: Convert File to Base64

```javascript
/**
 * Convert a file to base64 data URI
 * @param {File} file - The image file
 * @returns {Promise<string>} - Base64 data URI string
 */
function fileToBase64(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file); // This creates: data:image/png;base64,...
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
}
```

### Step 2: Create Course with Base64 Thumbnail

```javascript
async function createCourse(courseData, thumbnailFile) {
  // Convert thumbnail to base64
  let thumbnailBase64 = null;
  if (thumbnailFile) {
    thumbnailBase64 = await fileToBase64(thumbnailFile);
  }
  
  const requestData = {
    form_key: 'basic',
    title: courseData.title,
    category_id: courseData.categoryId,
    short_description: courseData.shortDescription,
    description: courseData.description,
    duration: courseData.duration,
    time_zone_id: courseData.timeZoneId,
    video_src_type: courseData.videoSrcType,
    subject_id: courseData.subjectId,
    levels: courseData.levels, // Array of IDs
    instructors: courseData.instructors, // Array of IDs
    languages: courseData.languages, // Array of IDs
    thumbnail: thumbnailBase64, // Base64 string: "data:image/png;base64,..."
  };
  
  try {
    const response = await fetch('http://127.0.0.1:8000/admin/course', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'include', // Include cookies for auth
      body: JSON.stringify(requestData),
    });
    
    const result = await response.json();
    
    if (result.status === 'success') {
      console.log('Course created!', result);
      return result;
    } else {
      console.error('Error:', result);
      throw new Error(result.message || 'Failed to create course');
    }
  } catch (error) {
    console.error('Network error:', error);
    throw error;
  }
}
```

### Step 3: Update Course with Base64 Thumbnail

```javascript
async function updateCourseThumbnail(courseId, thumbnailFile) {
  // Convert thumbnail to base64
  const thumbnailBase64 = await fileToBase64(thumbnailFile);
  
  const requestData = {
    form_key: 'basic', // or 'media' for media form
    course_id: courseId, // IMPORTANT: Include course_id for updates
    thumbnail: thumbnailBase64, // Base64 string
    // Include other fields you want to update
    title: 'Updated Title', // Optional
  };
  
  try {
    const response = await fetch('http://127.0.0.1:8000/admin/course', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'include',
      body: JSON.stringify(requestData),
    });
    
    const result = await response.json();
    
    if (result.status === 'success') {
      console.log('Thumbnail updated!', result);
      // The response includes the updated course with new thumbnail URL
      console.log('New thumbnail URL:', result.course?.thumbnail);
      return result;
    } else {
      console.error('Error:', result);
      throw new Error(result.message || 'Failed to update thumbnail');
    }
  } catch (error) {
    console.error('Network error:', error);
    throw error;
  }
}
```

## Complete React Example

```jsx
import React, { useState } from 'react';

function CourseThumbnailForm({ courseId, onSuccess }) {
  const [thumbnailFile, setThumbnailFile] = useState(null);
  const [thumbnailPreview, setThumbnailPreview] = useState(null);
  const [uploading, setUploading] = useState(false);
  const [error, setError] = useState(null);

  // Convert file to base64
  const fileToBase64 = (file) => {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = () => resolve(reader.result);
      reader.onerror = (error) => reject(error);
    });
  };

  // Handle file selection
  const handleFileChange = async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
      setError('Invalid file type. Please upload jpg, png, or webp.');
      return;
    }

    // Validate file size (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
      setError('File size must be less than 2MB.');
      return;
    }

    setThumbnailFile(file);
    setError(null);

    // Create preview
    try {
      const base64 = await fileToBase64(file);
      setThumbnailPreview(base64);
    } catch (err) {
      console.error('Error creating preview:', err);
      setError('Error processing image');
    }
  };

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();
    
    if (!thumbnailFile) {
      setError('Please select a thumbnail image');
      return;
    }

    setUploading(true);
    setError(null);

    try {
      // Convert to base64
      const thumbnailBase64 = await fileToBase64(thumbnailFile);

      // Prepare request data
      const requestData = {
        form_key: courseId ? 'basic' : 'basic', // Use 'basic' for both create and update
        thumbnail: thumbnailBase64,
      };

      // Add course_id if updating
      if (courseId) {
        requestData.course_id = courseId;
      }

      // Send request
      const response = await fetch('http://127.0.0.1:8000/admin/course', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        credentials: 'include',
        body: JSON.stringify(requestData),
      });

      const result = await response.json();

      if (result.status === 'success') {
        console.log('Success!', result);
        onSuccess?.(result);
        // Clear form
        setThumbnailFile(null);
        setThumbnailPreview(null);
        // Reload page or update UI
        window.location.reload(); // Or update state
      } else {
        setError(result.message || 'Upload failed');
      }
    } catch (err) {
      console.error('Upload error:', err);
      setError('Network error. Please try again.');
    } finally {
      setUploading(false);
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <div>
        <label>
          Course Thumbnail (300x300 recommended)
          <input
            type="file"
            accept="image/jpeg,image/jpg,image/png,image/webp"
            onChange={handleFileChange}
            disabled={uploading}
          />
        </label>
        {error && <div style={{ color: 'red' }}>{error}</div>}
      </div>

      {thumbnailPreview && (
        <div>
          <h3>Preview:</h3>
          <img 
            src={thumbnailPreview} 
            alt="Thumbnail preview" 
            style={{ maxWidth: '300px', maxHeight: '300px' }}
          />
        </div>
      )}

      <button type="submit" disabled={!thumbnailFile || uploading}>
        {uploading ? 'Uploading...' : courseId ? 'Update Thumbnail' : 'Upload Thumbnail'}
      </button>
    </form>
  );
}

export default CourseThumbnailForm;
```

## Plain JavaScript Example (No Framework)

```html
<!DOCTYPE html>
<html>
<head>
  <title>Course Thumbnail Upload</title>
</head>
<body>
  <form id="thumbnailForm">
    <input type="file" id="thumbnailInput" accept="image/*" />
    <img id="preview" style="max-width: 300px; display: none;" />
    <button type="submit">Upload Thumbnail</button>
    <div id="error" style="color: red;"></div>
    <div id="success" style="color: green;"></div>
  </form>

  <script>
    const form = document.getElementById('thumbnailForm');
    const input = document.getElementById('thumbnailInput');
    const preview = document.getElementById('preview');
    const errorDiv = document.getElementById('error');
    const successDiv = document.getElementById('success');

    // Convert file to base64
    function fileToBase64(file) {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
      });
    }

    // Show preview when file is selected
    input.addEventListener('change', async (e) => {
      const file = e.target.files[0];
      if (file) {
        try {
          const base64 = await fileToBase64(file);
          preview.src = base64;
          preview.style.display = 'block';
          errorDiv.textContent = '';
        } catch (err) {
          errorDiv.textContent = 'Error processing image';
        }
      }
    });

    // Handle form submission
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const file = input.files[0];
      if (!file) {
        errorDiv.textContent = 'Please select a file';
        return;
      }

      try {
        // Convert to base64
        const thumbnailBase64 = await fileToBase64(file);

        // Get course ID from URL or input
        const courseId = prompt('Enter Course ID (leave empty for new course):') || null;

        // Prepare request data
        const requestData = {
          form_key: 'basic',
          thumbnail: thumbnailBase64,
        };

        if (courseId) {
          requestData.course_id = courseId;
        }

        // Send request
        const response = await fetch('http://127.0.0.1:8000/admin/course', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          credentials: 'include',
          body: JSON.stringify(requestData),
        });

        const result = await response.json();

        if (result.status === 'success') {
          successDiv.textContent = 'Thumbnail uploaded successfully!';
          errorDiv.textContent = '';
          console.log('New thumbnail URL:', result.course?.thumbnail);
          // Reload page after 2 seconds
          setTimeout(() => window.location.reload(), 2000);
        } else {
          errorDiv.textContent = result.message || 'Upload failed';
          successDiv.textContent = '';
        }
      } catch (err) {
        errorDiv.textContent = 'Network error: ' + err.message;
        successDiv.textContent = '';
      }
    });
  </script>
</body>
</html>
```

## Important Notes

### 1. Always Include `course_id` for Updates
```javascript
// ✅ CORRECT - For updating existing course
{
  form_key: 'basic',
  course_id: 123, // REQUIRED for updates
  thumbnail: base64String
}

// ❌ WRONG - Missing course_id (will create new course)
{
  form_key: 'basic',
  thumbnail: base64String
}
```

### 2. Base64 Format
The backend accepts:
- ✅ `data:image/png;base64,iVBORw0KGgo...` (data URI - recommended)
- ✅ `iVBORw0KGgo...` (raw base64 - also works)

### 3. File Size Limits
- Base64 increases file size by ~33%
- Keep images under 2MB for best performance
- Backend has PHP `upload_max_filesize` and `post_max_size` limits

### 4. Response Format
After successful upload, the response includes:
```json
{
  "status": "success",
  "course_id": 123,
  "course": {
    "id": 123,
    "thumbnail": "http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/lms-xxxxx.jpg?v=1234567890",
    "thumbnail_filename": "lms-xxxxx.jpg",
    "file_exists": true
  }
}
```

## Testing

1. **Test Create:**
   ```javascript
   const file = document.querySelector('input[type="file"]').files[0];
   const base64 = await fileToBase64(file);
   await createCourse({ title: 'Test' }, file);
   ```

2. **Test Update:**
   ```javascript
   const file = document.querySelector('input[type="file"]').files[0];
   await updateCourseThumbnail(123, file);
   ```

3. **Check Logs:**
   ```bash
   tail -f storage/logs/laravel.log | grep thumbnail
   ```

## Troubleshooting

### Issue: Thumbnail not updating
- ✅ Check if `course_id` is included in request
- ✅ Check browser console for errors
- ✅ Check Laravel logs for upload errors
- ✅ Verify base64 string is not empty
- ✅ Hard refresh browser (Ctrl+F5)

### Issue: Base64 too large
- ✅ Compress image before converting to base64
- ✅ Use FormData with file upload instead
- ✅ Increase PHP `post_max_size` in php.ini

### Issue: CORS errors
- ✅ Ensure `credentials: 'include'` is set
- ✅ Check backend CORS configuration
- ✅ Verify authentication cookies are sent

## Summary

1. **Frontend:** Convert file to base64 using `FileReader.readAsDataURL()`
2. **Frontend:** Send base64 in JSON with `Content-Type: application/json`
3. **Backend:** Automatically detects and processes base64
4. **Backend:** Saves file and updates database
5. **Response:** Returns updated course with thumbnail URL

The backend is already set up to handle base64 - you just need to send it correctly from the frontend!

