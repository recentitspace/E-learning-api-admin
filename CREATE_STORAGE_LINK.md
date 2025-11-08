# Storage Symlink Setup Guide

## Problem
The storage symlink is missing, causing 404 errors when accessing uploaded images like:
- `http://127.0.0.1:8000/storage/lms/theme-options/lms-VhWTuSEghJ.png`
- `http://127.0.0.1:8000/storage/lms/courses/thumbnails/lms-ulTxiTji.jpg`

## Solution

### Option 1: Using Artisan (Recommended)
Run this command in your project root:
```bash
php artisan storage:link
```

### Option 2: Manual Windows Command (Run as Administrator)
Open Command Prompt or PowerShell **as Administrator** and run:
```cmd
cd D:\Abdirizak\Projects\elearning\backend
mklink /D public\storage Modules\LMS\storage\app\public
```

### Option 3: Manual Windows PowerShell (Run as Administrator)
Open PowerShell **as Administrator** and run:
```powershell
cd D:\Abdirizak\Projects\elearning\backend
New-Item -ItemType SymbolicLink -Path "public\storage" -Target "Modules\LMS\storage\app\public"
```

## Verify
After creating the symlink, verify it exists:
```powershell
Get-Item public\storage | Select-Object Target
```

It should show: `Modules\LMS\storage\app\public`

## What This Does
The symlink creates a connection from:
- **Source (public)**: `public/storage` 
- **Target (actual files)**: `Modules/LMS/storage/app/public`

This allows Laravel to serve files from `Modules/LMS/storage/app/public` via the `public/storage` URL path.

## After Creating the Symlink
1. Refresh your browser
2. The images should now load correctly
3. Course thumbnails and theme options should display properly

## Troubleshooting
- **Permission Denied**: Run PowerShell/CMD as Administrator
- **Symlink Already Exists**: Delete `public\storage` first, then recreate
- **Still 404**: Check that files actually exist in `Modules\LMS\storage\app\public\lms\`

