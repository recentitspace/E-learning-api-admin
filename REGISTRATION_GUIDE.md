# Registration API Guide for Frontend

## Route Information

**Route:** `POST /register`  
**Route Name:** `auth.register`  
**Full URL:** `http://127.0.0.1:8000/register`

---

## Required Fields by User Type

### 1. Student Registration

**user_type:** `"student"`

**Required Fields:**
```javascript
{
  "user_type": "student",
  "first_name": "John",          // Required, string
  "last_name": "Doe",            // Required, string
  "email": "john@example.com",   // Required, email, must be unique
  "phone": "1234567890",         // Required, must be unique in students table
  "password": "password123",      // Required, min: 6, max: 12
  "password_confirmation": "password123"  // Required, must match password
}
```

**Optional Fields:**
- `image` - Profile image (file upload, formats: jpg, png, svg, webp, jpeg)
- `locale` - Language code

---

### 2. Instructor Registration

**user_type:** `"instructor"`

**Required Fields:**
```javascript
{
  "user_type": "instructor",
  "first_name": "Jane",          // Required, string
  "last_name": "Smith",           // Required, string
  "email": "jane@example.com",   // Required, email, must be unique
  "phone": "0987654321",         // Required, must be unique in instructors table
  "password": "pass123",         // Required, min: 5, max: 12
  "password_confirmation": "pass123",  // Required, must match password
  "designation": "Senior Developer"  // Required, string (job title/position)
}
```

**Optional Fields:**
- `image` - Profile image (file upload, formats: jpg, png, svg, webp, jpeg)
- `profile_cover` - Cover photo (file upload, formats: jpg, png, svg, webp, jpeg)
- `locale` - Language code

---

### 3. Organization Registration

**user_type:** `"organization"`

**Required Fields:**
```javascript
{
  "user_type": "organization",
  "name": "Tech Corp",           // Required, string (organization name)
  "email": "contact@techcorp.com",  // Required, email, must be unique
  "phone": "5551234567",         // Required, must be unique in organizations table
  "password": "orgpass123",      // Required, min: 5, max: 12
  "password_confirmation": "orgpass123"  // Required, must match password
}
```

**Optional Fields:**
- `image` - Profile image (file upload, formats: jpg, png, svg, webp, jpeg)
- `profile_cover` - Cover photo (file upload, formats: jpg, png, svg, webp, jpeg)
- `locale` - Language code

---

## Response Format

### Success Response (200)
```json
{
  "status": "success",
  "message": "Thank Your For Register and Please Verify Your Email"
}
```

### Error Response (422 - Validation Error)
```json
{
  "status": "error",
  "message": "The email has already been taken.",
  "errors": {
    "email": ["The email has already been taken."],
    "phone": ["The phone has already been taken."]
  }
}
```

### Error Response (400/500 - Server Error)
```json
{
  "status": "error",
  "message": "An error occurred while processing your request. Please try again later."
}
```

---

## Frontend Implementation Examples

### Example 1: Student Registration (Form Data)

```javascript
const registerStudent = async (formData) => {
  const data = new FormData();
  data.append('user_type', 'student');
  data.append('first_name', formData.firstName);
  data.append('last_name', formData.lastName);
  data.append('email', formData.email);
  data.append('phone', formData.phone);
  data.append('password', formData.password);
  data.append('password_confirmation', formData.passwordConfirmation);
  
  // Optional: Add profile image
  if (formData.profileImage) {
    data.append('image', formData.profileImage);
  }

  try {
    const res = await fetch('http://127.0.0.1:8000/register', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: data,
    });

    const result = await res.json();
    
    if (result.status === 'success') {
      console.log('Registration successful:', result.message);
      // Show success message and redirect to login
      return { success: true, message: result.message };
    } else {
      // Handle validation errors
      return { success: false, errors: result.errors || {}, message: result.message };
    }
  } catch (error) {
    console.error('Registration error:', error);
    return { success: false, message: 'Network error. Please try again.' };
  }
};
```

### Example 2: Student Registration (JSON - No File Upload)

```javascript
const registerStudentJSON = async (studentData) => {
  try {
    const res = await fetch('http://127.0.0.1:8000/register', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify({
        user_type: 'student',
        first_name: studentData.firstName,
        last_name: studentData.lastName,
        email: studentData.email,
        phone: studentData.phone,
        password: studentData.password,
        password_confirmation: studentData.passwordConfirmation,
      }),
    });

    const result = await res.json();
    
    if (result.status === 'success') {
      return { success: true, message: result.message };
    } else {
      return { 
        success: false, 
        errors: result.errors || {}, 
        message: result.message 
      };
    }
  } catch (error) {
    return { success: false, message: 'Network error. Please try again.' };
  }
};
```

### Example 3: Instructor Registration

```javascript
const registerInstructor = async (instructorData) => {
  const data = new FormData();
  data.append('user_type', 'instructor');
  data.append('first_name', instructorData.firstName);
  data.append('last_name', instructorData.lastName);
  data.append('email', instructorData.email);
  data.append('phone', instructorData.phone);
  data.append('password', instructorData.password);
  data.append('password_confirmation', instructorData.passwordConfirmation);
  data.append('designation', instructorData.designation); // Required for instructor
  
  if (instructorData.profileImage) {
    data.append('image', instructorData.profileImage);
  }
  if (instructorData.coverPhoto) {
    data.append('profile_cover', instructorData.coverPhoto);
  }

  try {
    const res = await fetch('http://127.0.0.1:8000/register', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: data,
    });

    return await res.json();
  } catch (error) {
    return { 
      status: 'error', 
      message: 'Network error. Please try again.' 
    };
  }
};
```

### Example 4: Organization Registration

```javascript
const registerOrganization = async (orgData) => {
  const data = new FormData();
  data.append('user_type', 'organization');
  data.append('name', orgData.name); // Organization name
  data.append('email', orgData.email);
  data.append('phone', orgData.phone);
  data.append('password', orgData.password);
  data.append('password_confirmation', orgData.passwordConfirmation);
  
  if (orgData.logo) {
    data.append('image', orgData.logo);
  }
  if (orgData.coverPhoto) {
    data.append('profile_cover', orgData.coverPhoto);
  }

  try {
    const res = await fetch('http://127.0.0.1:8000/register', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: data,
    });

    return await res.json();
  } catch (error) {
    return { 
      status: 'error', 
      message: 'Network error. Please try again.' 
    };
  }
};
```

---

## Validation Rules Summary

### Student
- `first_name`: Required, string
- `last_name`: Required, string
- `email`: Required, valid email, unique in users table
- `phone`: Required, unique in students table
- `password`: Required, min: 6 characters, max: 12 characters
- `password_confirmation`: Required, must match password

### Instructor
- `first_name`: Required, string
- `last_name`: Required, string
- `email`: Required, valid email, unique in users table
- `phone`: Required, unique in instructors table
- `password`: Required, min: 5 characters, max: 12 characters
- `password_confirmation`: Required, must match password
- `designation`: Required, string (job title)

### Organization
- `name`: Required, string (organization name)
- `email`: Required, valid email, unique in users table
- `phone`: Required, unique in organizations table
- `password`: Required, min: 5 characters, max: 12 characters
- `password_confirmation`: Required, must match password

---

## Important Notes

1. **Email Verification**: After successful registration, users receive an email verification link. Users must verify their email before they can login.

2. **File Uploads**: Use `FormData` when uploading images. Don't set `Content-Type` header when using FormData - browser sets it automatically with boundary.

3. **CSRF Token**: Registration endpoint may require CSRF token. Check if `/register` is excluded from CSRF in your backend config.

4. **Unique Constraints**: Email must be unique across all user types. Phone must be unique within each user type's table.

5. **Password Requirements**: 
   - Student: 6-12 characters
   - Instructor: 5-12 characters
   - Organization: 5-12 characters

6. **Response Handling**: Always check `result.status === 'success'` before proceeding. Check `result.errors` for field-specific validation errors.

---

## Error Handling Example

```javascript
const handleRegistration = async (formData) => {
  try {
    const result = await registerStudent(formData);
    
    if (result.success) {
      // Show success message
      alert(result.message);
      // Redirect to login page
      window.location.href = '/login';
    } else {
      // Display validation errors
      if (result.errors) {
        Object.keys(result.errors).forEach(field => {
          const errorElement = document.querySelector(`.${field}_err`);
          if (errorElement) {
            errorElement.textContent = result.errors[field][0];
          }
        });
      }
      // Show general error message
      alert(result.message || 'Registration failed');
    }
  } catch (error) {
    console.error('Registration error:', error);
    alert('An unexpected error occurred. Please try again.');
  }
};
```

