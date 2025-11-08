@php
    $logo =
        get_theme_option(key: 'theme_logo', theme_slug: 'kindergarten') ?? (get_theme_option(key: 'theme_logo') ?? []);
    $defaultLogo =
        isset($logo['logo']) && fileExists('lms/theme-options', $logo['logo']) == true
            ? asset("storage/lms/theme-options/{$logo['logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
    $footerLogo =
        isset($logo['footer_logo']) && fileExists('lms/theme-options', $logo['footer_logo']) == true
            ? asset("storage/lms/theme-options/{$logo['footer_logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $favIcon =
        isset($logo['favicon']) && fileExists('lms/theme-options', $logo['favicon']) == true
            ? asset("storage/lms/theme-options/{$logo['favicon']}")
            : asset('lms/frontend/assets/images/favicon.ico');

    $headerClass = 'bg-white sticky-header';
    $headerWrapperClass = 'flex-center-between py-4';
    $rightActionsWrapperClass = 'self-end flex items-center gap-5';
    $menuClass = [];
    $searchClass = [];
    $active_theme_slug = active_theme_slug();
    $settings = [
        'menus' => get_menus(),
        'active_theme_slug' => $active_theme_slug,
        'header_class' => $headerClass,
        'header_wrapper_class' => $headerWrapperClass,
        'right_actions_wrapper_class' => $rightActionsWrapperClass,
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'menu_class' => $menuClass,
        'search_class' => $searchClass,
        'components' => [
            'inner-header-top' => false,
        ],
        'loggedin' => [],
        'login' => [
            'url' => route('login'),
            'label' => translate('Log In'),
            'is_show' => false,
        ],
        'register' => [
            'url' => route('auth.register'),
            'label' => translate('Join for free'),
            'is_show' => true,
            'show_icon' => false,
        ],
        'cart' => [
            'is_show' => true,
            'url' => route('cart.page'),
        ],
        'wishlist' => [
            'is_show' => true,
        ],
        'search' => [
            'is_show' => false,
        ],
        'header' => [
            'theme' => $active_theme_slug,
        ],
        'footer' => [
            'wrapper_class' =>
                'bg-gradient-to-b from-[#FEFBF0] to-[#E6F3EB] mt-16 sm:mt-24 lg:mt-[120px] relative overflow-hidden',
            'theme' => active_theme_slug(),
        ],
    ];

@endphp

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&display=swap"
        rel="stylesheet">
@endpush

<x-frontend-layout class="home-kindergarten" :data="$settings">
    <!-- START BANNER AREA -->
    <x-kindergarten:theme::hero.hero />
    <!-- END BANNER AREA -->

    <!-- START ABOUT US AREA -->
    <x-kindergarten:theme::about.about />
    <!-- END ABOUT US AREA -->

    <!-- START KIDS COURSE AREA -->
    <x-kindergarten:theme::course.kid-course :courses="$data['courses']" :course-categories="$data['course_categories']" />
    <!-- END KIDS COURSE AREA -->

    <!-- START WORK PROCESS AREA -->
    <x-kindergarten:theme::work.process />
    <!-- END WORK PROCESS AREA -->

    <!-- START COUNTER AREA -->
    <x-kindergarten:theme::counter.counter />
    <!-- END COUNTER AREA -->

    <!-- START ADMISSION AREA -->
    <x-kindergarten:theme::form.admission />
    <!-- END ADMISSION AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-kindergarten:theme::instructor.top :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START TRUSTED PARTNERS AREA -->
    <x-kindergarten:theme::partner.partner />
    <!-- START TRUSTED PARTNERS AREA -->

    <!-- START SUBSCRIPTION AREA -->
    @if (module_enable_check('subscribe'))
        <x-kindergarten:theme::subscribe.subscribe-list :subscriptions="$data['subscriptions']" />
    @endif
    <!-- END SUBSCRIPTION AREA -->

    <!-- START LATEST NEWS AND BLOG AREA -->
    <x-kindergarten:theme::blog.blog :blogs="$data['blogs']" />
    <!-- END LATEST NEWS AND BLOG AREA -->

    <!-- START CTA BANNER -->
    <x-kindergarten:theme::cta.cta />
    <!-- END CTA BANNER -->
</x-frontend-layout>
