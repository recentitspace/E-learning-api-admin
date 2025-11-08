<?php

namespace Modules\LMS\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Modules\LMS\Models\Page;
use App\Http\Controllers\Controller;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\User;
use Modules\LMS\Repositories\HomeRepository;
use Modules\LMS\Repositories\Auth\UserRepository;
use Modules\LMS\Repositories\Courses\CourseRepository;


class HomeController extends Controller
{
    public function __construct(
        protected UserRepository $user,
        protected HomeRepository $home,
        protected CourseRepository $course
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = [];
        $active_theme_slug = active_theme_slug();

        switch ($active_theme_slug) {
            case 'digital-education':
                $sections = [
                    'categories',
                    'courses',
                    'bundles',
                    'course_categories',
                    'testimonials',
                    'blogs',
                    'subscriptions',
                    'category_item' => 8
                ];
                break;
            case 'elearning-education':
                $sections = [
                    'categories',
                    'courses',
                    'bundles',
                    'testimonials',
                    'instructors',
                    'subscriptions',
                    'blogs',
                    'organizations',
                    'category_item' => 8
                ];
                break;
            case 'kindergarten':
                $sections = [
                    'courses',
                    'bundles',
                    'course_categories',
                    'instructors',
                    'subscriptions',
                    'blogs',
                    'category_item' => 8,
                    'blog_item' => 4,
                ];
                break;
            case 'lms-education':
                $sections = [
                    'categories',
                    'courses',
                    'bundles',
                    'testimonials',
                    'instructors',
                    'organizations',
                    'subscriptions',
                    'blogs',
                    'category_item' => 8
                ];
                break;
            default:
                $sections = [
                    'categories',
                    'courses',
                    'bundles',
                    'upcoming_courses',
                    'testimonials',
                    'instructors',
                    'blogs',
                    'subscriptions',
                    'category_item' => 4,
                    'blog_item' => 3,
                ];
                break;
        }
        $data = $this->home->homeContent($sections);
        return view('theme::index', compact('data'));
    }

    /**
     * Method success
     */
    public function success()
    {
        toastr()->success(translate('Email Verification Successfully.'));
        return view('theme::success.success');
    }

    /**
     *  verificationMail
     *
     * @param  $id  $id
     */
    public function verificationMail($id)
    {
        $result = $this->user->verifyMail($id);
        if ($result['status'] !== 'success') {
            toastr()->error(translate('Email Verification not Successfully.'));
            return redirect('login');
        }
        toastr()->success(translate('Email Verification Successfully.'));
        return redirect('login');
    }

    /**
     * userDetail
     *
     * @param  int  $id
     */
    public function userDetail($id)
    {
        $user = $this->user->getUserById($id);
        if (!$user) {
            return view('theme::404');
        }
        if ($user->guard == 'instructor') {

            $request = Request()->merge([
                'instructors' =>  $id
            ]);
            $courseId = $this->course->courseList($request, item: null)
                ->pluck('id')->toArray();

            $rating = instructorOrgUser_review($courseId);
            $courses = Course::with('reviews', 'translations')->whereHas('instructors', function ($query) use ($id) {
                $query->where('instructor_id', $id)
                    ->where('is_verify', 1)
                    ->whereHas('userable', function ($query) {
                        $query->where('status', 1);
                    });
            })
                ->paginate(3);

            $totalStudents = instructor_student($user?->courses?->pluck('id')->toArray());
            return view('theme::instructor.profile-details', compact('user', 'courses', 'totalStudents', 'rating'));
        }
        if ($user->guard == 'organization') {
            $request = Request()->merge([
                'organizations' =>  $id
            ]);
            $courseId = $this->course->courseList($request, item: null)
                ->pluck('id')->toArray();
            $rating = instructorOrgUser_review($courseId);

            $courses = Course::with('reviews', 'translations')->where('organization_id', $id)->paginate(3);
            $request->merge(['guard' => 'instructor', 'org_instructors' => $id]);
            $totalInstructors = $this->user->instructorList($request, item: null)->count();

            return view('theme::organization.profile-details', compact('user', 'totalInstructors', 'courses', 'rating'));
        }
    }

    /**
     * categoryCourse
     *
     * @param  string  $slug
     */
    public function categoryCourse($slug)
    {
        $courses = $this->home->courseCategory($slug);
        $data = view('theme::components.frontend.cards.course-card-one', compact('courses'))->render();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    /**
     * newsletter_subscribe
     *
     * @param  mixed  $request
     */
    public function newsletterSubscribe(Request $request)
    {
        return $this->home->newsletterSubscribe($request);
    }


    public function policyContent()
    {
        $page = Page::where('url', 'privacy-policy')->first();
        if (!$page) {
            return view('theme::404');
        }
        // no need to translate function because this title translation into breadcrumb card

        $title = "Privacy and Policy";


        return view('theme::page', compact('title', 'page'));
    }

    public function termsCondition()
    {
        // no need to translate function because this title translation into breadcrumb card
        $title = "Terms and Condition";
        $page = Page::where('url', 'terms-conditions')->first();
        if (!$page) {
            return view('theme::404');
        }
        return view('theme::page', compact('title', 'page'));
    }

    public function categoryList()
    {
        $categories = get_all_category(status: 1, item: 8);
        return view('theme::category.index', compact('categories'));
    }


    public function notFound()
    {
        return view('theme::404');
    }
    public function aboutUs()
    {
        return view('theme::about-us.index');
    }


    public function addWishlist(Request $request)
    {
        $courseId = $request->course_id;
        $user =  User::with('wishlists')->where('id',  authCheck()->id)->first();
        if (!$user) {
            return response()->json([
                'status' => 'success',
                'message' => translate("Please Login")
            ]);
        }
        $wishlist = $user->wishlists()->where('course_id', $courseId)->count();
        $wishlist == 0 ? $user->wishlists()->attach($courseId) : $user->wishlists()->detach($courseId);
        $message = $wishlist == 0 ? 'Wishlist Added Successfully' : 'Wishlist Remove Successfully';
        return response()->json([
            'status' => 'success',
            'message' =>  translate($message),
            'total' => $user->wishlists()->count(),
            'wishlist' => 'yes'
        ]);
    }
}
