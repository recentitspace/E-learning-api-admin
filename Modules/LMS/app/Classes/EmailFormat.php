<?php

namespace Modules\LMS\Classes;

use Modules\LMS\Enums\CourseStatus;
use Illuminate\Support\Facades\Mail;
use Modules\LMS\Emails\SendNotification;
use Modules\LMS\Enums\EmailFormatStatus;
use Modules\LMS\Models\General\EmailTemplate;

class EmailFormat
{
    protected static $model = EmailTemplate::class;
    private static $instance;
    public static function registrationMail($data)
    {
        try {
            $emailContent = static::$model::where('template_name', EmailFormatStatus::USER_REGISTERED)->first();
            $email_content = str_replace(['[user_name]', '[role_name]', '[app_name]'], [$data['user_name'], $data['role'], $data['app_name']], $emailContent->description);
            $confirmMailLink = "<a href='" . url('verify-mail/' . $data['id'] . '/' . str_replace('/', '-', $data['token'])) . "'>Confirm Your Account</a>";
            $email_content = str_replace('[link]', $confirmMailLink, $email_content);
            $details = [
                'email' => $data['email'],
                'subject' => $emailContent->subject,
                'body' => $email_content,
            ];
            self::sendMail($details);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     *  statusCourse
     *
     * @param  array  $data
     * @return void
     */
    public static function statusCourse($data)
    {
        try {
            $emailContent = '';
            if ($data['course_status'] == CourseStatus::APPROVED) {
                $emailContent = static::$model::where('template_name', EmailFormatStatus::COURSE_APPROVED)->first();
            } elseif ($data['course_status'] == CourseStatus::REJECTED) {
                $emailContent = static::$model::where('template_name', EmailFormatStatus::COURSE_REJECTED)->first();
            }
            $email_content = str_replace(['[instructor_name]', '[course_title]', '[app_name]'], [$data['user_name'], $data['course_title'], $data['app_name']], $emailContent->description);
            $details = [
                'email' => $data['email'],
                'subject' => $emailContent->subject,
                'body' => $email_content,
            ];
            self::sendMail($details);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * accountStatusChange
     *
     * @param  array  $data
     * @return void
     */
    public static function accountStatusChange($data)
    {
        try {
            $emailContent = '';
            if ($data['status'] == 'activated') {
                $emailContent = static::$model::where('template_name', EmailFormatStatus::ACTIVATED)->first();
            } elseif ($data['status'] == 'deactivated') {
                $emailContent = static::$model::where('template_name', EmailFormatStatus::DEACTIVATED)->first();
            }
            $email_content = str_replace(['[user_name]', '[app_name]'], [$data['user_name'], $data['app_name']], $emailContent->description);
            $details = [
                'email' => $data['email'],
                'subject' => $emailContent->subject,
                'body' => $email_content,
            ];
            self::sendMail($details);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public static function forgotPassword($data)
    {
        try {

            $resetRoute =  route('password.reset',  str_replace('/', '-', $data['token']));
            $emailContent = static::$model::where('template_name', EmailFormatStatus::FORGOT_PASSWORD)->first();
            $email_content = str_replace(['[user_name]', '[app_name]'], [$data['user_name'], $data['app_name']], $emailContent->description);
            $resetLink = "<a href='" . $resetRoute . "'>Password Reset Button</a>";
            $email_content = str_replace('[password_reset_link]', $resetLink, $email_content);
            $details = [
                'email' => $data['email'],
                'subject' => $emailContent->subject,
                'body' => $email_content,
            ];
            self::sendMail($details);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     *  sendMail
     */
    public static function sendMail(array $details)
    {
        Mail::to($details['email'])->queue(new SendNotification($details));
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new EmailFormat;
        }
        return self::$instance;
    }
}
