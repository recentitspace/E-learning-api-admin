# Course Thumbnail Upload & Display Guide

## Overview

This guide explains how to save course thumbnails in the backend and display them in your frontend application.

---

## Backend Configuration

### 1. Storage Setup

The backend uses Laravel's storage system with a custom `LMS` disk. Files are stored in:
```
Modules/LMS/storage/app/public/lms/courses/thumbnails/
```

**Important:** Make sure the storage symlink is created:
```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `Modules/LMS/storage/app/public`, allowing public access to uploaded files.

### 2. Database Structure

The `courses` table has a `thumbnail` column that stores the filename (not the full path):
- **Column:** `thumbnail` (string, nullable)
- **Stored Value:** Just the filename, e.g., `lms-abc12345.jpg`
- **Full Path:** Constructed as `storage/lms/courses/thumbnails/{filename}`

---

## Uploading Course Thumbnail

### Backend Endpoint

The backend handles course creation/updates through the LMS module's course repository. Based on the codebase, thumbnails are uploaded when:
- Creating a new course (basic form)
- Updating course media (media form)

### Supported File Formats

- **Images:** jpg, jpeg, png, bmp, tiff, webp, svg
- **Recommended Size:** 300x300 pixels (as mentioned in the form)
- **Field Name:** `thumbnail`

### Upload Process

1. **File is uploaded** via `FormData` with field name `thumbnail`
2. **Backend processes** it using `handleThumbnailUpload()` method
3. **File is saved** with a random name: `lms-{8randomchars}.{extension}`
4. **Filename is stored** in the `courses.thumbnail` column

---

## Frontend Implementation

### 1. Uploading Thumbnail (Creating/Updating Course)

#### Using FormData (Recommended for file uploads)

```javascript
const uploadCourseThumbnail = async (courseId, thumbnailFile) => {
  const formData = new FormData();
  
  // If creating a new course, include all course data
  formData.append('form_key', 'basic'); // or 'media' for updating existing course
  formData.append('title', courseData.title);
  formData.append('category_id', courseData.categoryId);
  // ... other course fields
  
  // Add thumbnail file
  if (thumbnailFile) {
    formData.append('thumbnail', thumbnailFile);
  }
  
  // If updating existing course
  if (courseId) {
    formData.append('course_id', courseId);
  }

  try {
    const response = await fetch('http://127.0.0.1:8000/api/courses', {
      method: 'POST', // or PUT/PATCH for updates
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        // Don't set Content-Type - browser will set it with boundary for FormData
      },
      credentials: 'include',
      body: formData,
    });

    const result = await response.json();
    
    if (result.status === 'success') {
      console.log('Thumbnail uploaded successfully');
      return { success: true, data: result.data };
    } else {
      return { success: false, errors: result.errors || {}, message: result.message };
    }
  } catch (error) {
    console.error('Upload error:', error);
    return { success: false, message: 'Network error. Please try again.' };
  }
};
```

#### Example: React Component

```jsx
import React, { useState } from 'react';

function CourseThumbnailUpload({ courseId, onSuccess }) {
  const [thumbnail, setThumbnail] = useState(null);
  const [preview, setPreview] = useState(null);
  const [uploading, setUploading] = useState(false);

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      // Validate file type
      const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/svg+xml'];
      if (!allowedTypes.includes(file.type)) {
        alert('Invalid file type. Please upload jpg, png, webp, or svg.');
        return;
      }

      setThumbnail(file);
      
      // Create preview
      const reader = new FileReader();
      reader.onloadend = () => {
        setPreview(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  const handleUpload = async () => {
    if (!thumbnail) {
      alert('Please select a thumbnail image');
      return;
    }

    setUploading(true);
    const result = await uploadCourseThumbnail(courseId, thumbnail);
    setUploading(false);

    if (result.success) {
      alert('Thumbnail uploaded successfully!');
      onSuccess?.(result.data);
    } else {
      alert(result.message || 'Upload failed');
    }
  };

  return (
    <div>
      <label>
        Course Thumbnail (300x300 recommended)
        <input
          type="file"
          accept="image/jpeg,image/jpg,image/png,image/webp,image/svg+xml"
          onChange={handleFileChange}
        />
      </label>
      
      {preview && (
        <div>
          <img src={preview} alt="Thumbnail preview" style={{ maxWidth: '300px' }} />
        </div>
      )}
      
      <button onClick={handleUpload} disabled={!thumbnail || uploading}>
        {uploading ? 'Uploading...' : 'Upload Thumbnail'}
      </button>
    </div>
  );
}
```

---

## Displaying Thumbnail in Frontend

### 1. Getting Course Data from API

The API endpoints already return the full thumbnail URL:

```javascript
// GET /api/courses - List all courses
// GET /api/courses/{id} - Get single course
// GET /api/courses/{slug} - Get course by slug

const fetchCourse = async (courseId) => {
  try {
    const response = await fetch(`http://127.0.0.1:8000/api/courses/${courseId}`);
    const result = await response.json();
    
    if (result.status === 'success') {
      const course = result.data;
      // course.thumbnail contains the full URL
      // e.g., "http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-abc12345.jpg"
      return course;
    }
  } catch (error) {
    console.error('Error fetching course:', error);
  }
};
```

### 2. API Response Format

The API returns thumbnail URLs in this format:

```json
{
  "status": "success",
  "data": {
    "id": 1,
    "title": "Course Title",
    "thumbnail": "http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-abc12345.jpg",
    // ... other fields
  }
}
```

### 3. Displaying in React/Next.js

```jsx
function CourseCard({ course }) {
  // Handle missing thumbnail
  const thumbnailUrl = course.thumbnail || '/placeholder-course.jpg';
  
  return (
    <div className="course-card">
      <img 
        src={thumbnailUrl} 
        alt={course.title}
        onError={(e) => {
          // Fallback if image fails to load
          e.target.src = '/placeholder-course.jpg';
        }}
      />
      <h3>{course.title}</h3>
    </div>
  );
}
```

### 4. Displaying in HTML/JavaScript

```html
<img 
  src="http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-abc12345.jpg" 
  alt="Course thumbnail"
  onerror="this.src='/placeholder.jpg'"
/>
```

### 5. Using Environment Variables

For production, use environment variables for the API URL:

```javascript
// .env.local (Next.js) or .env (React)
NEXT_PUBLIC_API_URL=http://127.0.0.1:8000
// or
REACT_APP_API_URL=http://127.0.0.1:8000

// In your code
const API_URL = process.env.NEXT_PUBLIC_API_URL || process.env.REACT_APP_API_URL || 'http://127.0.0.1:8000';

// Use it
const thumbnailUrl = course.thumbnail 
  ? course.thumbnail.startsWith('http') 
    ? course.thumbnail 
    : `${API_URL}/${course.thumbnail}`
  : '/placeholder.jpg';
```

---

## URL Construction Logic

The backend API (`CourseController.php`) constructs thumbnail URLs as follows:

1. **If thumbnail starts with `http://` or `https://`**: Use as-is (external URL)
2. **If thumbnail starts with `/`**: Use `asset()` helper
3. **If thumbnail starts with `storage/` or `lms/`**: Prepend with `storage/` if needed
4. **Otherwise**: Construct as `storage/lms/courses/thumbnails/{filename}`

**Example URLs:**
- `http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-abc12345.jpg`
- `https://yourdomain.com/storage/lms/courses/thumbnails/lms-xyz67890.png`

---

## Important Notes

### 1. Storage Symlink

**Always ensure the storage symlink exists:**
```bash
php artisan storage:link
```

This creates: `public/storage` → `Modules/LMS/storage/app/public`

### 2. File Permissions (Linux/Mac)

If images aren't loading, check file permissions:
```bash
chmod -R 755 Modules/LMS/storage/
chown -R www-data:www-data Modules/LMS/storage/
```

### 3. CORS Configuration

If your frontend is on a different domain, ensure CORS is configured in Laravel:
```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000'], // Your frontend URL
```

### 4. Image Optimization

Consider optimizing images before upload:
- Resize to recommended 300x300px
- Compress images to reduce file size
- Use WebP format for better compression

### 5. Error Handling

Always handle cases where thumbnail might be missing:
```javascript
const getThumbnailUrl = (course) => {
  if (!course.thumbnail) {
    return '/default-course-thumbnail.jpg';
  }
  
  // If it's already a full URL, use it
  if (course.thumbnail.startsWith('http')) {
    return course.thumbnail;
  }
  
  // Otherwise, construct the full URL
  const baseUrl = process.env.NEXT_PUBLIC_API_URL || 'http://127.0.0.1:8000';
  return `${baseUrl}/${course.thumbnail.startsWith('/') ? course.thumbnail.slice(1) : course.thumbnail}`;
};
```

---

## Complete Example: Full Course Creation with Thumbnail

```javascript
const createCourseWithThumbnail = async (courseData, thumbnailFile) => {
  const formData = new FormData();
  
  // Basic course information
  formData.append('form_key', 'basic');
  formData.append('title', courseData.title);
  formData.append('category_id', courseData.categoryId);
  formData.append('short_description', courseData.shortDescription);
  formData.append('description', courseData.description);
  formData.append('duration', courseData.duration);
  formData.append('time_zone_id', courseData.timeZoneId);
  formData.append('video_src_type', courseData.videoSrcType);
  formData.append('subject_id', courseData.subjectId);
  
  // Arrays
  courseData.levels.forEach(levelId => {
    formData.append('levels[]', levelId);
  });
  
  courseData.instructors.forEach(instructorId => {
    formData.append('instructors[]', instructorId);
  });
  
  courseData.languages.forEach(languageId => {
    formData.append('languages[]', languageId);
  });
  
  // Thumbnail file
  if (thumbnailFile) {
    formData.append('thumbnail', thumbnailFile);
  }

  try {
    const response = await fetch('http://127.0.0.1:8000/api/courses', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'include',
      body: formData,
    });

    const result = await response.json();
    return result;
  } catch (error) {
    console.error('Error creating course:', error);
    return { status: 'error', message: 'Network error' };
  }
};
```

---

## Troubleshooting

### Images Not Displaying

1. **Check storage symlink:**
   ```bash
   ls -la public/storage
   ```

2. **Verify file exists:**
   ```bash
   ls -la Modules/LMS/storage/app/public/lms/courses/thumbnails/
   ```

3. **Check file permissions:**
   ```bash
   chmod -R 755 Modules/LMS/storage/
   ```

4. **Verify URL in browser:**
   - Open the thumbnail URL directly in browser
   - Check browser console for 404 errors

### Upload Failing

1. **Check file size limits** in `php.ini`:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```

2. **Check validation errors** in API response:
   ```javascript
   if (result.errors) {
     console.log('Validation errors:', result.errors);
   }
   ```

3. **Verify file format** is in allowed list

---

## Summary

- **Upload:** Use `FormData` with field name `thumbnail`
- **Storage:** Files saved to `Modules/LMS/storage/app/public/lms/courses/thumbnails/`
- **Database:** Filename stored in `courses.thumbnail` column
- **API Response:** Full URL returned in `course.thumbnail` field
- **Display:** Use the URL directly in `<img src={course.thumbnail} />`
- **Symlink:** Ensure `php artisan storage:link` is run

The backend already handles URL construction, so you just need to use the `thumbnail` field from the API response!

