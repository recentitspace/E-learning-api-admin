<?php

namespace Modules\LMS\Enums;

enum UserType: string
{
    case INSTRUCTOR = 'instructor';
    case STUDENT = 'student';
    case ORGANIZATION = 'organization';
    case PARENT = 'parent';
}
