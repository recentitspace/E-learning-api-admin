@php
    $blogs = $blogs ?? [];
@endphp

<div class="relative pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[500px] mx-auto">
                <h2 class="area-title">
                    {{ translate('Explore Our Latest') }}
                    <span class="title-highlight-two">{{ translate('News & Articles') }}</span>
                </h2>
            </div>
        </div>
        <!-- BODY -->
        @if (count($blogs) > 0)
            <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 mt-10 lg:mt-[60px]">
                <!-- SINGLE NEWS CARD -->
                @foreach ($blogs as $key => $blog)
                    <x-theme::cards.blog.card-five :blog="$blog" />
                @endforeach
            </div>
        @endif
    </div>
</div>
