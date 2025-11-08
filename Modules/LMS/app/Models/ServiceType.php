<?php

namespace Modules\LMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\LMS\Database\Factories\ServiceTypeFactory;

class ServiceType extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
}
