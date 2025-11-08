# API Authentication Guide for External Frontend (Next.js)

This guide explains how to authenticate with this Laravel backend from your external Next.js frontend.

## API Endpoints

### Base URL
```
http://127.0.0.1:8000/api
```

### 1. Login
**Endpoint:** `POST /api/auth/login`

**Request Body:**
```json
{
  "email": "student@example.com",
  "password": "password123"
}
```

**Success Response (200):**
```json
{
  "status": "success",
  "message": "Login successfully",
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
  "user": {
    "id": 1,
    "email": "student@example.com",
    "username": "student123",
    "user_type": "student",
    "guard": "student"
  },
  "redirect_url": "http://127.0.0.1:8000/dashboard"
}
```

**Error Response (401):**
```json
{
  "status": "error",
  "message": "User not found or credentials are incorrect."
}
```

### 2. Get Authenticated User
**Endpoint:** `GET /api/auth/user`

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Success Response (200):**
```json
{
  "user": {
    "id": 1,
    "email": "student@example.com",
    "username": "student123",
    "user_type": "student",
    "guard": "student"
  }
}
```

### 3. Logout
**Endpoint:** `POST /api/auth/logout`

**Headers:**
```
Authorization: Bearer {token}
Accept: application/json
```

**Success Response (200):**
```json
{
  "status": "success",
  "message": "Logged out successfully"
}
```

## Next.js Implementation Example

### 1. Create API Client

Create `lib/api.js`:

```javascript
const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://127.0.0.1:8000/api';

class ApiClient {
  constructor() {
    this.baseURL = API_BASE_URL;
    this.token = typeof window !== 'undefined' ? localStorage.getItem('auth_token') : null;
  }

  setToken(token) {
    this.token = token;
    if (typeof window !== 'undefined') {
      if (token) {
        localStorage.setItem('auth_token', token);
      } else {
        localStorage.removeItem('auth_token');
      }
    }
  }

  async request(endpoint, options = {}) {
    const url = `${this.baseURL}${endpoint}`;
    const config = {
      ...options,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers,
      },
    };

    if (this.token) {
      config.headers['Authorization'] = `Bearer ${this.token}`;
    }

    const response = await fetch(url, config);
    const data = await response.json();

    if (!response.ok) {
      throw new Error(data.message || 'Request failed');
    }

    return data;
  }

  async login(email, password) {
    const data = await this.request('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ email, password }),
    });
    
    if (data.token) {
      this.setToken(data.token);
    }
    
    return data;
  }

  async getUser() {
    return this.request('/auth/user');
  }

  async logout() {
    const data = await this.request('/auth/logout', {
      method: 'POST',
    });
    this.setToken(null);
    return data;
  }
}

export const apiClient = new ApiClient();
```

### 2. Create Auth Context

Create `contexts/AuthContext.js`:

```javascript
import { createContext, useContext, useState, useEffect } from 'react';
import { apiClient } from '@/lib/api';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    // Check if user is already logged in
    checkAuth();
  }, []);

  const checkAuth = async () => {
    try {
      const data = await apiClient.getUser();
      setUser(data.user);
    } catch (error) {
      setUser(null);
      apiClient.setToken(null);
    } finally {
      setLoading(false);
    }
  };

  const login = async (email, password) => {
    try {
      const data = await apiClient.login(email, password);
      setUser(data.user);
      return { success: true, data };
    } catch (error) {
      return { success: false, error: error.message };
    }
  };

  const logout = async () => {
    try {
      await apiClient.logout();
      setUser(null);
      return { success: true };
    } catch (error) {
      return { success: false, error: error.message };
    }
  };

  return (
    <AuthContext.Provider value={{ user, loading, login, logout, checkAuth }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within AuthProvider');
  }
  return context;
}
```

### 3. Login Page Example

Create `pages/login.js`:

```javascript
import { useState } from 'react';
import { useRouter } from 'next/router';
import { useAuth } from '@/contexts/AuthContext';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const { login } = useAuth();
  const router = useRouter();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setLoading(true);

    const result = await login(email, password);

    if (result.success) {
      // Redirect based on user type
      const userType = result.data.user.user_type;
      if (userType === 'admin' || userType === 'instructor') {
        router.push('/admin/dashboard');
      } else if (userType === 'student') {
        router.push('/student/dashboard');
      } else {
        router.push('/dashboard');
      }
    } else {
      setError(result.error || 'Login failed');
      setLoading(false);
    }
  };

  return (
    <div>
      <h1>Login</h1>
      <form onSubmit={handleSubmit}>
        {error && <div style={{ color: 'red' }}>{error}</div>}
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <button type="submit" disabled={loading}>
          {loading ? 'Logging in...' : 'Login'}
        </button>
      </form>
    </div>
  );
}
```

### 4. Protected Route Example

Create `pages/student/dashboard.js`:

```javascript
import { useEffect } from 'react';
import { useRouter } from 'next/router';
import { useAuth } from '@/contexts/AuthContext';

export default function StudentDashboard() {
  const { user, loading } = useAuth();
  const router = useRouter();

  useEffect(() => {
    if (!loading && !user) {
      router.push('/login');
    }
  }, [user, loading, router]);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (!user) {
    return null;
  }

  return (
    <div>
      <h1>Student Dashboard</h1>
      <p>Welcome, {user.email}!</p>
      {/* Your dashboard content */}
    </div>
  );
}
```

### 5. Environment Variables

Create `.env.local`:

```env
NEXT_PUBLIC_API_URL=http://127.0.0.1:8000/api
```

For production:
```env
NEXT_PUBLIC_API_URL=https://your-backend-domain.com/api
```

## Configuration

### 1. Update Backend CORS

In your Laravel backend `.env` file:
```env
FRONTEND_URL=http://localhost:3000
```

Or for production:
```env
FRONTEND_URL=https://your-nextjs-app.com
```

### 2. Update Backend CORS Config

The CORS configuration in `config/cors.php` should include your frontend URL in `allowed_origins`.

## User Types

After login, check the `user_type` field in the response:
- `admin` - Admin user
- `instructor` - Instructor user
- `student` - Student user
- `organization` - Organization user

Redirect users to appropriate dashboards based on their type.

## Security Notes

1. **Token Storage**: Tokens are stored in localStorage. For production, consider using httpOnly cookies.
2. **Token Expiration**: Tokens expire after 1 hour. Implement token refresh if needed.
3. **HTTPS**: Always use HTTPS in production.
4. **CORS**: Make sure to configure CORS properly for your production domains.

