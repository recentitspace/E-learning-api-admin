<?php

namespace Modules\LMS\Models;

use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Courses\Course;
use Spatie\Permission\Traits\HasRoles;
use Modules\LMS\Models\Auth\UserSocial;
use Illuminate\Notifications\Notifiable;
use Modules\LMS\Models\Auth\UserCourseExam;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\Localization\Localization;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes, HasApiTokens;

    public $guard_name = 'web';

    protected $fillable = ['id', 'userable_type', 'userable_id', 'guard',  'username', 'email', 'password', 'organization_id', 'is_verify', 'remember_me'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the model that the image belongs to.
     */
    public function userable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_instructors', 'instructor_id', 'course_id')->withTimestamps();
    }

    public function organizations(): BelongsToMany
    {
        return $this->BelongsToMany(self::class, 'instructor_organizations', 'instructor_id', 'organization_id')->withTimestamps();
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(PurchaseDetails::class)->where('type', PurchaseType::ENROLLED);
    }

    public function educations(): BelongsToMany
    {
        return $this->belongsToMany(University::class, 'user_education', 'user_id', 'university_id')->withTimestamps()->withPivot('id', 'department', 'degree', 'cgpa', 'duration', 'passing_year');
    }

    public function experiences(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'user_experiences', 'user_id', 'company_id', 'id', 'id')->withTimestamps()->withPivot('id', 'designation', 'start_date', 'end_date', 'is_present');
    }

    public function organizationCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'organization_id', 'id');
    }

    public function organizationInstructors(): HasMany
    {
        return $this->hasMany(self::class, 'organization_id', 'id');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skills', 'user_id', 'skill_id')->withTimestamps();
    }

    public function userBundles(): HasMany
    {
        return $this->hasMany(CourseBundle::class);
    }

    // public function
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function socials(): HasMany
    {
        return $this->hasMany(UserSocial::class);
    }

    public function localization(): HasOne
    {
        return $this->hasOne(Localization::class);
    }



    public function userExams(): HasMany
    {
        return $this->hasMany(UserCourseExam::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            if ($user->isForceDeleting()) {
                // Soft delete related states and cities
                $user->userExams()->each(function ($userExam) {
                    if (static::isSoftDeleteEnable($userExam)) {
                        $userExam->forceDelete();
                    }
                });

                $user->userable()->forceDelete();
            }
        });

        // Handle restoring related states and cities
        static::restored(function ($user) {
            // Restore related states
            $user->userExams()->withTrashed()->each(function ($userExam) {
                if (static::isSoftDeleteEnable($userExam)) {
                    $userExam->withTrashed()->restore();
                }
            });

            $user->userable()->restore();
        });
    }

    public static function isSoftDeleteEnable($class)
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($class));
    }

    public function wishlists(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'wishlists', 'user_id', 'course_id', 'id', 'id')->withTimestamps();
    }
}
