<?php

namespace Modules\LMS\Repositories;

use Illuminate\Http\Request;
use DrewM\MailChimp\MailChimp;
use Modules\LMS\Enums\CourseStatus;
use Modules\LMS\Models\Courses\Course;
use Modules\Subscribe\Services\SubscribeService;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Blog\BlogRepository;
use Modules\LMS\Repositories\Courses\CourseRepository;
use Modules\LMS\Repositories\Category\CategoryRepository;
use Modules\LMS\Repositories\Courses\Bundle\BundleRepository;
use Modules\LMS\Repositories\Testimonial\TestimonialRepository;

class HomeRepository extends BaseRepository
{

    public function __construct(protected CourseRepository $course, protected UserRepository $user) {}
    /**
     *  homeContent
     *
     * @return array
     */
    public function homeContent($sections = [])
    {
        $data = [
            'categories' => [],
            'courses' => [],
            'bundles' => [],
            'course_categories' => [],
            'testimonials' => [],
            'upcoming_courses' => [],
            'instructors' => [],
            'organizations' => [],
            'blogs' => [],
            'subscriptions' => []
        ];
        // Category.
        if (in_array('categories', $sections)) {

            $categoryResponse = CategoryRepository::get(
                options: [
                    'take' => $sections['category_item'] ?? 4,
                    'where' => ['parent_id' => null, 'status' => 1],
                    'latest' => [],
                    'withCount' => 'courses',
                    'withWhereHas' => [
                        'courses',
                        function ($query) {
                            $query->where('status', CourseStatus::APPROVED)
                                ->withWhereHas(
                                    'instructors',
                                    function ($query1) {
                                        $query1->where('is_verify', 1)
                                            ->with(
                                                'userable',
                                                function ($query2) {
                                                    $query2->where('status', 1);
                                                }
                                            );
                                    }
                                )
                                ->with('courseSetting');
                        }
                    ]
                ],
                relations: [
                    'courses',
                    'icon',
                    'translations' => function ($query) {
                        $query->where('locale', app()->getLocale());
                    }
                ]
            );

            if ($categoryResponse['status'] === 'success') {
                $data['categories'] = $categoryResponse['data'] ?? [];
            }
        }

        // Popular Courses.
        if (in_array('courses', $sections)) {
            $courseResponse = CourseRepository::get(
                options: [
                    'where' => ['status', CourseStatus::APPROVED],
                    'latest' => [],
                    'take' => 6,
                ],
                relations: [
                    'instructors.userable.translations',
                    'category' => function ($query) {
                        $query->whereNull('parent_id');
                    },
                    'reviews',
                    'levels',
                    'chapters',
                    'courseSetting',
                    'coursePrice',
                    'totalPurchases',
                    'translations',
                    'levels.translations',
                ]
            );

            if ($courseResponse['status'] === 'success') {
                $data['courses'] = $courseResponse['data'] ?? [];
            }
        }

        // Course Categories
        if (in_array('course_categories', $sections)) {
            $data['course_categories'] = courseCategory(6);
        }


        // bundles.
        if (in_array('bundles', $sections)) {
            $item = $sections['item'] ?? 5;
            $bundleResponse = BundleRepository::get(
                options: [
                    'where' => ['status' => 1],
                    'latest' => [],
                    'take' => $item
                ],
                relations: [
                    'levels',
                    'levels.translations',
                    'category.translations',

                ]
            );

            if ($bundleResponse['status'] === 'success') {
                $data['bundles'] = $bundleResponse['data'] ?? [];
            }
        }


        // Testimonials.
        if (in_array('testimonials', $sections)) {
            $testimonialResponse = TestimonialRepository::get(
                options: [
                    'where' => ['status', 1],
                ],
                relations: [
                    'translations' => function ($query) {
                        $query->where('locale', app()->getLocale());
                    }
                ]
            );

            if ($testimonialResponse['status'] === 'success') {
                $data['testimonials'] = $testimonialResponse['data'] ?? [];
            }
        }

        // Upcoming courses.
        if (in_array('upcoming_courses', $sections)) {
            $data['upcoming_courses'] = $this->course->courseList(Request()->merge(['is_upcoming' => true]));
        }

        // Instructors.
        if (in_array('instructors', $sections)) {
            $data['instructors'] = $this->user->instructorList(Request()->merge(['guard' => 'instructor', 'take' => 10]));
        }
        // Organization.
        if (in_array('organizations', $sections)) {
            $data['organizations'] = $this->user->instructorList(Request()->merge(['guard' => 'organization', 'take' => 5]));
        }


        // Blogs.
        if (in_array('blogs', $sections)) {

            $blogItem = $sections['blog_item'] ??   3;
            $blogResponse = BlogRepository::get(
                options: [
                    'where' => ['status' => 1],
                    'latest' => [],
                    'take' => $blogItem
                ],
                relations: [
                    'author',
                    'author.userable',
                    'adminAuthor',
                    'comments',
                    'blogCategories.translations' => function ($query) {
                        $query->where('locale', app()->getLocale());
                    }
                ]
            );

            if ($blogResponse['status'] === 'success') {
                $data['blogs'] = $blogResponse['data'] ?? [];
            }

            if (module_enable_check('subscribe')) {
                if (in_array('subscriptions', $sections)) {
                    $data['subscriptions'] = SubscribeService::getSubscribe();
                }
            }
        }

        // Subscriptions.
        return $data;
    }

    /**
     *  courseCategory
     *
     * @param  $slug  $slug ['category slug']
     * @return object
     */
    public function courseCategory($slug = null)
    {
        $courses = Course::whereHas('category', function ($query) use ($slug) {
            $query->where(function ($query) use ($slug) {
                $query->where('parent_id', null);
                if (! empty($slug) && $slug !== 'All') {
                    $query->where('slug', $slug);
                }
            })

                ->with('instructors.userable');
        })->where('status', CourseStatus::APPROVED)
            ->latest()
            ->take(6)
            ->get();

        return $courses;
    }

    /**
     * Method newsletterSubscribe
     *
     * @param  Request  $request
     */
    public function newsletterSubscribe($request)
    {

        $mailchimp = get_theme_option(key: 'mailchimp');

        try {
            if ($request->email == '') {
                return [
                    'status' => 'error',
                    'message' => translate('Enter Your Mail'),
                ];
            }
            if ($mailchimp['status'] !== 'on') {
                return [
                    'status' => 'error',
                    'message' => translate('Mailchamp is disabled'),
                ];
            }
            $api_key = $mailchimp['api_key'] ?? '';
            $list_id =  $mailchimp['list_id'] ?? '';
            $mailChimp = new MailChimp($api_key);
            $mailChimp->post("lists/$list_id/members", [
                'email_address' => $request->email,
                'status' => 'subscribed',
            ]);
            if ($mailChimp->success()) {
                return [
                    'status' => 'success',
                    'message' => translate('Thanks For Subscribe'),
                    'type' => true,
                ];
            }

            return [
                'status' => 'success',
                'message' => translate('Already Subscriber'),
                'type' => true,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => translate('Something Wrong'),
            ];
        }
    }
}
