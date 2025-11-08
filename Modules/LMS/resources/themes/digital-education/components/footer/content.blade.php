@php
    $footer = $data['footer'] ?? [];
    $top =
        get_theme_option('footer_top' . active_language()) ?:
        get_theme_option('footer_topen') ?? get_theme_option('footer_top' . app('default_language'));

    $socials = get_theme_option(key: 'socials', parent_key: 'social') ?? [];
    $menus = $data['menus'] ?? get_menus();
    $childMenus = $menus['course_bundle']['childs'] ?? [];

@endphp

<div class="py-24 lg:py-32">
    <div class="container divide-y divide-white/10">
        <x-dynamic-component component="theme::footer.top" :data="$data" />
        <div class="grid grid-cols-12 items-center gap-7 mt-5 pt-14">
            @if (isset($top['one_status']))
                <div class="col-span-full lg:col-span-6">
                    <div class="text-white/70 text-lg max-w-[320px]">
                        {{ $top['one_title'] ?? '' }}
                    </div>
                    @if ($top['one_social_menu'] ?? false)
                        @if ($socials)
                            <x-theme::social.social-list-one :socials="$socials" ulClass="flex items-center gap-2 mt-5"
                                itemClass="flex-center size-10 rounded-50 text-white bg-white/10 hover:bg-primary hover:text-heading custom-transition" />
                        @endif
                    @endif
                </div>
            @endif
            <div class="col-span-full lg:col-span-6">
                <nav class="flex-center !justify-start lg:!justify-end">
                    <ul class="flex items-center gap-x-5 gap-y-2 flex-wrap leading-none text-heading font-medium">

                        @foreach ($menus as $menu)
                            @if ($menu['name'] !== 'Pages' && $menu['name'] !== 'Theme')
                                <li class="flex-center">
                                    <a href="{{ $menu['url'] ?? '#' }}" aria-label="Menu link"
                                        class="inline-block px-2 py-3 text-white/70 hover:text-primary [&.active]:text-primary custom-transition">
                                        {{ $menu['name'] }}</a>
                                </li>
                            @endif
                        @endforeach

                        @php
                            $childMenus = $menus['course_bundle']['childs'] ?? [];
                        @endphp

                        @foreach ($childMenus as $key => $menu)
                            @php
                                if ($key == 2) {
                                    break;
                                }

                            @endphp
                            <li class="flex-center">
                                <a href="{{ $menu['url'] ?? '#' }}" aria-label="Menu link"
                                    class="inline-block px-2 py-3 text-white/70 hover:text-primary [&.active]:text-primary custom-transition">
                                    {{ $menu['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
