@php
    $bottom =
        get_theme_option('footer_bottom' . active_language()) ?:
        get_theme_option('footer_bottomen') ?? get_theme_option('footer_bottom' . app('default_language'));
@endphp


@if (isset($bottom['status']))
    <div class="container">
        <div class="bg-[#FFFFFF0F] px-4 py-5 border border-heading/15 border-b-0 rounded-t-lg">
            <div class="grid grid-cols-12 gap-7">
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left">
                        <div class="text-sm !leading-none font-semibold text-heading/80">
                            {!! clean($bottom['copy_right'] ?? '') !!}
                        </div>
                    </div>
                </div>
                <div class="col-span-full lg:col-span-6">
                    <div class="text-center lg:text-left">
                        <div
                            class="flex items-center justify-center lg:justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
                            {!! clean($bottom['menu'] ?? '') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
