<x-frontend-layout>
    <!-- START BANNER AREA -->
    <x-theme::hero.hero-one />
    <!-- END BANNER AREA -->

    <!-- START CATEGORY AREA -->
    <x-theme::category.top-category :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START POPULAR COURSE AREA -->
    <x-theme::course.top-course :courseCategories="$data['course_categories']" :courses="$data['courses']" />
    <!-- END POPULAR COURSE AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-theme::testimonial.testimonial-one :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START COUNTER AREA -->
    <x-theme::counter.counter-one />
    <!-- END COUNTER AREA -->

    <!-- START UPCOMING COURSE AREA -->
    <x-theme::course.upcoming-course :upcomingCourses="$data['upcoming_courses']" />
    <!-- END UPCOMING COURSE AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-theme::instructor.top-instructor :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START ONLINE VIDEO COURSE AREA -->
    <x-theme::join-us.join-us />
    <!-- END ONLINE VIDEO COURSE AREA -->

    <x-theme::blog.latest-blog-one :blogs="$data['blogs']" />

    <!-- START Subscribe AREA -->
    <x-theme::subscribe.subscribe-list :subscriptions="$data['subscriptions']" />
    <!-- END Subscribe AREA -->


</x-frontend-layout>
