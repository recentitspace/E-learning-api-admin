# Frontend Thumbnail Display Guide

## Overview
This guide shows you how to display course thumbnails in your separate frontend website. The backend API now returns full thumbnail URLs that work without symlinks.

## API Endpoints

### 1. Get Course List
```
GET /api/courses
```

**Response:**
```json
{
  "status": "success",
  "data": [
    {
      "id": 1,
      "title": "Course Title",
      "slug": "course-title",
      "thumbnail": "http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/lms-abc123.jpg",
      "price": 99.99,
      "category": {...},
      "instructors": [...],
      ...
    }
  ]
}
```

### 2. Get Single Course
```
GET /api/courses/{id}
GET /api/courses/{slug}
```

**Response:**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "title": "Course Title",
    "thumbnail": "http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/lms-abc123.jpg",
    ...
  }
}
```

## Frontend Implementation

### React/Next.js Example

#### 1. Fetch Courses
```javascript
// utils/api.js or services/courseService.js
const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://127.0.0.1:8000';

export const getCourses = async () => {
  try {
    const response = await fetch(`${API_URL}/api/courses`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });

    const result = await response.json();
    
    if (result.status === 'success') {
      return result.data;
    }
    
    return [];
  } catch (error) {
    console.error('Error fetching courses:', error);
    return [];
  }
};

export const getCourse = async (idOrSlug) => {
  try {
    const response = await fetch(`${API_URL}/api/courses/${idOrSlug}`, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
      },
    });

    const result = await response.json();
    
    if (result.status === 'success') {
      return result.data;
    }
    
    return null;
  } catch (error) {
    console.error('Error fetching course:', error);
    return null;
  }
};
```

#### 2. Course Card Component
```jsx
// components/CourseCard.jsx
import Image from 'next/image'; // For Next.js
// OR
// import { useState } from 'react'; // For React

export default function CourseCard({ course }) {
  // Thumbnail URL is already full URL from API
  const thumbnailUrl = course.thumbnail || '/placeholder.jpg';
  
  // For Next.js with Image component
  return (
    <div className="course-card">
      <div className="course-thumbnail">
        <Image
          src={thumbnailUrl}
          alt={course.title}
          width={300}
          height={200}
          className="w-full h-48 object-cover rounded-lg"
          onError={(e) => {
            // Fallback to placeholder if image fails to load
            e.target.src = '/placeholder.jpg';
          }}
        />
      </div>
      <div className="course-content">
        <h3 className="course-title">{course.title}</h3>
        <p className="course-price">${course.price}</p>
        <p className="course-instructors">
          {course.instructors?.map(i => i.name).join(', ')}
        </p>
      </div>
    </div>
  );
  
  // For React with regular img tag
  /*
  const [imgError, setImgError] = useState(false);
  
  return (
    <div className="course-card">
      <div className="course-thumbnail">
        <img
          src={imgError ? '/placeholder.jpg' : thumbnailUrl}
          alt={course.title}
          className="w-full h-48 object-cover rounded-lg"
          onError={() => setImgError(true)}
        />
      </div>
      <div className="course-content">
        <h3 className="course-title">{course.title}</h3>
        <p className="course-price">${course.price}</p>
      </div>
    </div>
  );
  */
}
```

#### 3. Course List Page
```jsx
// pages/courses.jsx (Next.js) or components/CourseList.jsx (React)
import { useEffect, useState } from 'react';
import { getCourses } from '../utils/api';
import CourseCard from '../components/CourseCard';

export default function CoursesPage() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchCourses = async () => {
      try {
        setLoading(true);
        const data = await getCourses();
        setCourses(data);
      } catch (err) {
        setError('Failed to load courses');
        console.error(err);
      } finally {
        setLoading(false);
      }
    };

    fetchCourses();
  }, []);

  if (loading) {
    return <div>Loading courses...</div>;
  }

  if (error) {
    return <div>Error: {error}</div>;
  }

  return (
    <div className="courses-container">
      <h1>All Courses</h1>
      <div className="courses-grid grid grid-cols-1 md:grid-cols-3 gap-6">
        {courses.map((course) => (
          <CourseCard key={course.id} course={course} />
        ))}
      </div>
    </div>
  );
}
```

#### 4. Course Detail Page
```jsx
// pages/courses/[slug].jsx (Next.js)
import { useRouter } from 'next/router';
import { useEffect, useState } from 'react';
import { getCourse } from '../../utils/api';
import Image from 'next/image';

export default function CourseDetailPage() {
  const router = useRouter();
  const { slug } = router.query;
  const [course, setCourse] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (slug) {
      const fetchCourse = async () => {
        try {
          setLoading(true);
          const data = await getCourse(slug);
          setCourse(data);
        } catch (err) {
          console.error(err);
        } finally {
          setLoading(false);
        }
      };

      fetchCourse();
    }
  }, [slug]);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (!course) {
    return <div>Course not found</div>;
  }

  return (
    <div className="course-detail">
      <div className="course-hero">
        <Image
          src={course.thumbnail || '/placeholder.jpg'}
          alt={course.title}
          width={1200}
          height={600}
          className="w-full h-96 object-cover"
        />
      </div>
      <div className="course-info">
        <h1>{course.title}</h1>
        <p>{course.short_description}</p>
        <p className="price">${course.price}</p>
      </div>
    </div>
  );
}
```

### Vue.js Example

```vue
<!-- components/CourseCard.vue -->
<template>
  <div class="course-card">
    <div class="course-thumbnail">
      <img
        :src="thumbnailUrl"
        :alt="course.title"
        class="w-full h-48 object-cover rounded-lg"
        @error="handleImageError"
      />
    </div>
    <div class="course-content">
      <h3>{{ course.title }}</h3>
      <p>${{ course.price }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CourseCard',
  props: {
    course: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      imageError: false
    };
  },
  computed: {
    thumbnailUrl() {
      if (this.imageError) {
        return '/placeholder.jpg';
      }
      return this.course.thumbnail || '/placeholder.jpg';
    }
  },
  methods: {
    handleImageError() {
      this.imageError = true;
    }
  }
};
</script>
```

### Plain JavaScript Example

```javascript
// Fetch courses
async function fetchCourses() {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/courses');
    const result = await response.json();
    
    if (result.status === 'success') {
      displayCourses(result.data);
    }
  } catch (error) {
    console.error('Error:', error);
  }
}

// Display courses
function displayCourses(courses) {
  const container = document.getElementById('courses-container');
  
  courses.forEach(course => {
    const card = document.createElement('div');
    card.className = 'course-card';
    
    card.innerHTML = `
      <div class="course-thumbnail">
        <img 
          src="${course.thumbnail || '/placeholder.jpg'}" 
          alt="${course.title}"
          onerror="this.src='/placeholder.jpg'"
        />
      </div>
      <div class="course-content">
        <h3>${course.title}</h3>
        <p>$${course.price}</p>
      </div>
    `;
    
    container.appendChild(card);
  });
}

// Call on page load
fetchCourses();
```

## Environment Variables

### Next.js (.env.local)
```env
NEXT_PUBLIC_API_URL=http://127.0.0.1:8000
```

### React (.env)
```env
REACT_APP_API_URL=http://127.0.0.1:8000
```

### Vue.js (.env)
```env
VUE_APP_API_URL=http://127.0.0.1:8000
```

## Thumbnail URL Format

The API returns thumbnail URLs in this format:
```
http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/{filename}
```

**Example:**
```
http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/lms-abc12345.jpg
```

## Important Notes

1. **Full URLs**: The API returns complete URLs, ready to use in `<img>` tags
2. **No Symlink Needed**: URLs work via route-based serving
3. **Error Handling**: Always include `onError` handler for failed image loads
4. **Placeholder**: Use a placeholder image if thumbnail is missing
5. **CORS**: If frontend is on different domain, ensure CORS is configured

## CORS Configuration (if needed)

If your frontend is on a different domain, add to `config/cors.php`:

```php
'paths' => ['api/*', 'storage/*'],
'allowed_origins' => ['http://localhost:3000', 'https://yourdomain.com'],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
'allowed_headers' => ['*'],
```

## Testing

1. **Test API Endpoint:**
   ```bash
   curl http://127.0.0.1:8000/api/courses
   ```
   Check that `thumbnail` field contains full URL.

2. **Test Image URL:**
   Open thumbnail URL in browser:
   ```
   http://127.0.0.1:8000/storage/lms/lms/courses/thumbnails/{filename}
   ```
   Should display the image, not 404.

3. **Test in Frontend:**
   - Fetch courses from API
   - Display thumbnails using the URLs
   - Check browser console for any errors

## Troubleshooting

### Images Not Loading?

1. **Check API Response:**
   - Verify `thumbnail` field contains full URL
   - Check URL format is correct

2. **Check Image URL:**
   - Open thumbnail URL directly in browser
   - Should return image, not 404

3. **Check CORS:**
   - If frontend is on different domain
   - Check browser console for CORS errors
   - Update CORS configuration

4. **Check Network Tab:**
   - Open browser DevTools → Network tab
   - Check if image request is being made
   - Check response status code

### Placeholder Showing Instead of Image?

1. **File Doesn't Exist:**
   - Check if file exists on server
   - Verify filename matches database value

2. **URL Format Wrong:**
   - Check API response format
   - Verify URL construction

3. **Route Not Working:**
   - Test route directly in browser
   - Check Laravel logs for errors

## Summary

✅ **API returns full thumbnail URLs**
✅ **Use URLs directly in `<img>` tags**
✅ **Include error handling for failed loads**
✅ **Works without symlinks**
✅ **Route-based serving handles file access**

Your frontend can now display course thumbnails! 🎉

