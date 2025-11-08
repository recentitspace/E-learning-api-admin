@php
    $bottom =
        get_theme_option('footer_bottom' . active_language()) ?:
        get_theme_option('footer_bottomen') ?? get_theme_option('footer_bottom' . app('default_language'));

@endphp
@if (isset($bottom['status']))
    <!-- START BOTTOM -->
    <div class="bg-[#FFFFFF0F] py-5 rounded-t-lg">
        <div class="container">
            <div class="grid grid-cols-12 gap-7 items-center">
                <div class="col-span-full lg:col-span-6">
                    <div class="text-sm !leading-none font-semibold text-white/80 text-center lg:text-left rtl:lg:text-right">
                        {!! clean($bottom['copy_right'] ?? '') !!}
                    </div>
                </div>
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left rtl:lg:text-right">
                        <div
                            class="flex items-center justify-center lg:justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow text-white/80">
                            {!! clean($bottom['menu'] ?? '') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
