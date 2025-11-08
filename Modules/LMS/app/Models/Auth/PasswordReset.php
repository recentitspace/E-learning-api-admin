<?php

namespace Modules\LMS\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LMS\Database\Factories\PasswordResetFactory;

class PasswordReset extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['email', 'token', 'created_at'];
}
