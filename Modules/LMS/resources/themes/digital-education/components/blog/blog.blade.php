@php $blogs = $blogs ?? []; @endphp

<div class="bg-section relative py-16 sm:py-24 lg:py-[120px] mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate( 'Latest Blogs' ) }}</div>
                <h2 class="area-title mt-2">{{ translate( 'My Latest Insights & Articles' ) }}</h2>
            </div>
        </div>
        <!-- BODY -->
        @if( !empty( $blogs ) && is_iterable( $blogs ) )
        <div class="swiper blog-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach( $blogs as $blog )
                <x-theme::cards.blog.card-four :blog="$blog" />
                @endforeach
            </div>
        </div>
        <div class="flex-center mt-10 lg:mt-[60px]">
            <a href="{{ route( 'blog.list' ) }}" class="btn b-solid btn-primary-solid btn-lg !text-heading !text-base font-bold" aria-label="View All Blogs">
               {{ translate( 'View All Blogs' ) }}
            </a>
        </div>
        @endif
    </div>
</div>