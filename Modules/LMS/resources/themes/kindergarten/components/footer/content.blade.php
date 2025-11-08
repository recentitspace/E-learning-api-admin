@php
    $footer = $data['footer'] ?? [];
    $top =
        get_theme_option('footer_top' . active_language()) ?:
        get_theme_option('footer_topen') ?? get_theme_option('footer_top' . app('default_language'));

    $socials = get_theme_option(key: 'socials', parent_key: 'social') ?? [];
    $menus = $data['menus'] ?? get_menus();
    $childMenus = $menus['course_bundle']['childs'] ?? [];
@endphp

<div class="pt-[300px] pb-24 lg:pb-32 bg-[url('../../assets/images/footer/footer-bg-line.png')] bg-no-repeat bg-center relative z-[1]">
    <div class="container divide-y divide-heading/15">
        <x-dynamic-component component="theme::footer.top" />
        <div class="grid grid-cols-12 items-center gap-7 mt-5 pt-14">
            <div class="col-span-full lg:col-span-6">
                <div class="area-description max-w-[320px]">
                    {{ $top['one_title'] ?? '' }}
                </div>
                @if ($socials)
                    <x-theme::social.social-list-one :socials="$socials" ul-class="flex items-center gap-2 mt-5"
                        item-class="flex-center size-10 rounded-50 border border-heading/15 text-heading hover:bg-primary hover:text-white custom-transition" />
                @endif
            </div>
            <div class="col-span-full lg:col-span-6">
                <nav class="flex-center !justify-start lg:!justify-end">
                    <ul class="flex items-center gap-x-5 gap-y-2 flex-wrap leading-none text-heading font-medium">

                        @foreach ($menus as $menu)
                            @if ($menu['name'] !== 'Pages' && $menu['name'] !== 'Theme')
                                <li class="flex-center">
                                    <a href="{{ $menu['url'] ?? '#' }}"
                                        class="inline-block px-2 py-3 text-heading hover:text-primary custom-transition"
                                        aria-label="Footer menu">
                                        {{ $menu['name'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                        @foreach ($childMenus as $key => $menu)
                            @php
                                if ($key == 2) {
                                    break;
                                }
                            @endphp
                            <li class="flex-center">
                                <a href="{{ $menu['url'] ?? '#' }}" aria-label="Menu link"
                                    class="inline-block px-2 py-3 text-heading hover:text-primary custom-transition">
                                    {{ $menu['name'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- POSITIONAL ELEMENT -->
<ul>
    <!-- TOP LEFT -->
    <li class="block size-[29vw] rounded-50 bg-[#D2EB1A]/15 blur-[200px] absolute top-0 xl:-top-20 left-0 xl:-left-20 z-0"></li>
    <!-- TOP RIGHT -->
    <li class="block size-[29vw] rounded-50 bg-[#B326F4]/15 blur-[200px] absolute top-0 xl:-top-20 right-0 xl:-right-20 z-0"></li>
</ul>
