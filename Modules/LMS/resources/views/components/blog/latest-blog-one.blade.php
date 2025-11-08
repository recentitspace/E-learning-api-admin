@php
    $blogs = $blogs ?? [];
    $totalBlogs = count($blogs);

    $blogRoute = '';
    $blogBtnText = '';

    if ($totalBlogs > 0) {
        $blogRoute = route('blog.list');
        $blogBtnText = 'See All Blog';
    }

    if (isAdmin() && $totalBlogs < 1) {
        $blogRoute = route('blog.create');
        $blogBtnText = 'Add Blog';
    }
@endphp

<!-- START BLOG AREA -->
<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                <div class="area-subtitle"> {{ translate('Frequent Updates') }} </div>
                <h2 class="area-title mt-2">
                    {{ translate('Updated News &') }}
                    <span class="title-highlight-one">{{ translate('Blogs') }}</span>
                </h2>
            </div>

            @if ($blogRoute && $blogBtnText)
                <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                    <a href="{{ $blogRoute }}" title="{{ $blogBtnText }}"
                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                        aria-label="{{ $blogRoute }}">
                        {{ translate($blogBtnText) }}
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                </div>
            @endif
        </div>
        <!-- BODY -->
        <div class="swiper blog-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <x-theme::cards.blog-card-one :blogs=$blogs />
            </div>
        </div>
    </div>
</div>
