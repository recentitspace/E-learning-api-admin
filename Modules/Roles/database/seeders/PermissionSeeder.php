<?php

namespace Modules\Roles\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $this->call([]);

        $permissions = [
            [
                'name' => 'menu.theme',
                'guard_name' => 'admin',
                'module' => 'theme',
            ],
            [
                'name' => 'activate.theme',
                'guard_name' => 'admin',
                'module' => 'theme',
            ],
            [
                'name' => 'setting.theme',
                'guard_name' => 'admin',
                'module' => 'theme',
            ],

            [
                'name' => 'add.blog',
                'guard_name' => 'admin',
                'module' => 'blog',
            ],
            [
                'name' => 'edit.blog',
                'guard_name' => 'admin',
                'module' => 'blog',
            ],
            [
                'name' => 'delete.blog',
                'guard_name' => 'admin',
                'module' => 'blog',
            ],
            [
                'name' => 'status.blog',
                'guard_name' => 'admin',
                'module' => 'blog',
            ],
            [
                'name' => 'menu.blog.category',
                'guard_name' => 'admin',
                'module' => 'blog.category',
            ],
            [
                'name' => 'add.blog.category',
                'guard_name' => 'admin',
                'module' => 'blog.category',
            ],
            [
                'name' => 'edit.blog.category',
                'guard_name' => 'admin',
                'module' => 'blog.category',
            ],
            [
                'name' => 'delete.blog.category',
                'guard_name' => 'admin',
                'module' => 'blog.category',
            ],
            [
                'name' => 'menu.bundle',
                'guard_name' => 'admin',
                'module' => 'bundle',
            ],
            [
                'name' => 'add.bundle',
                'guard_name' => 'admin',
                'module' => 'bundle',
            ],
            [
                'name' => 'edit.bundle',
                'guard_name' => 'admin',
                'module' => 'bundle',
            ],
            [
                'name' => 'delete.bundle',
                'guard_name' => 'admin',
                'module' => 'bundle',
            ],
            [
                'name' => 'menu.category',
                'guard_name' => 'admin',
                'module' => 'category',
            ],
            [
                'name' => 'add.category',
                'guard_name' => 'admin',
                'module' => 'category',
            ],
            [
                'name' => 'edit.category',
                'guard_name' => 'admin',
                'module' => 'category',
            ],
            [
                'name' => 'delete.category',
                'guard_name' => 'admin',
                'module' => 'category',
            ],
            [
                'name' => 'menu.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'add.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'edit.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'delete.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'update.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'status.city',
                'guard_name' => 'admin',
                'module' => 'city',
            ],
            [
                'name' => 'menu.contact',
                'guard_name' => 'admin',
                'module' => 'contact',
            ],
            [
                'name' => 'reply.contact',
                'guard_name' => 'admin',
                'module' => 'contact',
            ],
            [
                'name' => 'delete.contact',
                'guard_name' => 'admin',
                'module' => 'contact',
            ],
            [
                'name' => 'menu.country',
                'guard_name' => 'admin',
                'module' => 'country',
            ],
            [
                'name' => 'add.country',
                'guard_name' => 'admin',
                'module' => 'country',
            ],
            [
                'name' => 'edit.country',
                'guard_name' => 'admin',
                'module' => 'country',
            ],
            [
                'name' => 'delete.country',
                'guard_name' => 'admin',
                'module' => 'country',
            ],
            [
                'name' => 'menu.coupon',
                'guard_name' => 'admin',
                'module' => 'coupon',
            ],
            [
                'name' => 'add.coupon',
                'guard_name' => 'admin',
                'module' => 'coupon',
            ],
            [
                'name' => 'edit.coupon',
                'guard_name' => 'admin',
                'module' => 'coupon',
            ],
            [
                'name' => 'delete.coupon',
                'guard_name' => 'admin',
                'module' => 'coupon',
            ],
            [
                'name' => 'status.coupon',
                'guard_name' => 'admin',
                'module' => 'coupon',
            ],

            [
                'name' => 'menu.course',
                'guard_name' => 'admin',
                'module' => 'course',
            ],
            [
                'name' => 'add.course',
                'guard_name' => 'admin',
                'module' => 'course',
            ],
            [
                'name' => 'edit.course',
                'guard_name' => 'admin',
                'module' => 'course',
            ],
            [
                'name' => 'delete.course',
                'guard_name' => 'admin',
                'module' => 'course',
            ],
            [
                'name' => 'status',
                'guard_name' => 'admin',
                'module' => 'course',
            ],

            [
                'name' => 'menu.course.manage',
                'guard_name' => 'admin',
                'module' => 'course.manage',
            ],
            [
                'name' => 'dashboard.menu',
                'guard_name' => 'admin',
                'module' => 'dashboard',
            ],
            [
                'name' => 'menu.emailtemplate',
                'guard_name' => 'admin',
                'module' => 'emailtemplate',
            ],
            [
                'name' => 'edit.emailtemplate',
                'guard_name' => 'admin',
                'module' => 'emailtemplate',
            ],
            [
                'name' => 'menu.icon',
                'guard_name' => 'admin',
                'module' => 'icon',
            ],
            [
                'name' => 'add.icon',
                'guard_name' => 'admin',
                'module' => 'icon',
            ],
            [
                'name' => 'edit.icon',
                'guard_name' => 'admin',
                'module' => 'icon',
            ],
            [
                'name' => 'delete.icon',
                'guard_name' => 'admin',
                'module' => 'icon',
            ],
            [
                'name' => 'status.icon',
                'guard_name' => 'admin',
                'module' => 'icon',
            ],
            [
                'name' => 'menu.icon.provider',
                'guard_name' => 'admin',
                'module' => 'icon.provider',
            ],

            [
                'name' => 'menu.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],
            [
                'name' => 'add.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],
            [
                'name' => 'edit.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],
            [
                'name' => 'delete.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],
            [
                'name' => 'status.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],
            [
                'name' => 'verify.instructor',
                'guard_name' => 'admin',
                'module' => 'instructor',
            ],

            [
                'name' => 'menu.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'add.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'edit.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'delete.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'status.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'menu.level',
                'guard_name' => 'admin',
                'module' => 'level',
            ],
            [
                'name' => 'add.level',
                'guard_name' => 'admin',
                'module' => 'level',
            ],
            [
                'name' => 'edit.level',
                'guard_name' => 'admin',
                'module' => 'level',
            ],
            [
                'name' => 'delete.level',
                'guard_name' => 'admin',
                'module' => 'level',
            ],
            [
                'name' => 'menu.localization',
                'guard_name' => 'admin',
                'module' => 'localization',
            ],
            [
                'name' => 'menu.marketing',
                'guard_name' => 'admin',
                'module' => 'marketing',
            ],
            [
                'name' => 'menu.meeting',
                'guard_name' => 'admin',
                'module' => 'meeting',
            ],

            [
                'name' => 'add.meeting',
                'guard_name' => 'admin',
                'module' => 'meeting',
            ],
            [
                'name' => 'edit.meeting',
                'guard_name' => 'admin',
                'module' => 'meeting',
            ],
            [
                'name' => 'delete.meeting',
                'guard_name' => 'admin',
                'module' => 'meeting',
            ],
            [
                'name' => 'menu.noticeboard',
                'guard_name' => 'admin',
                'module' => 'noticeboard',
            ],
            [
                'name' => 'add.noticeboard',
                'guard_name' => 'admin',
                'module' => 'noticeboard',
            ],
            [
                'name' => 'edit.noticeboard',
                'guard_name' => 'admin',
                'module' => 'noticeboard',
            ],
            [
                'name' => 'delete.noticeboard',
                'guard_name' => 'admin',
                'module' => 'noticeboard',
            ],

            [
                'name' => 'menu.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'add.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'edit.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'delete.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'status.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'verify.organization',
                'guard_name' => 'admin',
                'module' => 'organization',
            ],
            [
                'name' => 'menu.permission',
                'guard_name' => 'admin',
                'module' => 'permission',
            ],
            [
                'name' => 'add.permission',
                'guard_name' => 'admin',
                'module' => 'permission',
            ],
            [
                'name' => 'edit.permission',
                'guard_name' => 'admin',
                'module' => 'permission',
            ],
            [
                'name' => 'delete.permission',
                'guard_name' => 'admin',
                'module' => 'permission',
            ],
            [
                'name' => 'menu.provider',
                'guard_name' => 'admin',
                'module' => 'provider',
            ],
            [
                'name' => 'add.provider',
                'guard_name' => 'admin',
                'module' => 'provider',
            ],
            [
                'name' => 'edit.provider',
                'guard_name' => 'admin',
                'module' => 'provider',
            ],
            [
                'name' => 'delete.provider',
                'guard_name' => 'admin',
                'module' => 'provider',
            ],
            [
                'name' => 'status.provider',
                'guard_name' => 'admin',
                'module' => 'provider',
            ],
            [
                'name' => 'menu.role',
                'guard_name' => 'admin',
                'module' => 'role',
            ],
            [
                'name' => 'add.role',
                'guard_name' => 'admin',
                'module' => 'role',
            ],
            [
                'name' => 'edit.role',
                'guard_name' => 'admin',
                'module' => 'role',
            ],
            [
                'name' => 'delete.role',
                'guard_name' => 'admin',
                'module' => 'role',
            ],
            [
                'name' => 'menu.staff',
                'guard_name' => 'admin',
                'module' => 'staff',
            ],
            [
                'name' => 'add.staff',
                'guard_name' => 'admin',
                'module' => 'staff',
            ],
            [
                'name' => 'delete.staff',
                'guard_name' => 'admin',
                'module' => 'staff',
            ],
            [
                'name' => 'edit.staff',
                'guard_name' => 'admin',
                'module' => 'staff',
            ],
            [
                'name' => 'menu.state',
                'guard_name' => 'admin',
                'module' => 'state',
            ],
            [
                'name' => 'add.state',
                'guard_name' => 'admin',
                'module' => 'state',
            ],
            [
                'name' => 'edit.state',
                'guard_name' => 'admin',
                'module' => 'state',
            ],
            [
                'name' => 'menu.student',
                'guard_name' => 'admin',
                'module' => 'student',
            ],
            [
                'name' => 'add.student',
                'guard_name' => 'admin',
                'module' => 'student',
            ],
            [
                'name' => 'edit.student',
                'guard_name' => 'admin',
                'module' => 'student',
            ],
            [
                'name' => 'verify.student',
                'guard_name' => 'admin',
                'module' => 'student',
            ],
            [
                'name' => 'status.student',
                'guard_name' => 'admin',
                'module' => 'student',
            ],
            [
                'name' => 'menu.subject',
                'guard_name' => 'admin',
                'module' => 'subject',
            ],
            [
                'name' => 'add.subject',
                'guard_name' => 'admin',
                'module' => 'subject',
            ],
            [
                'name' => 'edit.subject',
                'guard_name' => 'admin',
                'module' => 'subject',
            ],
            [
                'name' => 'delete.subject',
                'guard_name' => 'admin',
                'module' => 'subject',
            ],
            [
                'name' => 'menu.tag',
                'guard_name' => 'admin',
                'module' => 'tag',
            ],
            [
                'name' => 'add.tag',
                'guard_name' => 'admin',
                'module' => 'tag',
            ],
            [
                'name' => 'edit.tag',
                'guard_name' => 'admin',
                'module' => 'tag',
            ],
            [
                'name' => 'delete.tag',
                'guard_name' => 'admin',
                'module' => 'tag',
            ],
            [
                'name' => 'menu.testimonial',
                'guard_name' => 'admin',
                'module' => 'testimonial',
            ],
            [
                'name' => 'add.testimonial',
                'guard_name' => 'admin',
                'module' => 'testimonial',
            ],
            [
                'name' => 'edit.testimonial',
                'guard_name' => 'admin',
                'module' => 'testimonial',
            ],
            [
                'name' => 'delete.testimonial',
                'guard_name' => 'admin',
                'module' => 'testimonial',
            ],
            [
                'name' => 'status.testimonial',
                'guard_name' => 'admin',
                'module' => 'testimonial',
            ],
            [
                'name' => 'menu.time.zone',
                'guard_name' => 'admin',
                'module' => 'time.zone',
            ],
            [
                'name' => 'add.time.zone',
                'guard_name' => 'admin',
                'module' => 'time.zone',
            ],
            [
                'name' => 'edit.time.zone',
                'guard_name' => 'admin',
                'module' => 'time.zone',
            ],

            [
                'name' => 'menu.notification',
                'guard_name' => 'admin',
                'module' => 'notification',
            ],
            [
                'name' => 'add.notification',
                'guard_name' => 'admin',
                'module' => 'notification',
            ],

            [
                'name' => 'menu.forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],
            [
                'name' => 'add.forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],
            [
                'name' => 'edit.forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],
            [
                'name' => 'status.forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],
            [
                'name' => 'delete.forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],

            [
                'name' => 'menu.category.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],
            [
                'name' => 'add.category.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],
            [
                'name' => 'edit.category.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],

            [
                'name' => 'delete.category.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],
            [
                'name' => 'status.category.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],

            [
                'name' => 'menu.ticket.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],

            [
                'name' => 'reply.ticket.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],
            [
                'name' => 'delete.ticket.support',
                'guard_name' => 'admin',
                'module' => 'support',
            ],
            [
                'name' => 'menu.enrollment',
                'guard_name' => 'admin',
                'module' => 'enrollment',
            ],
            [
                'name' => 'menu.sub-forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],

            [
                'name' => 'add.sub-forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],

            [
                'name' => 'edit.sub-forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],

            [
                'name' => 'status.sub-forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],
            [
                'name' => 'delete.sub-forum',
                'guard_name' => 'admin',
                'module' => 'forum',
            ],

            [
                'name' => 'menu.payment-method',
                'guard_name' => 'admin',
                'module' => 'payment-method',
            ],

            [
                'name' => 'add.payment-method',
                'guard_name' => 'admin',
                'module' => 'payment-method',
            ],
            [
                'name' => 'edit.payment-method',
                'guard_name' => 'admin',
                'module' => 'payment-method',
            ],
            [
                'name' => 'status.payment-method',
                'guard_name' => 'admin',
                'module' => 'payment-method',
            ],
            [
                'name' => 'delete.payment-method',
                'guard_name' => 'admin',
                'module' => 'payment-method',
            ],

            [
                'name' => 'menu.certificate',
                'guard_name' => 'admin',
                'module' => 'certificate',
            ],
            [
                'name' => 'add.certificate',
                'guard_name' => 'admin',
                'module' => 'certificate',
            ],

            [
                'name' => 'edit.certificate',
                'guard_name' => 'admin',
                'module' => 'certificate',
            ],
            [
                'name' => 'delete.certificate',
                'guard_name' => 'admin',
                'module' => 'certificate',
            ],

            [
                'name' => 'menu.faq',
                'guard_name' => 'admin',
                'module' => 'faq',
            ],

            [
                'name' => 'add.faq',
                'guard_name' => 'admin',
                'module' => 'faq',
            ],

            [
                'name' => 'edit.faq',
                'guard_name' => 'admin',
                'module' => 'faq',
            ],

            [
                'name' => 'delete.faq',
                'guard_name' => 'admin',
                'module' => 'faq',
            ],

            [
                'name' => 'menu.page',
                'guard_name' => 'admin',
                'module' => 'page',
            ],

            [
                'name' => 'edit.page',
                'guard_name' => 'admin',
                'module' => 'page',
            ],

            [
                'name' => 'menu.hero',
                'guard_name' => 'admin',
                'module' => 'hero',
            ],

            [
                'name' => 'add.hero',
                'guard_name' => 'admin',
                'module' => 'hero',
            ],

            [
                'name' => 'edit.hero',
                'guard_name' => 'admin',
                'module' => 'hero',
            ],


            [
                'name' => 'menu.slider',
                'guard_name' => 'admin',
                'module' => 'slider',
            ],

            [
                'name' => 'add.slider',
                'guard_name' => 'admin',
                'module' => 'slider',
            ],

            [
                'name' => 'edit.slider',
                'guard_name' => 'admin',
                'module' => 'slider',
            ],

            [
                'name' => 'delete.slider',
                'guard_name' => 'admin',
                'module' => 'slider',
            ],
            [
                'name' => 'edit.themesetting',
                'guard_name' => 'admin',
                'module' => 'themesetting',
            ],

            [
                'name' => 'menu.setting',
                'guard_name' => 'admin',
                'module' => 'setting',
            ],

            [
                'name' => 'menu.site-setting',
                'guard_name' => 'admin',
                'module' => 'setting',
            ],

            [
                'name' => 'menu.backend-setting',
                'guard_name' => 'admin',
                'module' => 'setting',
            ],


            [
                'name' => 'rtl.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'translate.language',
                'guard_name' => 'admin',
                'module' => 'language',
            ],
            [
                'name' => 'menu.license',
                'guard_name' => 'admin',
                'module' => 'license',
            ],
            [
                'name' => 'menu.custom-script',
                'guard_name' => 'admin',
                'module' => 'custom-script',
            ],

            [
                'name' => 'menu.financial',
                'guard_name' => 'admin',
                'module' => 'financial',
            ],
            [
                'name' => 'menu.sale',
                'guard_name' => 'admin',
                'module' => 'sale',
            ],

            [
                'name' => 'request.payout',
                'guard_name' => 'admin',
                'module' => 'payout',
            ],
            [
                'name' => 'approved-status.payout',
                'guard_name' => 'admin',
                'module' => 'payout',
            ],

            [
                'name' => 'menu.review',
                'guard_name' => 'admin',
                'module' => 'review',
            ],

            [
                'name' => 'update.review',
                'guard_name' => 'admin',
                'module' => 'review',
            ],
            [
                'name' => 'delete.review',
                'guard_name' => 'admin',
                'module' => 'review',
            ],
            [
                'name' => 'menu.currency',
                'guard_name' => 'admin',
                'module' => 'currency',
            ],
            [
                'name' => 'add.currency',
                'guard_name' => 'admin',
                'module' => 'currency',
            ],

            [
                'name' => 'edit.currency',
                'guard_name' => 'admin',
                'module' => 'currency',
            ],
            [
                'name' => 'delete.currency',
                'guard_name' => 'admin',
                'module' => 'currency',
            ],
            [
                'status' => 'status.currency',
                'guard_name' => 'admin',
                'module' => 'currency',
            ],
            [
                'status' => 'offline.menu.payment',
                'guard_name' => 'admin',
                'module' => 'payment',
            ],
            [
                'status' => 'offline.status.payment',
                'guard_name' => 'admin',
                'module' => 'payment',
            ],
            [
                'status' => 'status.bundle',
                'guard_name' => 'admin',
                'module' => 'bundle',
            ]

        ];
        if (Permission::count() == 0) {
            Permission::insert($permissions);
        }
    }
}
