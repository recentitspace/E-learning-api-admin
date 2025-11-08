<!-- START MOST RECENT BLOG AREA -->
<div class="relative pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <h2 class="area-title">
                    {{ translate('Our Most Recent Daily Blog Posts and Our News') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper blog-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach ($blogs as $blog)
                    <x-theme::cards.blog.card-two :blog="$blog" />
                @endforeach
            </div>
        </div>
    </div>
</div>
