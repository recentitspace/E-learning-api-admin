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
                <a href=" {{ route('blog.list') }}" aria-label="View all latest news"
                    class="btn b-outline btn-primary-outline btn-xl font-bold">
                    {{ translate('View News') }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper blog-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @forelse($blogs as $blog)
                    <x-theme::cards.blog.card-three :blog="$blog" />
                @empty
                    <div class="bg-white border border-border rounded-xl h-[400px] shadow-md">
                        <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                            <h2 class="area-title xl:text-3xl">{{ translate('Oops, Nothing Here Yet') }}!</h2>
                            <p class="area-description">
                                {{ translate("It looks like we don't have any courses in this category right now. Feel free to browse other categories or let us know if there's something specific you'd like to learn!") }}
                            </p>
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</div>
<!-- END MOST RECENT BLOG AREA -->
