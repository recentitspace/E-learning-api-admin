<?php

namespace Modules\LMS\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\LMS\Models\Certificate\Certificate;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            [
                'title' =>  'Frontend Development',
                'certificate_content' => '<div class="certificate-template-container" id="certificateImg" style="background: url("http://127.0.0.1:8000/lms/assets/images/certificate-template.jpg"); background-repeat:no-repeat; background-size: 100% 100% ">
                            <div data-name="student" class="dragable-element ui-draggable ui-draggable-handle" style="left: 294px; top: 486px;">{student_name}</div>
                            <div data-name="platform-name" class="dragable-element ui-draggable ui-draggable-handle" style="left: -138px; top: 656px;">{platform_name}</div>
                            <div data-name="course-completed-date" class="dragable-element ui-draggable ui-draggable-handle" style="left: 51px; top: 330px;">{course_title}</div>
                            <div data-name="course-completed-date" class="dragable-element ui-draggable ui-draggable-handle" style="left: -108px; top: 287px;">
                                {course_completed_date} </div>
                            <div data-name="course-completed-date" class="dragable-element ui-draggable ui-draggable-handle" style="left: 19px; top: 652px;">{instructor_name}
                            </div>
                        </div>',
                'input_content' => '{"bg":null,"title":{"color":"#000000","font_size":"18"}}',
                'type'  =>  'course',

            ],
        ];

        if (Certificate::count() == 0) {
            Certificate::insert($data);
        }
    }
}
