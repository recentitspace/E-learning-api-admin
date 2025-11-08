<?php

namespace Modules\LMS\Models\Forum;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\LMS\Models\User;

class Forum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id'];

    public function subForums(): HasMany
    {
        return $this->hasMany(SubForum::class);
    }

    public function forumPosts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    public function forumMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'forum_posts', 'author_id', 'id')->distinct();
    }
}
