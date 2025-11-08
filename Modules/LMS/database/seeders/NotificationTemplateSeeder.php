<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\General\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $notifications = [
            [
                'title' => 'Complete your purchase today with discount!',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, "Segoe UI", arial; font-size: 14px;">Here' . 's an exclusive [discount_amount] discount coupon to encourage you to finalize your purchase with us. Discount Code : [discount_code]</span><br></p>',
                'template_name' => 'discount_purchase',
            ],

            [
                'title' => 'New user registered',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, " segoe="" ui",="" arial;="" font-size:="" 14px;"="">[user_name] registered on the platform on [time_date]&nbsp;as [user_role].</span><br></p>',
                'template_name' => 'new_register',
            ],

            [
                'title' => 'Course approve',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, &quot;Segoe UI&quot;, arial; font-size: 14px;">Your course with the title [course_title] is approved.</span><br></p>',
                'template_name' => 'course_approve',
            ],
            [
                'title' => 'Course rejection',
                'description' => '<span style="color: rgb(108, 117, 125); font-family: Nunito, &quot;Segoe UI&quot;, arial; font-size: 14px;">Your course with the title [course_title] was rejected.</span><br>',
                'template_name' => 'course_rejected',
            ],
            [
                'title' => 'New organization user',
                'description' => '<p><span style="color: rgb(108, 117, 125); font-family: Nunito, &quot;Segoe UI&quot;, arial; font-size: 14px;">[organization_name] submitted [user_.name]&nbsp;as new [user_role]</span><br></p>',
                'template_name' => 'new_organization',
            ],
            [
                'title' => 'Course Approved',
                'description' => '<p><br></p><p><br></p><p>[course_title] this course is [course_status].&nbsp;</p>',
                'template_name' => 'course_approved',
            ],
            [
                'title' => 'Account Status [_status_]',
                'description' => '<p>Your account is [_status_].</p>',
                'template_name' => 'account_status',
            ]

        ];

        foreach ($notifications as $notification) {
            NotificationTemplate::updateOrCreate(['template_name' =>  $notification['template_name']], $notification);
        }
    }
}
