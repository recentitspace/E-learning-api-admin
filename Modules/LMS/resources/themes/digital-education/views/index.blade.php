@php
    $logo_options =
        get_theme_option(key: 'theme_logo', theme_slug: 'digital-education') ??
        (get_theme_option(key: 'theme_logo') ?? []);

    $defaultLogo =
        isset($logo_options['logo']) && fileExists('lms/theme-options', $logo_options['logo']) == true
            ? asset("storage/lms/theme-options/{$logo_options['logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $footerLogo =
        isset($logo_options['footer_logo']) && fileExists('lms/theme-options', $logo_options['footer_logo']) == true
            ? asset("storage/lms/theme-options/{$logo_options['footer_logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $favIcon =
        isset($logo_options['favicon']) && fileExists('lms/theme-options', $logo_options['favicon']) == true
            ? asset("storage/lms/theme-options/{$logo_options['favicon']}")
            : asset('lms/frontend/assets/images/favicon.ico');

    $headerClass =
        'bg-transparent absolute top-3 lg:top-0 left-0 right-0 z-[20] sticky-header [&.sticky]:!top-0 [&.sticky]:!shadow-none group/header';
    $headerWrapperClass =
        'flex-center-between px-5 py-4 bg-white/10 backdrop-blur-[10px] rounded-[10px] group-[.sticky]/header:rounded-t-none group-[.sticky]/header:bg-heading';
    $rightActionsWrapperClass = 'self-end flex items-center gap-5';
    $menuClass = [
        'wrapper' => 'text-white',
        'dropdown_wrapper' => 'bg-secondary',
        'dropdown_link' => 'hover:before:bg-primary',
    ];
    $searchClass = [
        'input' => ' text-white/70 border-white/10',
    ];

    $active_theme_slug = active_theme_slug();

    $settings = [
        'menus' => get_menus(),
        'active_theme_slug' => $active_theme_slug,
        'header' => [
            'theme' => $active_theme_slug,
        ],
        'header_class' => $headerClass,
        'header_wrapper_class' => $headerWrapperClass,
        'right_actions_wrapper_class' => $rightActionsWrapperClass,
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'menu_class' => $menuClass,
        'search_class' => $searchClass,
        'components' => [
            'inner-header-top' => 'inner-header-top',
        ],
        'loggedin' => [
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !text-heading font-semibold',
        ],
        'login' => [
            'url' => route('login'),
            'label' => 'Log In',
            'is_show' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !text-heading font-semibold',
        ],
        'register' => [
            'url' => route('auth.register'),
            'label' => 'Join for free',
            'is_show' => true,
            'show_icon' => false,
            'link_class' => 'btn b-solid btn-primary-solid btn-lg h-11 !text-heading font-semibold',
        ],
        'cart' => [
            'is_show' => true,
            'url' => route('cart.page'),
            'icon_image' => asset('lms/frontend/assets/images/icons/cart-white.svg'),
            'badge_class' => 'flex-center size-6 rounded-50 bg-secondary text-xs text-white absolute top-0 -right-1',
        ],
        'wishlist' => [
            'is_show' => true,
            'icon_image' => asset('lms/frontend/assets/images/icons/wish-list-white.svg'),
            'badge_class' => 'flex-center size-6 rounded-50 bg-secondary text-xs text-white absolute top-0 -right-1',
        ],
        'footer' => [
            'wrapper_class' => 'bg-gradient-to-t from-[#16413B] to-[#3C5F3F] mt-16 sm:mt-24 lg:mt-[120px]',
            'theme' => $active_theme_slug,
        ],
    ];
@endphp


@push('css')
    <link rel="stylesheet" href="{{ asset('lms/frontend/assets/vendor/css/plyr.min.css') }}">
@endpush

<x-frontend-layout class="home-digital-education" :data="$settings">
    <!-- START BANNER AREA -->
    <x-digital-education:theme::hero.hero />
    <!-- END BANNER AREA -->

    <!-- START ABOUT US AREA -->
    <x-digital-education:theme::about.about />
    <!-- END ABOUT US AREA -->

    <!-- START ONLINE COURSE AREA -->
    <x-digital-education:theme::course.best-online-course :courses="$data['courses']" :course-categories="$data['course_categories']" />
    <!-- END ONLINE COURSE AREA -->

    <!-- START OUR NEW COURSE AREA -->
    <x-digital-education:theme::course.new-course :courses="$data['courses']" :course-categories="$data['course_categories']" />
    <!-- END OUR NEW COURSE AREA -->

    <!-- START OUR NEW COURSE AREA -->
    <x-digital-education:theme::course.bundle-course :bundles="$data['bundles']" />
    <!-- END OUR NEW COURSE AREA -->

    <!-- START CATEGORY AREA -->
    <x-digital-education:theme::category.top-category :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-digital-education:theme::testimonial.testimonial :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START CONTACT AREA -->
    <x-digital-education:theme::contact.contact />
    <!-- END CONTACT AREA -->

    <!-- START BLOG AREA -->
    <x-digital-education:theme::blog.blog :blogs="$data['blogs']" />
    <!-- END BLOG AREA -->

    <!-- START SUBSCRIPTION AREA -->
    @if (module_enable_check('subscribe'))
        <x-digital-education:theme::subscribe.subscribe-list :subscriptions="$data['subscriptions']" />
    @endif
    <!-- END SUBSCRIPTION AREA -->

    <!-- START MOBILE APP BANNER -->
    <x-digital-education:theme::cta.mobile-app />
    <!-- END MOBILE APP BANNER -->

    <div id="demo-video-modal" class="fixed inset-0 z-modal flex-center !hidden bg-black/50 modal">
        <div
            class="modal-content bg-white rounded-lg shadow-lg w-full max-w-screen-md transform transition-all duration-300 opacity-0 -translate-y-10 m-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b">
                <button
                    type="button"
                    class="absolute top-3 end-2.5 text-heading bg-gray-200 rounded-lg size-8 flex-center close-modal-btn"
                    onclick="player.stop();"
                >
                    <i class="ri-close-line text-inherit"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4 pt-0 max-h-[80vh] overflow-auto">
                <video id="demo-video" playsinline controls>
                    <source src="{{ asset('lms/frontend/assets/video/video.mp4') }}" type="video/mp4" />
                </video>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ asset('lms/frontend/assets/vendor/js/plyr.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/modal.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/video-play.js') }}"></script>
    @endpush
</x-frontend-layout>
