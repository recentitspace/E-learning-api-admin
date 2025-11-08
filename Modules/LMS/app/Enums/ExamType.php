<?php

namespace Modules\LMS\Enums;

enum ExamType: string
{
    case QUIZ = 'quiz';
    case ASSIGNMENT = 'assignment';
    case SUPPLEMENT = 'supplement';
}
