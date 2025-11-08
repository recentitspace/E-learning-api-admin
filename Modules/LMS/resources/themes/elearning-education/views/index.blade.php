@php
    $logo =
        get_theme_option(key: 'theme_logo', theme_slug: 'elearning-education') ??
        (get_theme_option(key: 'theme_logo') ?? []);
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
        'dropdown_wrapper' => '',
        'dropdown_link' => '',
    ];
    $searchClass = [
        'input' => 'border-white/15 rounded-none text-white/70',
    ];
    $footerBg = asset('lms/frontend/assets/images/footer/footer-two-bg.png');
    $settings = [
        'menus' => get_menus(),
        'header' => [
            'theme' => active_theme_slug(),
        ],
        'menu_class' => $menuClass,
        'search_class' => $searchClass,
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'components' => [],
        'loggedin' => [
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !rounded-none font-semibold',
        ],
        'login' => [
            'url' => route('login'),
            'label' => translate('Log In'),
            'is_show' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !rounded-none font-semibold',
        ],
        'register' => [
            'url' => route('auth.register'),
            'label' => translate('Get Started Now'),
            'is_show' => true,
            'show_icon' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !rounded-none font-semibold',
        ],
        'cart' => [
            'is_show' => true,
            'url' => route('cart.page'),
            'icon_image' => asset('lms/frontend/assets/images/icons/cart-white.svg'),
            'badge_class' =>
                'flex-center size-6 rounded-50 bg-primary text-xs text-white border border-heading absolute top-0 -right-1 rtl:right-auto rtl:-left-1',
        ],
        'wishlist' => [
            'is_show' => true,
            'badge_class' =>
                'flex-center size-6 rounded-50 bg-primary text-xs text-white border border-heading absolute top-0 -right-1 rtl:right-auto rtl:-left-1',
        ],
        'footer' => [
            'wrapper_class' => 'bg-[#1B253A] mt-16 sm:mt-24 lg:mt-[120px] bg-[length:100%_100%]',
            'wrapper_style' => "background-image: url($footerBg)",
            'theme' => active_theme_slug(),
        ],
        'subscribe' => [
            'btn_text' => translate('Subscribe'),
            'wrapper_class' => 'mt-6',
            'input_class' => 'form-input bg-heading text-white/40 h-12 rounded-none px-4 border border-border grow',
            'btn_class' => 'btn b-solid btn-primary-solid rounded-none w-full mt-3',
        ],
    ];
@endphp

<x-frontend-layout class="home-e-learning" :data="$settings">
    <!-- START BANNER AREA -->
    <x-elearning-education:theme::hero.hero />
    <!-- END BANNER AREA -->

    <!-- START CATEGORY AREA -->
    <x-elearning-education:theme::category.top-category :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START ABOUT AREA -->
    <x-elearning-education:theme::about.about />
    <!-- END ABOUT AREA -->

    <!-- START FEATURE COURSE AREA -->
    <x-elearning-education:theme::course.featured-course :courses="$data['courses']" />
    <!-- END FEATURE COURSE AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-elearning-education:theme::instructor.top-instructor-two :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START SUBSCRIPTION AREA -->
    @if (module_enable_check('subscribe'))
        <x-elearning-education:theme::subscribe.subscribe-list :subscriptions="$data['subscriptions']" />
    @endif
    <!-- END SUBSCRIPTION AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-elearning-education:theme::testimonial.testimonial-two :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START POSTER AREA -->
    <x-elearning-education:theme::poster.poster-banner />
    <!-- END POSTER AREA -->

    <!-- START POPULAR AREA -->
    <x-elearning-education:theme::course.popular-course :courses="$data['courses']" />
    <!-- END POPULAR AREA -->

    <!-- START BUNDLE COURSE AREA -->
    <x-elearning-education:theme::course.bundle-course :bundles="$data['bundles']" />
    <!-- END BUNDLE COURSE AREA -->

    <!-- START BLOG AREA -->
    <x-elearning-education:theme::blog.recent-blog :blogs="$data['blogs']" />
    <!-- END BLOG AREA -->
</x-frontend-layout>
