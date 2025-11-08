<?php

namespace Modules\LMS\Enums;

enum EmailFormatStatus
{
    const FORGOT_PASSWORD = 'forgot_password';

    const USER_REGISTERED = 'user_registered';

    const EMAIL_VERIFICATION = 'email_verification';

    const NOTICEBOARD_STUDENT = 'noticeboard_student';

    const COURSE_APPROVED = 'course_approved';

    const COURSE_REJECTED = 'course_rejected';

    const ACTIVATED = 'account_activated';

    const DEACTIVATED = 'account_deactivated';
}
