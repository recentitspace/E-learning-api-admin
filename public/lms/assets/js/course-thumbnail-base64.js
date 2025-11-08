/**
 * Course Thumbnail Base64 Handler
 * 
 * This script handles converting thumbnail files to base64 and submitting them
 * to the backend for both creating and updating courses.
 * 
 * Usage:
 * 1. Include this script in your course form page
 * 2. Add data attributes to your file input: data-course-id="123" (optional, for updates)
 * 3. The script will automatically intercept form submissions and convert thumbnails to base64
 */

(function() {
    'use strict';

    /**
     * Convert file to base64 data URI
     * @param {File} file - The image file
     * @returns {Promise<string>} - Base64 data URI string
     */
    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        });
    }

    /**
     * Handle course form submission with base64 thumbnail
     */
    function handleCourseFormSubmit(e) {
        const form = e.target;
        const formData = new FormData(form);
        const thumbnailInput = form.querySelector('input[name="thumbnail"], input[type="file"][id*="thumbnail"]');
        
        // Check if form has thumbnail input
        if (!thumbnailInput || !thumbnailInput.files || !thumbnailInput.files[0]) {
            // No thumbnail file, submit normally
            return true;
        }

        const thumbnailFile = thumbnailInput.files[0];
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        if (!allowedTypes.includes(thumbnailFile.type)) {
            alert('Invalid file type. Please upload jpg, png, webp, or gif.');
            e.preventDefault();
            return false;
        }

        // Validate file size (max 5MB)
        if (thumbnailFile.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB.');
            e.preventDefault();
            return false;
        }

        // Prevent default form submission
        e.preventDefault();

        // Show loading indicator
        const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
        const originalButtonText = submitButton ? submitButton.textContent || submitButton.value : '';
        if (submitButton) {
            submitButton.disabled = true;
            if (submitButton.textContent !== undefined) {
                submitButton.textContent = 'Uploading...';
            } else {
                submitButton.value = 'Uploading...';
            }
        }

        // Convert thumbnail to base64 and submit
        fileToBase64(thumbnailFile)
            .then(base64String => {
                // Get form action URL
                const formAction = form.action || form.getAttribute('data-action') || '/admin/course';
                const formMethod = form.method || 'POST';

                // Build request data
                const requestData = {};
                
                // Get all form fields except file inputs
                formData.forEach((value, key) => {
                    if (key !== 'thumbnail' && !(value instanceof File)) {
                        requestData[key] = value;
                    }
                });

                // Add base64 thumbnail
                requestData.thumbnail = base64String;

                // Ensure form_key is set
                if (!requestData.form_key) {
                    requestData.form_key = 'basic';
                }

                // Submit via fetch
                return fetch(formAction, {
                    method: formMethod,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'include',
                    body: JSON.stringify(requestData),
                });
            })
            .then(response => response.json())
            .then(result => {
                // Restore button
                if (submitButton) {
                    submitButton.disabled = false;
                    if (submitButton.textContent !== undefined) {
                        submitButton.textContent = originalButtonText;
                    } else {
                        submitButton.value = originalButtonText;
                    }
                }

                if (result.status === 'success') {
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(result.message || 'Course saved successfully!');
                    } else {
                        alert(result.message || 'Course saved successfully!');
                    }

                    // Handle redirect if URL provided
                    if (result.url) {
                        window.location.href = result.url;
                    } else if (result.course && result.course.id) {
                        // Reload page to show updated thumbnail
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        // Just reload
                        window.location.reload();
                    }
                } else {
                    // Show error
                    const errorMsg = result.message || 'An error occurred. Please try again.';
                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg);
                    } else {
                        alert(errorMsg);
                    }

                    // Show validation errors if any
                    if (result.errors) {
                        console.error('Validation errors:', result.errors);
                    }
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                
                // Restore button
                if (submitButton) {
                    submitButton.disabled = false;
                    if (submitButton.textContent !== undefined) {
                        submitButton.textContent = originalButtonText;
                    } else {
                        submitButton.value = originalButtonText;
                    }
                }

                // Show error
                const errorMsg = 'Network error. Please check your connection and try again.';
                if (typeof toastr !== 'undefined') {
                    toastr.error(errorMsg);
                } else {
                    alert(errorMsg);
                }
            });

        return false;
    }

    /**
     * Initialize thumbnail preview
     */
    function initThumbnailPreview() {
        const thumbnailInputs = document.querySelectorAll('input[name="thumbnail"], input[type="file"][id*="thumbnail"]');
        
        thumbnailInputs.forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Find preview container
                    const previewContainer = input.closest('form, .card, .file-container')?.querySelector('.img-thumb-wrapper, .preview-container, [data-preview]');
                    
                    if (previewContainer) {
                        let previewImg = previewContainer.querySelector('img');
                        if (!previewImg) {
                            previewImg = document.createElement('img');
                            previewImg.className = 'img-thumb';
                            previewImg.style.maxWidth = '300px';
                            previewImg.style.maxHeight = '300px';
                            previewContainer.appendChild(previewImg);
                        }
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            });
        });
    }

    /**
     * Initialize on DOM ready
     */
    function init() {
        // Find course forms
        const courseForms = document.querySelectorAll('form[action*="course"], form[data-course-form="true"]');
        
        courseForms.forEach(form => {
            // Check if form has thumbnail input
            const hasThumbnail = form.querySelector('input[name="thumbnail"], input[type="file"][id*="thumbnail"]');
            
            if (hasThumbnail) {
                // Attach submit handler
                form.addEventListener('submit', handleCourseFormSubmit);
            }
        });

        // Initialize preview
        initThumbnailPreview();
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Also expose utility function globally
    window.convertFileToBase64 = fileToBase64;
    window.handleCourseFormSubmit = handleCourseFormSubmit;

})();

