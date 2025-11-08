@php
    $logo =
        get_theme_option(key: 'theme_logo', theme_slug: 'lms-education') ?? (get_theme_option(key: 'theme_logo') ?? []);

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

    $menuClass = [
        'wrapper' => 'text-white',
        'dropdown_wrapper' => 'bg-secondary',
        'dropdown_link' => 'hover:before:bg-primary',
    ];
    $searchClass = [
        'input' => 'form-input text-heading/70',
    ];

    $settings = [
        'menus' => get_menus(),
        'header' => [
            'theme' => active_theme_slug(),
        ],
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'menu_class' => $menuClass,
        'search_class' => $searchClass,
        'components' => [],
        'loggedin' => [
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 font-semibold',
        ],
        'login' => [
            'url' => route('login'),
            'label' => translate('Log In'),
            'is_show' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 font-semibold',
        ],
        'register' => [
            'url' => route('auth.register'),
            'label' => translate('Get Started Now'),
            'is_show' => true,
            'show_icon' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 font-semibold',
        ],
        'cart' => [
            'is_show' => true,
            'url' => route('cart.page'),
            'icon_image' => asset('lms/frontend/assets/images/icons/cart.svg'),
            'badge_class' =>
                'flex-center size-6 rounded-50 bg-primary text-xs text-white border border-heading absolute top-0 -right-1 rtl:right-auto rtl:-left-1',
        ],
        'wishlist' => [
            'is_show' => true,
            'icon_image' => asset('lms/frontend/assets/images/icons/wish-list.svg'),
            'badge_class' =>
                'flex-center size-6 rounded-50 bg-primary text-xs text-white border border-heading absolute top-0 -right-1 rtl:right-auto rtl:-left-1',
        ],
        'footer' => [
            'wrapper_class' => 'bg-primary mt-16 sm:mt-24 lg:mt-[120px]',
        ],
        'subscribe' => [
            'btn_text' => translate('Subscribe'),
            'form_class' =>
                'bg-white/10 border border-white/15 rounded-lg p-2 focus-within:border-white custom-transition max-w-screen-sm mt-10',
            'wrapper_class' => 'flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-2',
            'input_class' =>
                'bg-transparent text-white/70 h-12 px-4 border border-primary sm:border-transparent focus:outline-none grow',
            'btn_class' => 'btn b-solid btn-secondary-solid !text-heading shrink-0',
        ],
    ];

@endphp

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet"
    >
@endpush

<x-frontend-layout class="home-lms-education" :data="$settings">
    <!-- START BANNER AREA -->
    <x-lms-education:theme::hero.hero-three />
    <!-- END BANNER AREA -->

    <!-- START ABOUT US AREA -->
    <x-lms-education:theme::about-us.about-us-three />
    <!-- END ABOUT US AREA -->

    <!-- START CATEGORY AREA -->
    <x-lms-education:theme::category.top-category-three :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START POPULAR COURSE AREA -->
    <x-lms-education:theme::course.popular-course-three :courses="$data['courses']" />
    <!-- END POPULAR COURSE AREA -->

    <!-- START BUNDLE COURSE AREA -->
    <x-lms-education:theme::course.bundle-course :bundles="$data['bundles']" />
    <!-- END BUNDLE COURSE AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-lms-education:theme::testimonial.testimonial-three :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-lms-education:theme::instructor.top-instructor-three :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START UPCOMING COURSE AREA -->
    <x-lms-education:theme::course.upcoming-course-three :courses="$data['courses']" />
    <!-- END UPCOMING COURSE AREA -->

    <!-- START ORGANIZATION AREA -->
    <x-lms-education:theme::organization.organization-list-three :organizations="$data['organizations']" />
    <!-- END ORGANIZATION AREA -->

    <!-- START SUBSCRIPTION AREA -->
    @if (module_enable_check('subscribe'))
        <x-lms-education:theme::subscribe.subscribe-list :subscriptions="$data['subscriptions']" />
    @endif
    <!-- END SUBSCRIPTION AREA -->

    <!-- START BLOG AREA -->
    <x-lms-education:theme::blog.recent-blog-three :blogs="$data['blogs']" />
    <!-- END BLOG AREA -->
</x-frontend-layout>
