<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\General\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emilTemplates = [
            [
                'subject' => 'Password Reset',
                'template_name' => 'password_reset',
                'description' => '<p>Hello [name]</p>',
            ],
            [
                'subject' => 'Registered successfully',
                'template_name' => 'user_registered',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Hello, [user_name]</span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Thank you for registering our learning management system as a [role_name]. and verify your account. click on the below [link]</span><br></p><p><span style="font-weight: bolder; color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Thanks</span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"> [app_name].</span><span style="font-weight: bolder; color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span><br></p>',
            ],
            [
                'subject' => 'Email verification',
                'template_name' => 'email_verification',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">You have received an email verification code. Your code is [email_link]</span><br></p>',
            ],
            [
                'subject' => 'Forgot password',
                'template_name' => 'forgot_password',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Hello, [user_name].</span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px; background-color: rgb(255 255 255 / var(--tw-bg-opacity));">You Verification link [verification_link][minutes]</span><br></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Thanks</span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">&nbsp;[app_name].</span></p><p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;"><br></span></p><p><br></p><p><br></p>',
            ],
            [
                'subject' => 'Noticeboard',
                'template_name' => 'noticeboard_student',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, sans-serif; font-size: 14px;">Hi, You have a new notice by [instructor_name]. The course [course_title] [notice_title][notice_description].</span></p><p><br></p><p><br></p>',
            ],
            [
                'subject' => 'Course Approved Successfully.',
                'template_name' => 'course_approved',
                'description' => '<p>Hello, [instructor_name]</p><p><br></p><p><br></p><p>&nbsp;<span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity));">&nbsp;Your course name :</span><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity)); --tw-border-spacing-x: 0; --tw-border-spacing-y: 0; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-pan-x: ; --tw-pan-y: ; --tw-pinch-zoom: ; --tw-scroll-snap-strictness: proximity; --tw-gradient-from-position: ; --tw-gradient-via-position: ; --tw-gradient-to-position: ; --tw-ordinal: ; --tw-slashed-zero: ; --tw-numeric-figure: ; --tw-numeric-spacing: ; --tw-numeric-fraction: ; --tw-ring-inset: ; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgb(59 130 246 / 0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --tw-blur: ; --tw-brightness: ; --tw-contrast: ; --tw-grayscale: ; --tw-hue-rotate: ; --tw-invert: ; --tw-saturate: ; --tw-sepia: ; --tw-drop-shadow: ; --tw-backdrop-blur: ; --tw-backdrop-brightness: ; --tw-backdrop-contrast: ; --tw-backdrop-grayscale: ; --tw-backdrop-hue-rotate: ; --tw-backdrop-invert: ; --tw-backdrop-opacity: ; --tw-backdrop-saturate: ; --tw-backdrop-sepia: ; --tw-contain-size: ; --tw-contain-layout: ; --tw-contain-paint: ; --tw-contain-style: ;">&nbsp;</span><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity));"><b>&nbsp;[course_title]</b>&nbsp; is approved.</span></p><p><br></p><p><br></p><p>Thanks&nbsp;</p><p><br></p><p>[app_name]</p><p><br></p><p><br></p>',
            ],
            [
                'subject' => 'Course Rejected.',
                'template_name' => 'course_rejected',
                'description' => '<p>Hello, [instructor_name],</p><p><br></p><p><br></p><p>&nbsp;[course_title]&nbsp; This is course rejected. please try again.</p><p><br></p><p><br></p><p>Thanks</p><p><br></p><p>[app_name]</p>',
            ],
            [
                'subject' => 'Your account is active.',
                'template_name' => 'account_activated',
                'description' => '<p>Hello, [user_name],</p><p><br></p><p><br></p><p>Your account has been approved.</p><p><br></p><p><br></p><p>Thank</p><p>[app_name]</p>',
            ],
            [
                'subject' => 'Your account is Deactived.',
                'template_name' => 'account_deactivated',
                'description' => '<p>Hello [user_name]</p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity));"><br></span></p><p><span style="background-color: rgb(255 255 255 / var(--tw-bg-opacity));">Im sorry for that your account is Deactived. Because you are breaking our rules.</span><br></p><p><br></p><p>Thanks </p><p>[app_name]</p>',
            ],
        ];

        foreach ($emilTemplates as $emilTemplate) {
            EmailTemplate::updateOrCreate(['template_name' => $emilTemplate['template_name']], $emilTemplate);
        }
    }
}
