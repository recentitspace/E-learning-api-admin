<?php

use Illuminate\Support\Str;
use Modules\LMS\Models\Faq;
use Modules\LMS\Models\Icon;
use Modules\LMS\Models\User;
use Modules\LMS\Classes\Cart;
use Illuminate\Support\Carbon;
use Modules\LMS\Enums\UserType;
use Modules\LMS\Models\Category;
use Modules\LMS\Models\Currency;
use Modules\LMS\Models\Language;
use Modules\LMS\Models\Blog\Blog;
use Modules\LMS\Models\Hero\Hero;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Modules\LMS\Enums\CourseStatus;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Designation;
use Modules\LMS\Models\Forum\Forum;
use Modules\LMS\Models\ServiceType;
use Modules\LMS\Models\Testimonial;
use Modules\LMS\Models\Theme\Theme;
use Modules\LMS\Models\Translation;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Modules\LMS\Models\IconProvider;
use Illuminate\Support\Facades\Cache;
use Modules\LMS\Models\Courses\Level;
use Modules\LMS\Models\PaymentMethod;
use Illuminate\Support\Facades\Schema;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Courses\Review;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Storage;
use Modules\LMS\Models\Courses\Subject;
use Illuminate\Support\Facades\Response;
use Spatie\Permission\Models\Permission;
use Modules\LMS\Models\Blog\BlogCategory;
use Modules\LMS\Models\Coupon\CouponType;
use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Models\Localization\State;
use Modules\LMS\Models\Auth\UserCourseExam;
use Modules\LMS\Models\General\ThemeSetting;
use Modules\LMS\Models\Localization\Country;
use Modules\LMS\Models\Courses\CourseSetting;
use Modules\LMS\Models\Localization\TimeZone;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\MeetProvider\MeetProviders;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Models\SupportTicket\SupportCategory;
use Modules\LMS\Models\Courses\Topics\Quizzes\QuizType;

if (!function_exists('fileExists')) {
    /**
     * Check if a file exists in a given folder.
     *
     * @param string $folder
     * @param string $fileName
     * @return bool True if the file exists, otherwise false.
     */
    function fileExists($folder,  $fileName): bool
    {
        return !empty($fileName) && Storage::disk('LMS')->exists("public/{$folder}/{$fileName}");
    }
}

if (!function_exists('get_all_country')) {
    /**
     * Retrieve all countries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_country($locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }
        return Country::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])->get();
    }
}

if (!function_exists('get_all_state')) {
    /**
     * Retrieve all states.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_state()
    {
        return State::all();
    }
}

if (!function_exists('get_all_icon_provider')) {
    /**
     * Retrieve all icon providers.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_icon_provider()
    {
        return IconProvider::all();
    }
}

if (!function_exists('get_all_category')) {
    /**
     * Retrieve all categories based on optional filters.
     *
     * @param string|null $type
     * @param bool|null $status
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_category($type = null, $status = null, $item = null, $locale = null)
    {
        $categories = Category::query();

        if (! $locale) {
            $locale = app()->getLocale();
        }

        if ($type == 'cat') {
            $categories->whereNotNull('parent_id');
        }
        if ($type == 'sub') {
            $categories->whereNull('parent_id');
        }

        if ($status) {
            $categories->where('status', 1);
        }
        $categories->with([
            'courses' => function ($query) {
                $query->where('status', CourseStatus::APPROVED);
            },
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        return ($item) ? $categories->paginate($item) :  $categories->get();
    }
}

if (!function_exists('get_all_icon')) {
    /**
     * Retrieve all icons.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function get_all_icon()
    {
        return Icon::all();
    }
}

/**
 * Retrieve all instructors, optionally filtered by organization ID.
 *
 * @param int|null $organizationId The ID of the organization to filter instructors.
 * @return Collection The collection of instructors.
 */
if (! function_exists('get_all_instructor')) {

    function get_all_instructor($organizationId = null, $locale = null)
    {
        // Build the query for instructors

        if (! $locale) {
            $locale = app()->getLocale();
        }
        $user = User::query();
        if (! empty($organizationId)) {
            $user->where('organization_id', $organizationId);
        }
        return $user->where('guard', 'instructor')
            ->with(['userable', 'userable.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }])
            ->get();
    }
}


/**
 * Retrieve all levels.
 *
 * @return Collection The collection of levels.
 */
if (!function_exists('get_all_level')) {
    function get_all_level($locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }

        return Level::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])->get(); // Use all() instead of get() for better readability
    }
}

/**
 * Retrieve all languages with optional filtering by type.
 *
 * @param string|null $type The type of association to load ('instructor' or 'organization').
 * @return Collection The collection of languages.
 */
if (!function_exists('get_all_language')) {
    function get_all_language($type = null,  $locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }
        $languages = Language::query();
        switch ($type) {
            case 'instructor':
                $languages->with(['instructors' => function ($query) {
                    $query->where('status', 1);
                }])->withCount('instructors');
                break;

            case 'organization':
                $languages->with(['organizations' => function ($query) {
                    $query->where('status', 1);
                }])->withCount('organizations');
                break;
        }

        if (! $locale) {
            $locale = app()->getLocale();
        }

        $languages->with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ]);
        return $languages->get();
    }
}



/**
 * Retrieve all subjects.
 *
 * @return Collection The collection of subjects.
 */
if (!function_exists('get_all_subject')) {
    function get_all_subject($locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }

        return Subject::with([
            'translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])->get();
    }
}


/**
 * Retrieve all time zones with optional related data based on type.
 *
 * @param string|null $type Optional type to filter related data ('instructor' or 'organization').
 * @return Collection The collection of time zones.
 */
if (!function_exists('get_all_zones')) {

    function get_all_zones($type = null)
    {
        $timeZones = TimeZone::query();

        if ($type) {
            $relation = ($type == 'instructor') ? 'instructors' : 'organizations';
            $timeZones->with([$relation => function ($query) {
                $query->where('status', 1);
            }])->withCount($relation);
        }

        return $timeZones->get(); // Changed from get() to all() for consistency if no additional filtering.
    }
}


/**
 * Retrieve all organizations.
 *
 * This function fetches all users with the 'organization' guard and includes their related 'userable' data.
 *
 * @return Collection The collection of users who are organizations.
 */
if (!function_exists('get_all_organization')) {

    function get_all_organization($locale = null)
    {
        if (! $locale) {
            $locale = app()->getLocale();
        }

        return User::with([
            'userable',
            'userable.translations' => function ($query) use ($locale) {
                $query->where('locale', $locale);
            }
        ])
            ->where('guard', 'organization')
            ->get(); // Use get() for clarity in this context since it fetches all organizations.
    }
}

/**
 * Retrieve all topic types.
 *
 * This function fetches all records from the TopicType model.
 *
 * @return Collection The collection of all topic types.
 */
if (!function_exists('get_all_topic_type')) {

    function get_all_topic_type()
    {
        return TopicType::all(); // Fetch all topic types from the database.
    }
}

/**
 * Retrieve all quiz types.
 *
 * This function fetches all records from the QuizType model.
 *
 * @return Collection The collection of all quiz types.
 */
if (!function_exists('get_all_quiz_type')) {

    function get_all_quiz_type()
    {
        return QuizType::all(); // Fetch all quiz types from the database.
    }
}


/**
 * Retrieve all courses or filter by status.
 *
 * This function fetches all courses from the Course model. If a status is provided,
 * only courses with that status will be returned.
 *
 * @param string|null $status The status to filter courses by. If null, all courses are returned.
 * @return Collection The collection of courses.
 */
if (!function_exists('get_all_course')) {

    function get_all_course($status = null)
    {
        // Query to get courses based on the provided status.
        return $status
            ? Course::where('status', CourseStatus::APPROVED)->get()
            : Course::all();
    }
}




/**
 * Retrieve all coupon types.
 *
 * This function fetches all the coupon types from the database.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of all coupon types.
 */
if (!function_exists('get_all_coupon_type')) {
    function get_all_coupon_type()
    {
        return CouponType::all();
    }
}


/**
 * Retrieve all blog categories.
 *
 * This function fetches all blog categories, optionally filtered by their status.
 *
 * @param string|null $status The status to filter blog categories by. If null, all categories are returned.
 * @return \Illuminate\Database\Eloquent\Collection A collection of blog categories.
 */
if (!function_exists('get_all_blog_category')) {
    function get_all_blog_category($status = null)
    {
        if (isset($status)) {
            return BlogCategory::withCount('blogs')->with('translations')->where('status', $status)->get();
        }

        return BlogCategory::all();
    }
}


/**
 * Retrieve all meeting providers.
 *
 * This function fetches all available meeting providers from the database.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of meeting providers.
 */
if (!function_exists('get_all_mprovider')) {
    function get_all_mprovider()
    {
        return MeetProviders::all();
    }
}

/**
 * Retrieve instructors associated with the authenticated organization.
 *
 * This function fetches the instructors linked to the currently authenticated user
 * who is an organization. It returns the instructors' details or null if none are found.
 *
 * @return \Illuminate\Database\Eloquent\Collection|null A collection of instructors or null if not found.
 */
if (!function_exists('getInstructorByOrg')) {
    function getInstructorByOrg()
    {
        $user = User::with('organizationInstructors.userable')
            ->where([
                'id' => Auth::user()->id,
                'guard' => UserType::ORGANIZATION
            ])
            ->first();

        return $user ? $user->organizationInstructors : null;
    }
}

/**
 * Check if the user is authenticated and retrieve user details.
 *
 * This function checks if the user is logged in. If authenticated, it loads the user's
 * related models: userable, educations, and experiences. It returns the user object
 * if the userable relationship is not empty, otherwise returns null.
 *
 * @return \Illuminate\Foundation\Auth\User|null The authenticated user object or null if not authenticated.
 */
if (!function_exists('authCheck')) {
    function authCheck()
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::user();
            // Return user if userable relationship is not empty
            return $user?->userable ? $user : null;
        }

        return null; // Explicitly return null if not authenticated
    }
}

/**
 * Retrieve all roles for the 'admin' guard.
 *
 * This function fetches all roles that are associated with the 'admin' guard name
 * from the database. It returns a collection of Role models.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of roles for the 'admin' guard.
 */
if (!function_exists('get_all_role')) {
    function get_all_role()
    {
        return Role::where('guard_name', 'admin')->get();
    }
}

/**
 * Retrieve all permissions for the 'admin' guard grouped by module.
 *
 * This function fetches all permissions associated with the 'admin' guard name
 * from the database and groups them by their respective modules.
 *
 * @return \Illuminate\Support\Collection A collection of permissions grouped by module.
 */
if (!function_exists('get_all_permission')) {
    function get_all_permission()
    {
        return Permission::where('guard_name', 'admin')->get()->groupBy('module');
    }
}


/**
 * Clean the given content using HTML Purifier.
 *
 * This function utilizes HTML Purifier to sanitize and clean the input content,
 * removing any malicious or unwanted HTML tags and attributes.
 *
 * @param string $content The content to be cleaned.
 * @return string The sanitized content.
 */
if (!function_exists('clean')) {
    function clean($content)
    {
        return Purify::clean($content);
    }
}


/**
 * Retrieve all courses associated with the authenticated organization.
 *
 * This function fetches a collection of courses that belong to the
 * organization of the currently authenticated user. It relies on the
 * authCheck() function to retrieve the user's organization ID.
 *
 * @return Collection A collection of courses for the authenticated organization.
 */
if (!function_exists('getOrganizationCourse')) {
    function getOrganizationCourse()
    {
        $authUser = authCheck();

        // Ensure the user is authenticated before querying
        return $authUser ? Course::where('organization_id', $authUser->id)->get() : collect();
    }
}

/**
 * Generate a random alphanumeric string of a specified length.
 *
 * This function generates a random string containing uppercase letters
 * and digits. The default length of the string is 6 characters.
 *
 * @param int $length The length of the generated string. Default is 6.
 * @return string The generated random string.
 */
if (!function_exists('random_string')) {
    function random_string($length = 6)
    {
        // Define the characters to choose from
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Generate a random string of the specified length
        return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);
    }
}


if (!function_exists('customDateFormate ')) {
    /**
     * Format a date to a custom format or a default format.
     *
     * @param mixed $date
     * @param string|null $format
     * @return string
     */
    function customDateFormate($date, $format = null): string
    {
        $parse = Carbon::parse($date);
        $format = $format ?? config('lms.date_format') ?? 'd M y';
        return $parse->format($format);
    }
}

if (! function_exists('get_options')) {
    function get_options($key = 'options')
    {

        return Cache::rememberForever($key, function () {
            return ThemeSetting::all()->keyBy('key');
        });
    }
}

if (! function_exists('refresh_options')) {
    function refresh_options($key = 'options')
    {
        if (Cache::has($key)) {
            Cache::forever($key, ThemeSetting::all()->keyBy('key'));
        } else {
            get_options($key);
        }
    }
}

/**
 * Retrieve theme option by key.
 *
 * This function retrieves the theme setting for the given key and returns
 * its content as an associative array. If the key does not exist or the
 * content cannot be decoded, it returns an empty array or false.
 *
 * @param string $key The key of the theme option to retrieve.
 * @return array|false The decoded content of the theme option or false if the key is not provided.
 */
if (!function_exists('get_theme_option')) {
    function get_theme_option($key, $theme_slug = 'default',  $parent_key = null)
    {
        $options = app('options') ?? [];

        if (empty($options)) {
            $options = get_options();
        }

        $option_name = $key;
        if ($parent_key) {
            $option_name = $parent_key;
        }
        $option_name = $theme_slug === 'default' ? $option_name : "{$option_name}_" . key_snake_case($theme_slug);
        $option = $options[$option_name] ?? null;

        // Handle both JSON string and array (due to model casting)
        if ($option) {
            if (is_string($option->content)) {
                $option_value = json_decode($option->content, true);
            } else {
                $option_value = $option->content; // Already an array due to model casting
            }
        } else {
            $option_value = [];
        }

        if ($parent_key && is_array($option_value) && isset($option_value[$key])) {
            return $option_value[$key];
        }

        return $option_value;
    }
}



/**
 * Retrieve all students.
 *
 * This function fetches all users with the 'student' guard, including
 * their related userable information.
 *
 * @return Collection A collection of users who are students.
 */

if (!function_exists('get_all_student')) {
    function get_all_student($count = null)
    {
        return User::with('userable')
            ->where('guard', 'student')
            ->when($count, function ($query, $count) {
                return $query->take($count);
            })
            ->get();
    }
}

/**
 * Check if the application is already installed.
 *
 * This function verifies the presence of an installation marker file.
 *
 * @return bool Returns true if installed, false otherwise.
 */
if (!function_exists('alreadyInstalled')) {
    function alreadyInstalled()
    {
        return file_exists(storage_path('installed'));
    }
}

/**
 * Check if the index file exists.
 *
 * This function checks for the presence of the 'index.php' file in the public directory.
 *
 * @return bool Returns true if the index file exists, false otherwise.
 */
if (!function_exists('indexFile')) {
    function indexFile()
    {
        return File::exists(public_path('index.php'));
    }
}


/**
 * Retrieve the latest categories.
 *
 * This function fetches the most recent top-level categories (where parent_id is null)
 * that are active (status = 1), along with a count of their associated courses.
 *
 * @param int $item The number of categories to retrieve. Default is 9.
 * @return \Illuminate\Database\Eloquent\Collection The collection of categories.
 */
if (!function_exists('latestCategory')) {
    function latestCategory($item = 9)
    {
        return Category::withWhereHas('courses', function ($query) {
            $query->where('status', CourseStatus::APPROVED)
                ->withWhereHas(
                    'instructors',
                    function ($query1) {
                        $query1->where('is_verify', 1)
                            ->withWhereHas(
                                'userable',
                                function ($query2) {
                                    $query2->where('status', 1);
                                }
                            );
                    }
                )
                ->with('courseSetting');
        })

            ->where(['parent_id' => null, 'status' => 1])
            ->latest()
            ->withCount('courses')
            ->take($item)
            ->get();
    }
}

/**
 * Retrieve active course categories with approved courses.
 *
 * This function fetches the top-level categories (where parent_id is null)
 * that are active (status = 1) and have approved courses.
 * It also counts the number of approved courses in each category.
 *
 * @param int|null $item The maximum number of categories to retrieve. Default is 9.
 * @return \Illuminate\Database\Eloquent\Collection The collection of categories.
 */
if (!function_exists('courseCategory')) {
    function courseCategory($item = 9)
    {
        $categoryQuery = Category::query()
            ->where(['parent_id' => null, 'status' => 1])
            ->whereHas('courses', function ($query) {
                $query->where('status', CourseStatus::APPROVED)
                    ->withWhereHas(
                        'instructors',
                        function ($query1) {
                            $query1->where('is_verify', 1)
                                ->with(
                                    'userable',
                                    function ($query2) {
                                        $query2->where('status', 1);
                                    }
                                );
                        }
                    )
                    ->with('courseSetting');
            })
            ->withCount('courses')
            ->with('translations')
            ->latest();

        // Limit the number of categories if specified
        if ($item) {
            $categoryQuery->take($item);
        }

        return $categoryQuery->get();
    }
}

/**
 * Retrieve all forums.
 *
 * This function fetches all available forums from the database.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of forum instances.
 */
if (!function_exists('forums')) {
    function forums()
    {
        return Forum::all();
    }
}



/**
 * Get the image path for a user based on their guard type.
 *
 * This function returns the appropriate image path based on the user's guard.
 *
 * @param string $guard The type of user guard (instructor, student, organization).
 * @return string|null The image path for the user, or null if the guard type is invalid.
 */
if (!function_exists('userImagePath')) {
    function userImagePath($guard)
    {
        switch ($guard) {
            case 'instructor':
                return 'instructors';
            case 'student':
                return 'students'; // Corrected to 'students' for consistency
            case 'organization':
                return 'organizations';
            default:
                return null; // Return null for invalid guard types
        }
    }
}


/**
 * Retrieve the list of purchased courses for the authenticated user.
 *
 * This function fetches the purchase details for courses associated with
 * the currently authenticated user. It includes the course title in the result.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of purchase details, including course titles.
 */
if (!function_exists('purchaseCourses')) {
    function purchaseCourses()
    {
        $userId = authCheck()->id; // Retrieve the authenticated user's ID

        return PurchaseDetails::with(['course' => function ($query) {
            $query->select('id', 'title'); // Select only the ID and title of the course
        }])
            ->where([
                'user_id' => $userId,
                'type' => PurchaseType::PURCHASE,
                'purchase_type' => PurchaseType::COURSE,
            ])
            ->select('purchase_id', 'course_id', 'bundle_id', 'user_id', 'price', 'type')
            ->get();
    }
}



/**
 * Retrieve the list of purchased and enrolled courses for the authenticated user.
 *
 * This function fetches the purchase details for courses associated with
 * the currently authenticated user. It includes the course title in the result.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of purchase details, including course titles.
 */
if (!function_exists('purchase_enrolled_courses')) {
    function purchase_enrolled_courses()
    {
        $userId = authCheck()->id; // Retrieve the authenticated user's ID

        return PurchaseDetails::with(['course' => function ($query) {
            $query->with('translations');
            $query->select('id', 'title'); // Select only the ID and title of the course
        }])
            ->where([
                'user_id' => $userId,
                'purchase_type' => PurchaseType::COURSE,
            ])
            ->select('purchase_id', 'course_id', 'bundle_id', 'user_id', 'price', 'type')
            ->get();
    }
}



/**
 * Retrieve all support categories.
 *
 * This function fetches all available support categories from the database.
 *
 * @return \Illuminate\Database\Eloquent\Collection A collection of support categories.
 */
if (!function_exists('supportCategories')) {
    function supportCategories()
    {
        return SupportCategory::all(); // Use all() to retrieve all support categories
    }
}



/**
 * Generate a random string or number.
 *
 * This function generates a random string or number based on the specified type.
 *
 * @param int $length The length of the generated string or number.
 * @param string $type The type of output: 'str' for a string and 'int' for a numeric string.
 * @return string A randomly generated string or numeric string.
 */
if (!function_exists('strRandom')) {
    function strRandom(int $length = 10, string $type = 'str'): string
    {
        // Generate a random numeric string if type is 'int'
        if (strtolower($type) === 'int') {
            return generateRandomNumber($length);
        }

        // Default to generating a random string
        return Str::random($length);
    }

    /**
     * Helper function to generate a random numeric string.
     *
     * @param int $length The length of the numeric string.
     * @return string A randomly generated numeric string.
     */
    function generateRandomNumber(int $length): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}


/**
 * Check if the authenticated user has a specific role.
 *
 * @param string $role The name of the role to check.
 * @return bool True if the user has the specified role, false otherwise.
 */
if (!function_exists('hasRole')) {
    function hasRole(string $role): bool
    {
        $roles = app('user_role_list');

        if (! $roles) {
            return authCheck()?->roles()->where('name', $role)->exists() ?? false;
        }

        return in_array($role, $roles);
    }
}

/**
 * Check if the authenticated user is an organization.
 *
 * @return bool True if the user is an organization, false otherwise.
 */
if (!function_exists('isOrganization')) {
    function isOrganization(): bool
    {
        return hasRole('Organization');
    }
}

/**
 * Check if the authenticated user is an instructor.
 *
 * @return bool True if the user is an instructor, false otherwise.
 */
if (!function_exists('isInstructor')) {
    function isInstructor(): bool
    {
        return hasRole('Instructor');
    }
}

/**
 * Check if the authenticated user is a student.
 *
 * @return bool True if the user is a student, false otherwise.
 */
if (!function_exists('isStudent')) {
    function isStudent(): bool
    {
        return hasRole('Student');
    }
}

/**
 * Check if the authenticated user is an admin.
 *
 * @return bool True if the user is an admin, false otherwise.
 */
if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        return Auth::guard('admin')->check();
    }
}



if (!function_exists('orderNumber')) {
    /**
     * Generate a unique order number.
     *
     * @return string The generated order number.
     */
    function orderNumber($prefix = 'cs'): string
    {
        return $prefix . customDateFormate(now(), 'dmyhi');
    }
}

if (!function_exists('dotZeroRemove')) {

    /**
     * Remove trailing ".00" or ",00" from a price string.
     *
     * @param string $price The price string to process.
     * @return string The price string without trailing zeros.
     */
    function dotZeroRemove(string $price): string
    {
        return preg_replace('/[\.,]0{2}$/', '', $price);
    }
}

if (! function_exists('instructorCourse')) {

    /**
     * Retrieve the courses associated with verified instructors who have an active status.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function instructorCourse()
    {
        $model = User::query();

        return $model->whereHas('userable', function ($query) {
            $query->where('status', 1);
        })
            ->withWhereHas('courses', function ($query) {
                $query->with('reviews');
                $query->where('status', CourseStatus::APPROVED);
            })
            ->withCount('courses')
            ->where('guard', 'instructor')
            ->where('is_verify', 1)
            ->with('userable.translations')
            ->get();
    }
}


if (! function_exists('get_course_by_instructorId')) {
    function get_course_by_instructorId($id = null)
    {
        $model = User::query();

        if (!$id) {
            return [];
        }
        $instructor = $model->whereHas('userable', function ($query) {
            $query->where('status', 1);
        })
            ->withWhereHas('courses', function ($query) {
                $query->where('status', CourseStatus::APPROVED);
            })
            ->withCount('courses')
            ->where('guard', 'instructor')
            ->where('is_verify', 1)
            ->where('id', $id)
            ->first();


        return $instructor->courses ?? [];
    }
}



if (! function_exists('courseLevel')) {

    /**
     * Retrieve levels associated with approved courses.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function courseLevel()
    {
        $level = Level::query();

        return $level->whereHas('courses', function ($query) {
            $query->where('status', CourseStatus::APPROVED);
        })
            ->withCount('courses')
            ->get();
    }
}


if (! function_exists('courseLanguage')) {
    function courseLanguage()
    {
        // Start a query on the Language model
        $languageQuery = Language::query();

        // Filter languages to those that have approved courses
        return $languageQuery->whereHas('courses', function ($query) {
            // Only consider courses with an approved status
            $query->where('status', CourseStatus::APPROVED);
        })
            // Add a count of associated courses to each language record
            ->withCount('courses')
            // Execute the query and return the results
            ->with('translations')
            ->get();
    }
}



if (!function_exists('dateCompare')) {
    /**
     * Compare a given date with the current date.
     *
     * @param mixed $data The date to compare.
     * @return bool True if the given date is greater than or equal to the current date, otherwise false.
     */
    function dateCompare($data): bool
    {
        $data = Carbon::parse($data);
        $currentDate = Carbon::now();
        return $data->gte($currentDate); // Return the comparison result directly
    }
}

if (!function_exists('discountPercentage')) {
    /**
     * Calculate the discount percentage.
     *
     * @param float $price The original price.
     * @param float $discountPrice The discounted price.
     * @return float The discount percentage.
     */
    function discountPercentage(float $price, float $discountPrice): float
    {
        return ($discountPrice / $price) * 100; // Calculate and return the discount percentage
    }
}

if (!function_exists('latestBlogs')) {
    /**
     * Retrieve the latest blogs.
     *
     * @param int $item The number of blogs to retrieve (default is 3).
     * @return \Illuminate\Database\Eloquent\Collection A collection of the latest blogs.
     */
    function latestBlogs(int $item = 3)
    {
        return Blog::latest()->where('status', 1)->take($item)->get(); // Fetch and return latest blogs
    }
}

if (!function_exists('all_designation')) {
    /**
     * Retrieve all designations with active instructors.
     *
     * @return \Illuminate\Database\Eloquent\Collection A collection of designations.
     */
    function all_designation()
    {
        return Designation::whereHas('instructors', function ($query) {
            $query->where('status', 1); // Filter designations with active instructors
        })->withCount('instructors')->with('translations')->get(); // Get designations with instructor count
    }
}

if (!function_exists('all_faq')) {
    /**
     * Retrieve FAQs with optional pagination.
     *
     * @param int|null $item The number of FAQs to retrieve (null for all).
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Pagination\LengthAwarePaginator The FAQs.
     */
    function all_faq($item = null)
    {
        $faqs = Faq::query();
        return $item ? $faqs->get() : $faqs->paginate(10); // Retrieve all or paginate FAQs
    }
}



if (!function_exists('bundle_course_check')) {

    function bundle_course_check($courseId)
    {

        $bundles = PurchaseDetails::select('bundle_id')->where(['user_id' => authCheck()->id, 'purchase_type' => PurchaseType::BUNDLE])->pluck('bundle_id')->toArray();
        $status = false;
        if (!is_array($bundles)) {
            return  $status;
        }
        foreach ($bundles as  $bundleId) {
            if (DB::table('course_bundle_courses')->where(['course_bundle_id' => $bundleId, 'course_id' => $courseId])->exists()) {
                $status = true;
                break;
            }
        }
        return  $status;
    }
}

if (!function_exists('purchaseCheck')) {
    /**
     * Check if a purchase exists for the given item and type.
     *
     * @param int|null $id The ID of the item.
     * @param string|null $type The type of item ('course' or 'bundle').
     * @return bool True if the purchase exists, otherwise false.
     */
    function purchaseCheck($id = null, $type = null): bool
    {
        $user = authCheck();
        // Check if user is authenticated and both ID and type are provided.
        if ($user && isset($id, $type)) {
            $options = $type === 'course' ? ['course_id' => $id] : ['bundle_id' => $id];
            // Check for existing purchase details for the authenticated user.
            if (bundle_course_check($id) ||  PurchaseDetails::where($options)->where('user_id',  $user->id)->exists()) {
                return true;
            }
        }

        return false; // Return false if conditions are not met.
    }
}


if (!function_exists('is_free')) {
    /**
     * Check if a course or bundle is free.
     *
     * @param int|null $id The ID of the course or bundle.
     * @param string|null $type The type of item ('course' or 'bundle').
     * @return bool True if the item is free, otherwise false.
     */
    function is_free($id = null, $type = null): bool
    {
        // Check if the type is a bundle and retrieve the corresponding bundle
        if ($type === 'bundle') {
            $bundle = CourseBundle::where('id', $id)->first();
            return $bundle && $bundle->price <= 0; // Return true if the bundle price is 0 or less
        }

        // Check if the type is a course and retrieve the corresponding course setting
        if ($type === 'course') {
            $courseSetting = CourseSetting::where('course_id', $id)->first();
            return $courseSetting && $courseSetting->is_free == 1; // Return true if the course is marked as free
        }

        // Default return false if the type is not recognized or no item is found
        return false;
    }
}


if (!function_exists('review')) {
    /**
     * Get the rating summary for a course.
     *
     * @param int|Course $courseId The ID of the course.
     * @return array An array containing star counts, average rating, and total ratings.
     */
    function review($course): array
    {
        // Initialize star counts
        $starCounts = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0
        ];

        // Retrieve all reviews for the specified course
        // $courseReviews = Review::where('course_id', $courseId)->get()->toArray();
        if (! $course instanceof Course) {
            $course = Course::find($course);
        }

        $courseReviews = [];
        if ($course) {
            $courseReviews = $course->reviews->toArray();
        }

        // If there are no reviews, return default values
        if (empty($courseReviews)) {
            return [
                'rating' => $starCounts,
                'average_rating' => 0,
                'total_rating' => 0,
            ];
        }

        // Calculate the rating for each review
        foreach ($courseReviews as $review) {
            $singleRating = ($review['support_quality'] + $review['content_quality'] + $review['instructor_skills']) / 3;
            $rating = round($singleRating);

            // Increment the count for the corresponding star rating
            if (isset($starCounts[$rating])) {
                $starCounts[$rating]++;
            }
        }

        // Calculate the weighted sum of ratings and the total number of ratings
        $sumWeightedRatings = 0;
        $totalRatings = 0;
        foreach ($starCounts as $star => $count) {
            $sumWeightedRatings += $star * $count; // Weighted sum
            $totalRatings += $count; // Total count of ratings
        }

        // Calculate the average rating
        $averageRating = $totalRatings > 0 ? $sumWeightedRatings / $totalRatings : 0; // Prevent division by zero

        // Return the rating summary
        return [
            'rating' => $starCounts,
            'average_rating' => number_format($averageRating, 2), // Format average rating to 2 decimal places
            'total_rating' => $totalRatings,
        ];
    }
}



if (!function_exists('user_review_rating')) {
    /**
     * Get the average rating for a user's review of a specific course.
     *
     * @param int $courseId The ID of the course.
     * @param int $userId The ID of the user.
     * @return int The average rating (0 if no review exists or inputs are invalid).
     */
    function user_review_rating(int $courseId, int $userId): int
    {
        // Check if courseId and userId are provided
        if (!isset($courseId, $userId)) {
            return 0; // Return 0 if either ID is not set
        }

        // Retrieve the user's review for the specified course
        $review = Review::where(['course_id' => $courseId, 'user_id' => $userId])->first();

        // If no review exists, return 0
        if (!$review) {
            return 0;
        }

        // Calculate the average rating from the review qualities
        $rating = ($review->support_quality + $review->content_quality + $review->instructor_skills) / 3;

        // Return the rounded average rating
        return round($rating);
    }
}




if (!function_exists('show_rating')) {
    /**
     * Generate HTML for displaying a star rating.
     *
     * @param float $rating The rating value (from 0 to 5, can include half values).
     * @return string HTML string representing the star rating.
     */
    function show_rating(float $rating): string
    {
        $html = '';
        // Loop through the stars from 1 to 5
        for ($i = 1; $i <= 5; $i++) {
            // Check if the star should be filled
            if ($i <= $rating) {
                $html .= '<i class="ri-star-fill text-inherit"></i>';
                // Check if the star should be half-filled
            } elseif ($i - 0.5 == $rating) {
                $html .= '<i class="ri-star-half-fill text-inherit"></i>';
                // The star is empty
            } else {
                $html .= '<i class="ri-star-line text-inherit"></i>';
            }
        }

        return $html; // Return the generated HTML
    }
}



if (!function_exists('total_qty')) {
    /**
     * Get the total quantity of items in the cart.
     *
     * @return int The total quantity of items in the cart.
     */
    function total_qty(): int
    {
        // Retrieve the total cart quantity from the Cart service.
        return Cart::cartQty();
    }
}


/**
 * getCourseByStatus
 */
if (! function_exists('getCourseByStatus')) {
    function getCourseByStatus($status = null)
    {
        $course = Course::query();
        return $course->where('status', CourseStatus::APPROVED)
            ->whereHas('courseSetting', function ($query) use ($status) {
                if ($status == 'free') {
                    $query->where('is_free', 1);
                }

                if ($status == 'paid') {
                    $query->where('is_free', 0);
                }
            })
            ->get();
    }
}


if (!function_exists('has_permissions')) {

    /**
     * Check if the user has a specific permission.
     *
     * @param User $user The authenticated user instance.
     * @param array $permission The required permission to check.
     * @return bool True if the user has the permission, otherwise false.
     */
    function has_permissions($user, $permissions)
    {
        return collect($permissions)->every(fn($permission) => $user->can($permission));
    }
}



if (!function_exists('json_error')) {
    /**
     * Return a standardized JSON error response.
     *
     * @param string $message The error message to include in the response.
     * @return \Illuminate\Http\JsonResponse The error response in JSON format.
     */
    function json_error($message)
    {
        return response()->json([
            'status' => 'error',
            'message' => translate($message)
        ]);
    }
}




if (!function_exists('all_testimonial')) {
    function all_testimonial($count = null)
    {
        return Testimonial::where('status', 1)->get();
    }
}

if (!function_exists('instructor_student')) {
    function instructor_student(array $courseId)
    {
        if ($courseId)
            return PurchaseDetails::whereIn('course_id', $courseId)->get();

        return 0;
    }
}


// Check if the 'all_testimonial' function exists before defining it
if (!function_exists('all_testimonial')) {

    /**
     * Retrieve all active testimonials
     *
     * @return Collection Returns a collection of testimonials where status is active (status = 1)
     */
    function all_testimonial()
    {
        // Fetch testimonials with 'status' set to 1 (active) and return them
        return Testimonial::where('status', 1)->get();
    }
}

// Check if the 'instructor_student' function exists before defining it
if (!function_exists('instructor_student')) {

    /**
     * Retrieve purchase details based on course IDs
     *
     * @param array $courseId Array of course IDs to filter purchases
     * @return Collection|int Returns a collection of purchase details if course IDs are provided,
     *                        otherwise returns 0
     */
    function instructor_student(array $coursesId)
    {
        // Check if course IDs are provided
        if (!empty($coursesId)) {
            // Fetch purchase details for the given course IDs and return the result
            return PurchaseDetails::whereIn('course_id', $coursesId)->get();
        }

        // Return 0 if no course IDs are provided
        return 0;
    }
}




if (!function_exists('instructorOrgUser_review')) {

    /**
     *  instructorOrgUser_review
     *
     * @param array $coursesId
     *
     * @return array
     */
    function instructorOrgUser_review($coursesId)
    {
        $total = 0;
        $average = 0;
        if (!empty($coursesId)) {
            foreach ($coursesId as  $courseId) {
                $review = review($courseId);
                if ($review['total_rating']) {
                    $total++;
                    $average += $review['average_rating'];
                }
            }
        }
        return  [
            'average_rating' => !empty($average) ? $average / $total : 0,
            'total' =>  $total
        ];
    }
}

// Check if the function `userAssignmentCheck` already exists to avoid re-declaration.
if (!function_exists('userAssignmentCheck')) {

    /**
     * Check if the user is assigned to a specific assignment.
     *
     * @param int $assignmentId The ID of the assignment to check.
     * @return mixed Returns the first matching UserCourseExam record or null if not found.
     */
    function userAssignmentCheck($assignmentId)
    {
        // Prepare the conditions for the query: assignment ID and authenticated user ID.
        $option = [
            'assignment_id' => $assignmentId,
            'user_id' => authCheck()->id
        ];

        // Perform the database query and return the result.
        return UserCourseExam::where($option)->first();
    }
}

// Check if the function `getFileExtension` already exists to avoid re-declaration.
if (!function_exists('getFileExtension')) {

    /**
     * Get the file extension from a given filename.
     *
     * @param string $filename The name of the file.
     * @return string The file extension of the provided filename.
     */
    function getFileExtension($filename)
    {
        // Use PHP's pathinfo function to extract the file extension.
        $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);

        // Return the extracted file extension.
        return $fileExtension;
    }
}

// Check if the function `is_active` already exists to avoid re-declaration.
if (!function_exists('is_active')) {

    /**
     * Determine if a given route is active.
     *
     * @param string $route The route name or pattern to check.
     * @param string $output The class or value to return if the route is active (default: 'active').
     * @return string Returns the output string if the route matches, otherwise an empty string.
     */
    function is_active($route, $output = 'active')
    {
        // Check if the current route matches the specified route and return the output string if true.
        return request()->routeIs($route) ? $output : '';
    }
}


if (!function_exists('str_limit')) {

    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int  $limit
     * @param  string  $end
     * @param  bool  $preserveWords
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...', $preserveWords = false)
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        if (! $preserveWords) {
            return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
        }

        $value = trim(preg_replace('/[\n\r]+/', ' ', strip_tags($value)));

        $trimmed = rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8'));

        if (mb_substr($value, $limit, 1, 'UTF-8') === ' ') {
            return $trimmed . $end;
        }

        return preg_replace("/(.*)\s.*/", '$1', $trimmed) . $end;
    }
}

if (!function_exists('app_version')) {
    function app_version()
    {

        return config('lms.app_version');
    }
}

if (! function_exists('get_translations')) {
    function get_translations($lang)
    {
        return Cache::rememberForever("translations-{$lang}", function () use ($lang) {
            return Translation::select('lang_key', 'lang_value')->where('lang', $lang)->pluck('lang_value', 'lang_key')->toArray();
        });
    }
}


if (! function_exists('translate')) {

    function translate($key, $value = null, $lang = null, $addslashes = false)
    {
        // // Determine the current language if not provided
        $lang = $lang ?? App::getLocale();
        // Normalize the translation key
        $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

        // if (checkDatabaseConnection() && Schema::hasTable('cache')) {

        // Fetch translations from the cache or database
        // return $translations[$lang_key] ?? $key;
        $app = app();
        $translations = $app['translations'] ?? [];
        if (empty($translations)) {
            $translations = get_translations($lang);
        }

        // Add a new translation if it does not exist
        if (!isset($translations[$lang_key])) {
            Translation::firstOrCreate(
                ['lang' => $lang, 'lang_key' => $lang_key],
                ['lang_value' => $value ?: $key]
            );
            // Refresh cache
            Cache::forget("translations-{$lang}");
            $translations = get_translations($lang);
        }
        // Return the appropriate translation
        $translation = $translations[$lang_key] ?? $key;
        return $addslashes ? addslashes($translation) : $translation;
        // }


    }
}

if (! function_exists('parse_translation')) {
    function parse_translation($model, $locale = null)
    {
        $translations = $model->translations ?? [];

        if (empty($translations)) {
            return [];
        }

        $translations = $translations->groupBy('locale');

        if (! $locale) {
            $locale = app()->getLocale();
        }

        if (!isset($translations[$locale])) {
            $locale = app('default_language');
        }

        $translations = isset($translations[$locale]) ? $translations[$locale]->toArray() : [];

        return count($translations) > 0 ? $translations[0]['data'] : [];
    }
}

if (!function_exists('get_languages')) {
    function get_languages($locale = null)
    {
        $languages =  Language::where('status', 1)->get();

        if ($locale) {
            $languages =  $languages->filter(function ($language) use ($locale) {
                return $language->code === $locale;
            });
        }

        return $languages;
    }
}



if (!function_exists('translate_value')) {
    function translate_value($langCode, $langKey)
    {
        $translate = Translation::where(['lang' => $langCode, 'lang_key' => $langKey])->latest()->first();
        return $translate ? $translate->lang_value : null;
    }
}

if (! function_exists('system_path')) {
    function system_path($name, $path = '/')
    {
        return base_path() . '/Modules/' . $name . ($path != '/' ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


if (!function_exists('theme')) {
    function theme($path = '')
    {
        return 'theme::themes' . $path;
    }
}

if (!function_exists('active_theme')) {
    function active_theme($path = '')
    {
        $active_theme = null;

        if (! session()->has('active_theme')) {
            $active_theme = Theme::whereActive(1)->first();
            session()->put('active_theme', $active_theme);
        }

        $active_theme = session()->get('active_theme');

        // if (! $active_theme && checkDatabaseConnection() && Schema::hasTable('themes')) {
        //     $active_theme = Theme::whereActive(1)->first();
        //     session()->put('active_theme', $active_theme);
        // }

        return  $active_theme;
    }
}

if (!function_exists('theme_dir')) {
    function theme_dir($path = '')
    {
        $sourcePath = system_path('resources/themes/' . active_theme_slug());
        return $sourcePath . $path;
    }
}

if (! function_exists('active_theme_slug')) {
    function active_theme_slug()
    {
        $theme = active_theme();
        return $theme->slug ?? 'default';
    }
}

if (! function_exists('theme_name')) {
    function theme_name()
    {
        if (Schema::hasTable('themes')) {
            $theme = Theme::whereActive(1)->first(['slug']);
            return $theme->slug ?? 'default';
        }

        return 'default';
    }
}

if (! function_exists('theme_type')) {
    function theme_type()
    {
        if (Schema::hasTable('themes')) {
            $theme = Theme::whereActive(1)->first(['type']);
            return $theme->type ?? 'general';
        }

        return 'default';
    }
}

if (!function_exists('getTimezone')) {
    function getTimezone()
    {
        $timezones = DateTimeZone::listIdentifiers();
        $formattedTimezones = array_map(function ($timezone) {
            $dateTime = new DateTime('now', new DateTimeZone($timezone));
            $offset = $dateTime->getOffset();
            $hours = intdiv($offset, 3600);
            $minutes = abs($offset % 3600 / 60);
            $formattedOffset = sprintf('(GMT%+d:%02d)', $hours, $minutes);
            return [
                'value' => $timezone,
                'label' => $formattedOffset . ' ' . $timezone,
            ];
        }, $timezones);

        return $formattedTimezones;
    }
}

if (!function_exists('asset_version')) {
    function asset_version($path, $driver = 'local')
    {
        switch ($driver) {
            case 'local':
                $path = public_path($path);
                break;
            default:
                $path = public_path($path);
                break;
        }


        if (file_exists($path)) {
            return filemtime($path);
        }

        return app_version();
    }
}

if (!function_exists('theme_asset')) {
    function theme_asset($path, $secure = null)
    {
        return route('theme.asset') . '?path=' . urlencode($path);
    }
}

if (!function_exists('get_themes')) {
    function get_themes()
    {
        if (checkDatabaseConnection() && Schema::hasTable('themes')) {
            return Theme::all();
        }

        return [];
    }
}

if (!function_exists('get_menus')) {
    function get_menus()
    {

        $menus = [];
        $generalOption =  get_theme_option(key: 'general') ?? [];
        $isMultipleEnable =  $generalOption['is_multiple_theme'] ?? '';
        if ($isMultipleEnable == 'on') {
            $themes = get_themes();
            $menus['theme'] = [
                'name' => translate('Theme'),
                'url' => route('home.index'),
                'is_active' => is_active('theme.index'),
                'childs' => [],
            ];
            $active_theme_slug = active_theme_slug();

            foreach ($themes as  $theme) {
                $menus['theme']['childs'][] = [
                    'name' => translate($theme->name),
                    'url' => route('theme.activation_by_uuid', ['slug' => $theme->slug, 'uuid' => $theme->uuid]),
                    'is_active' => $active_theme_slug === $theme->slug ? 'active' : ''
                ];
            }
        }

        $menus = array_merge($menus, [
            'home' => [
                'name' => translate('Home'),
                'url' => route('home.index'),
                'is_active' => is_active('home.index'),
                'childs' => [],
            ],
            'course_list' => [
                'name' => translate('Course'),
                'url' => route('course.list'),
                'is_active' => is_active('course.list')
            ],
            'course_bundle' => [
                'name' => translate('Pages'),
                'url' => '#',
                'is_active' => is_active('course.bundle') || is_active('instructor.list') || is_active('organization.list'),
                'childs' => [
                    [
                        'name' => translate('Course Bundle'),
                        'url' => route('bundle.list'),
                        'is_active' => is_active('bundle.list'),
                    ],
                    [
                        'name' => translate('Instructor'),
                        'url' => route('instructor.list'),
                        'is_active' => is_active('instructor.list'),
                    ],
                    [
                        'name' => translate('Organization'),
                        'url' => route('organization.list'),
                        'is_active' => is_active('organization.list'),

                    ],
                    [
                        'name' => translate('Blogs'),
                        'url' => route('blog.list'),
                        'is_active' => is_active('blog.list'),

                    ],
                    [
                        'name' => translate('About Us'),
                        'url' => route('about.us'),
                        'is_active' => is_active('about.us'),

                    ],
                    [
                        'name' => translate('Privacy & Policy'),
                        'url' => route('privacy.policy'),
                        'is_active' => is_active('privacy.policy'),

                    ],
                    [
                        'name' => translate('Terms & Condition'),
                        'url' => route('terms.condition'),
                        'is_active' => is_active('terms.condition'),

                    ],
                ]
            ],
            'contact' => [
                'name' => translate('Contact'),
                'url' => route('contact.page'),
                'is_active' => is_active('contact.page'),
            ],
        ]);

        return $menus;
    }
}


if (!function_exists('assets')) {
    /**
     * Load assests.
     *
     * @param string $path
     *
     * @return \Illuminate\Http\Response
     */
    function assets($path)
    {
        $file = base_path(trim(config('lms.resources_path'), '/') . '/' . urldecode($path));
        if (File::exists($file)) {
            switch ($extension = pathinfo($file, PATHINFO_EXTENSION)) {
                case 'js':
                    $mimeType = 'text/javascript';
                    break;
                case 'css':
                    $mimeType = 'text/css';
                    break;
                default:
                    $mimeType = File::mimeType($file);
                    break;
            }
            // return $mimeType;
            $response = Response::make(File::get($file), 200);

            $response->header('Content-Type', $mimeType);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return  $response;
        }

        return response('', 404);
    }
}

if (!function_exists('get_heroes')) {
    function get_heroes()
    {
        return Hero::get();
    }
}

if (! function_exists('get_theme_hero')) {
    function get_theme_hero($slug)
    {
        $locale = app()->getLocale();
        $default = app('default_language');

        $theme = Theme::with(['hero.sliders', 'hero.sliders.translations' => function ($query) use ($locale, $default) {
            $query->where('locale', $locale);
        }])->where('slug', $slug)->first();
        return $theme?->hero && $theme?->hero?->status === 1 ? $theme->hero :  null;
    }
}


if (!function_exists('checkDatabaseConnection')) {
    /**
     * Check Database Connection
     *
     * @return bool|string
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
if (!function_exists('key_snake_case')) {

    function key_snake_case(string  $name): string
    {
        return Str::snake(str_replace('-', ' ', $name));
    }
}



/**
 * indexFile
 * @return Response
 */

if (!function_exists('indexFile')) {
    function indexFile()
    {
        if (File::exists(public_path('index.php'))) {
            return true;
        };
        return false;
    }
}


if (!function_exists('get_payment_method')) {
    function get_payment_method()
    {
        $paymentMethod = PaymentMethod::query();

        return $paymentMethod->where('status', 1)->get();
    }
}

if (!function_exists('is_active_menu')) {
    function is_active_menu(...$names)
    {

        if (empty($names)) {
            return false;
        }

        $type = 'route';

        if (in_array($names[0], ['route'])) {
            $type = $names[0];
            unset($names[0]);
        }

        $isExists = false;

        switch ($type) {
            case 'route':
                foreach ($names as $value) {
                    if (is_string($value)) {
                        $value = array($value);
                    }
                    foreach ($value as $name) {
                        if (request()->routeIs($name)) {
                            $isExists = true;
                            break;
                        }
                    }
                }
                break;
        }

        return $isExists;
    }
}

if (!function_exists('get_active_filter_tab')) {
    function get_active_filter_tab()
    {
        if (!request()->has('filter') || request()->filter === '' || request()->filter === 'published') {
            return 'published';
        }
        return request()->filter;
    }
}

if (! function_exists('edulab_asset')) {
    function edulab_asset($path)
    {
        $file = pathinfo($path);
        $dir = $file['dirname'];
        $filename = $file['filename'];
        $extension = $file['extension'];

        if (App::environment('production')) {
            $filename .= '.min';
        }

        $assetPath = "{$dir}/{$filename}.{$extension}";

        if (! file_exists(public_path($assetPath))) {
            $assetPath = $path;
        }

        $assetUrl = asset($assetPath) . '?v=' . asset_version($assetPath);

        return $assetUrl;
    }
}

if (! function_exists('active_language')) {
    function active_language()
    {
        return app()->getLocale();
    }
}


if (!function_exists('active_rtl')) {

    function active_rtl()
    {
        $activeLang = Language::where('code', app()->getLocale())->select('rtl')->first();
        return $activeLang?->rtl ? 'rtl' : 'ltr';
    }
}

if (!function_exists('user_wishlist_check')) {
    function user_wishlist_check($courseId)
    {
        $user = authCheck();
        $wishlistArray = $user->wishlists->pluck('id')->toArray();
        if (in_array($courseId,  $wishlistArray)) {
            return  true;
        }
        return false;
    }
}

if (!function_exists('ai_service_type')) {
    function ai_service_type()
    {
        return ServiceType::all();
    }
}

if (!function_exists('get_currency_list')) {
    function get_currency_list()
    {
        // Check if Intl extension is available
        if (class_exists('ResourceBundle') && class_exists('NumberFormatter') && class_exists('Locale')) {
            try {
                $currencies = [];
                $locales = ResourceBundle::getLocales('');
                foreach ($locales as $locale) {
                    $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
                    $currencyCode = $formatter->getTextAttribute(NumberFormatter::CURRENCY_CODE);
                    $currencySymbol = $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
                    $country = Locale::getDisplayRegion('-' . strtoupper($locale), 'en');

                    $currencyName = Locale::getDisplayName($currencyCode, 'en');

                    if ($currencyCode && !isset($currencies[$currencyCode])) {
                        $currencies[$currencyCode] = [
                            'country' => $country ?: 'Unknown',
                            'code' => $currencyCode,
                            'name' => $currencyName ?: 'Unknown Currency',
                            'symbol' => $currencySymbol,
                        ];
                    }
                }
                ksort($currencies);
                return $currencies;
            } catch (Exception $e) {
                // Fall back to static list if Intl extension fails
            }
        }
        
        // Fallback: Static currency list for common currencies
        return [
            'USD' => ['country' => 'United States', 'code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
            'EUR' => ['country' => 'European Union', 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            'GBP' => ['country' => 'United Kingdom', 'code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'],
            'JPY' => ['country' => 'Japan', 'code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            'CAD' => ['country' => 'Canada', 'code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$'],
            'AUD' => ['country' => 'Australia', 'code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$'],
            'CHF' => ['country' => 'Switzerland', 'code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF'],
            'CNY' => ['country' => 'China', 'code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥'],
            'INR' => ['country' => 'India', 'code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹'],
            'KRW' => ['country' => 'South Korea', 'code' => 'KRW', 'name' => 'South Korean Won', 'symbol' => '₩'],
            'SGD' => ['country' => 'Singapore', 'code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => 'S$'],
            'HKD' => ['country' => 'Hong Kong', 'code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => 'HK$'],
            'NOK' => ['country' => 'Norway', 'code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr'],
            'SEK' => ['country' => 'Sweden', 'code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr'],
            'DKK' => ['country' => 'Denmark', 'code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr'],
            'PLN' => ['country' => 'Poland', 'code' => 'PLN', 'name' => 'Polish Zloty', 'symbol' => 'zł'],
            'CZK' => ['country' => 'Czech Republic', 'code' => 'CZK', 'name' => 'Czech Koruna', 'symbol' => 'Kč'],
            'HUF' => ['country' => 'Hungary', 'code' => 'HUF', 'name' => 'Hungarian Forint', 'symbol' => 'Ft'],
            'RUB' => ['country' => 'Russia', 'code' => 'RUB', 'name' => 'Russian Ruble', 'symbol' => '₽'],
            'BRL' => ['country' => 'Brazil', 'code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$'],
            'MXN' => ['country' => 'Mexico', 'code' => 'MXN', 'name' => 'Mexican Peso', 'symbol' => '$'],
            'ARS' => ['country' => 'Argentina', 'code' => 'ARS', 'name' => 'Argentine Peso', 'symbol' => '$'],
            'CLP' => ['country' => 'Chile', 'code' => 'CLP', 'name' => 'Chilean Peso', 'symbol' => '$'],
            'COP' => ['country' => 'Colombia', 'code' => 'COP', 'name' => 'Colombian Peso', 'symbol' => '$'],
            'PEN' => ['country' => 'Peru', 'code' => 'PEN', 'name' => 'Peruvian Sol', 'symbol' => 'S/'],
            'ZAR' => ['country' => 'South Africa', 'code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R'],
            'EGP' => ['country' => 'Egypt', 'code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => '£'],
            'NGN' => ['country' => 'Nigeria', 'code' => 'NGN', 'name' => 'Nigerian Naira', 'symbol' => '₦'],
            'KES' => ['country' => 'Kenya', 'code' => 'KES', 'name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
            'GHS' => ['country' => 'Ghana', 'code' => 'GHS', 'name' => 'Ghanaian Cedi', 'symbol' => '₵'],
            'TRY' => ['country' => 'Turkey', 'code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => '₺'],
            'SAR' => ['country' => 'Saudi Arabia', 'code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => '﷼'],
            'AED' => ['country' => 'UAE', 'code' => 'AED', 'name' => 'UAE Dirham', 'symbol' => 'د.إ'],
            'QAR' => ['country' => 'Qatar', 'code' => 'QAR', 'name' => 'Qatari Riyal', 'symbol' => '﷼'],
            'KWD' => ['country' => 'Kuwait', 'code' => 'KWD', 'name' => 'Kuwaiti Dinar', 'symbol' => 'د.ك'],
            'BHD' => ['country' => 'Bahrain', 'code' => 'BHD', 'name' => 'Bahraini Dinar', 'symbol' => '.د.ب'],
            'OMR' => ['country' => 'Oman', 'code' => 'OMR', 'name' => 'Omani Rial', 'symbol' => '﷼'],
            'JOD' => ['country' => 'Jordan', 'code' => 'JOD', 'name' => 'Jordanian Dinar', 'symbol' => 'د.ا'],
            'LBP' => ['country' => 'Lebanon', 'code' => 'LBP', 'name' => 'Lebanese Pound', 'symbol' => '£'],
            'ILS' => ['country' => 'Israel', 'code' => 'ILS', 'name' => 'Israeli Shekel', 'symbol' => '₪'],
            'THB' => ['country' => 'Thailand', 'code' => 'THB', 'name' => 'Thai Baht', 'symbol' => '฿'],
            'MYR' => ['country' => 'Malaysia', 'code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM'],
            'IDR' => ['country' => 'Indonesia', 'code' => 'IDR', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp'],
            'PHP' => ['country' => 'Philippines', 'code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => '₱'],
            'VND' => ['country' => 'Vietnam', 'code' => 'VND', 'name' => 'Vietnamese Dong', 'symbol' => '₫'],
            'PKR' => ['country' => 'Pakistan', 'code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => '₨'],
            'BDT' => ['country' => 'Bangladesh', 'code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            'LKR' => ['country' => 'Sri Lanka', 'code' => 'LKR', 'name' => 'Sri Lankan Rupee', 'symbol' => '₨'],
            'NPR' => ['country' => 'Nepal', 'code' => 'NPR', 'name' => 'Nepalese Rupee', 'symbol' => '₨'],
            'AFN' => ['country' => 'Afghanistan', 'code' => 'AFN', 'name' => 'Afghan Afghani', 'symbol' => '؋'],
            'MMK' => ['country' => 'Myanmar', 'code' => 'MMK', 'name' => 'Myanmar Kyat', 'symbol' => 'K'],
            'KHR' => ['country' => 'Cambodia', 'code' => 'KHR', 'name' => 'Cambodian Riel', 'symbol' => '៛'],
            'LAK' => ['country' => 'Laos', 'code' => 'LAK', 'name' => 'Lao Kip', 'symbol' => '₭'],
            'MNT' => ['country' => 'Mongolia', 'code' => 'MNT', 'name' => 'Mongolian Tugrik', 'symbol' => '₮'],
            'KZT' => ['country' => 'Kazakhstan', 'code' => 'KZT', 'name' => 'Kazakhstani Tenge', 'symbol' => '₸'],
            'UZS' => ['country' => 'Uzbekistan', 'code' => 'UZS', 'name' => 'Uzbekistani Som', 'symbol' => 'лв'],
            'KGS' => ['country' => 'Kyrgyzstan', 'code' => 'KGS', 'name' => 'Kyrgyzstani Som', 'symbol' => 'лв'],
            'TJS' => ['country' => 'Tajikistan', 'code' => 'TJS', 'name' => 'Tajikistani Somoni', 'symbol' => 'SM'],
            'TMT' => ['country' => 'Turkmenistan', 'code' => 'TMT', 'name' => 'Turkmenistani Manat', 'symbol' => 'T'],
            'AZN' => ['country' => 'Azerbaijan', 'code' => 'AZN', 'name' => 'Azerbaijani Manat', 'symbol' => '₼'],
            'GEL' => ['country' => 'Georgia', 'code' => 'GEL', 'name' => 'Georgian Lari', 'symbol' => '₾'],
            'AMD' => ['country' => 'Armenia', 'code' => 'AMD', 'name' => 'Armenian Dram', 'symbol' => '֏'],
            'BYN' => ['country' => 'Belarus', 'code' => 'BYN', 'name' => 'Belarusian Ruble', 'symbol' => 'Br'],
            'UAH' => ['country' => 'Ukraine', 'code' => 'UAH', 'name' => 'Ukrainian Hryvnia', 'symbol' => '₴'],
            'MDL' => ['country' => 'Moldova', 'code' => 'MDL', 'name' => 'Moldovan Leu', 'symbol' => 'L'],
            'RON' => ['country' => 'Romania', 'code' => 'RON', 'name' => 'Romanian Leu', 'symbol' => 'lei'],
            'BGN' => ['country' => 'Bulgaria', 'code' => 'BGN', 'name' => 'Bulgarian Lev', 'symbol' => 'лв'],
            'HRK' => ['country' => 'Croatia', 'code' => 'HRK', 'name' => 'Croatian Kuna', 'symbol' => 'kn'],
            'RSD' => ['country' => 'Serbia', 'code' => 'RSD', 'name' => 'Serbian Dinar', 'symbol' => 'Дин.'],
            'BAM' => ['country' => 'Bosnia and Herzegovina', 'code' => 'BAM', 'name' => 'Bosnia-Herzegovina Convertible Mark', 'symbol' => 'KM'],
            'MKD' => ['country' => 'North Macedonia', 'code' => 'MKD', 'name' => 'Macedonian Denar', 'symbol' => 'ден'],
            'ALL' => ['country' => 'Albania', 'code' => 'ALL', 'name' => 'Albanian Lek', 'symbol' => 'L'],
            'EUR' => ['country' => 'Montenegro', 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            'SOS' => ['country' => 'Somalia', 'code' => 'SOS', 'name' => 'Somali Shilling', 'symbol' => 'S'],
        ];
    }
}

if (!function_exists('all_currency')) {
    function all_currency()
    {
        return Currency::all();
    }
}

if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol($currency)
    {
        $parts = explode("-", $currency);
        $symbol = $parts[1];
        return $symbol;
    }
}

if (!function_exists('get_diff_timestamp_day')) {
    function get_diff_timestamp_day($firstTime, $lastTime)
    {
        $date1 = $firstTime;
        return $date1->diffInDays($lastTime);
    }
}

if (!function_exists('check_method_name')) {
    function check_method_name($class, $method)
    {
        return method_exists($class,   $method);
    }
}



if (!function_exists('module_enable_check')) {

    function module_enable_check($name)
    {
        if (Module::has($name) && Module::isEnabled($name)) {
            return true;
        }
         return false;
    }
}

if(!function_exists('is_subscription_feature_enabled')) {
    function is_subscription_feature_enabled()
    {
        return Module::all();
    }
}
