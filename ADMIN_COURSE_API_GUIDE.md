# Admin Course List API Guide

## Endpoint
**URL:** `GET /admin/course`  
**Route Name:** `course.index`

## Request Headers (REQUIRED for JSON)
To get JSON response instead of HTML, include this header:

```javascript
{
  'Accept': 'application/json',
  'X-Requested-With': 'XMLHttpRequest'
}
```

## Query Parameters

### Filter Options
- `filter=all` - Get all courses (including trashed)
- `filter=trash` - Get only trashed courses
- No filter - Get only published courses

### Other Filters (via dashboardCourseFilter)
- `categories[]` - Filter by category IDs
- `subcategories[]` - Filter by subcategory IDs
- `course_status` - Filter by status (Pending, Approved, Rejected)
- `course_type` - Filter by type (paid, free)
- `organizations[]` - Filter by organization IDs
- `instructors[]` - Filter by instructor IDs

## Example Request

### JavaScript/Fetch
```javascript
const getCourses = async (filters = {}) => {
  const queryParams = new URLSearchParams();
  
  if (filters.filter) {
    queryParams.append('filter', filters.filter);
  }
  if (filters.categories) {
    filters.categories.forEach(id => queryParams.append('categories[]', id));
  }
  // Add other filters...

  const url = `http://127.0.0.1:8000/admin/course?${queryParams.toString()}`;

  try {
    const response = await fetch(url, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      credentials: 'include', // Include session cookies
    });

    const result = await response.json();
    
    if (result.status === 'success') {
      console.log('Courses:', result.data.courses);
      console.log('Reports:', result.data.reports);
      console.log('Counts:', result.data.counts);
      return result.data;
    } else {
      console.error('Error:', result.message);
      return null;
    }
  } catch (error) {
    console.error('Network error:', error);
    return null;
  }
};

// Usage
getCourses({ filter: 'all' });
```

### Axios Example
```javascript
import axios from 'axios';

const getCourses = async (filters = {}) => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/admin/course', {
      params: filters,
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      withCredentials: true,
    });

    return response.data;
  } catch (error) {
    console.error('Error:', error.response?.data || error.message);
    return null;
  }
};
```

## Response Format

### Success Response (200)
```json
{
  "status": "success",
  "data": {
    "courses": [
      {
        "id": 1,
        "title": "Course Title",
        "slug": "course-title",
        "thumbnail": "http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-abc123.jpg",
        "status": "Approved",
        "category": {
          "id": 1,
          "title": "Category Name"
        },
        "price": 99.99,
        "discount_price": 79.99,
        "currency": "USD",
        "instructors": [
          {
            "id": 1,
            "name": "John Doe"
          }
        ],
        "students_count": 150,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-15T00:00:00.000000Z"
      }
    ],
    "reports": {
      "total_course": 100,
      "total_approved": 80,
      "total_rejected": 5,
      "total_pending": 15,
      "total_paid": 60,
      "total_free": 40
    },
    "counts": {
      "total": 100,
      "published": 80,
      "trashed": 5
    },
    "pagination": {
      "current_page": 1,
      "last_page": 10,
      "per_page": 10,
      "total": 100
    }
  }
}
```

## Response Fields

### Course Object
- `id` - Course ID
- `title` - Course title
- `slug` - Course slug
- `thumbnail` - Full URL to thumbnail image
- `status` - Course status (Pending, Approved, Rejected)
- `category` - Category object with id and title
- `price` - Course price
- `discount_price` - Discounted price (if any)
- `currency` - Currency code
- `instructors` - Array of instructor objects
- `students_count` - Number of enrolled students
- `created_at` - ISO timestamp
- `updated_at` - ISO timestamp

### Reports Object
- `total_course` - Total number of courses
- `total_approved` - Number of approved courses
- `total_rejected` - Number of rejected courses
- `total_pending` - Number of pending courses
- `total_paid` - Number of paid courses
- `total_free` - Number of free courses

### Counts Object
- `total` - Total courses count
- `published` - Published courses count
- `trashed` - Trashed courses count

## Important Notes

1. **Always include `Accept: application/json` header** - Without this, you'll get HTML
2. **Thumbnail URLs** - Already resolved to full URLs, ready to use in `<img>` tags
3. **Pagination** - If courses are paginated, `pagination` object will be included
4. **Authentication** - You must be authenticated as admin to access this endpoint
5. **Permissions** - Requires admin permissions

## Displaying in Frontend

```javascript
// After getting courses
const courses = result.data.courses;

courses.forEach(course => {
  console.log(course.title);
  console.log(course.thumbnail); // Use directly in <img src={course.thumbnail} />
});
```

## Troubleshooting

### Still Getting HTML?
- ✅ Check that `Accept: application/json` header is included
- ✅ Verify you're making the request correctly
- ✅ Check browser network tab to see actual headers sent

### No Courses Returned?
- Check authentication
- Verify permissions
- Check filter parameters
- Look at Laravel logs

### Thumbnail Not Showing?
- Verify storage symlink exists
- Check if file exists on disk
- Verify thumbnail URL in response

