<!-- START MOST RECENT BLOG AREA -->
<div class="relative pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 lg:pr-20 rtl:lg:pr-0 rtl:lg:pl-20">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase">
                    {{ translate('Latest Blogs') }}
                </div>
                <h2 class="area-title mt-1">
                    {{ translate('Read Our latest blog') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <a href="{{ route('blog.list') }}" class="btn b-outline btn-primary-outline btn-xl font-bold"
                    aria-label="View our latest news">
                    {{ translate('View News') }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper blog-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @php
                    $blogs = [];
                @endphp
                
                @forelse($blogs as $blog)
                    <x-theme::cards.blog.card-three :blog="$blog" />
                @empty
                    <x-theme::cards.empty title="No Blog Available" />
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- END MOST RECENT BLOG AREA -->
