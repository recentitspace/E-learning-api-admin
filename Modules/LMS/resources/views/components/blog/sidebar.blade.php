<div class="col-span-full lg:col-span-4">
    <div id="blog-filter-drawer"
        class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[99] lg:bg-transparent lg:relative lg:visible lg:opacity-100 lg:z-auto">
        <div
            class="blog-filter-drawer-inner bg-white fixed inset-0 left-auto right-0 py-4 w-64 sm:w-80 translate-x-full duration-300 z-[100] lg:relative lg:right-auto lg:py-0 lg:w-full lg:translate-x-0 lg:z-auto">
            <!-- CLOSE DRAWER -->
            <button type="button" aria-label="Blog Sidebar close button"
                class="blog-filter-drawer-close size-11 flex-center lg:hidden bg-white border border-transparent hover:border-primary absolute top-4 right-full custom-transition">
                <i class="ri-close-line text-gray-500 dark:text-dark-text"></i>
            </button>
            <div class="flex flex-col gap-5 max-h-screen lg:max-h-full overflow-auto">
                <!-- FILTER ITEM -->
                <form action="{{ route('blog.list') }}">
                    <div class="bg-primary-50 p-6 rounded-none lg:rounded-xl">
                        <label for="search-filter" class="relative flex">
                            <span class="text-heading/60 absolute top-1/2 -translate-y-1/2 left-4 z-[1]"><i
                                    class="ri-search-2-line"></i></span>
                            <input 
                                type="search" 
                                id="search-filter"
                                class="form-input text-heading/60 h-12 pl-10 bg-white" placeholder="{{ translate('Search Here') }}..."
                                name="search_key">
                        </label>
                    </div>
                    <!-- FILTER ITEM -->
                    <div class="bg-primary-50 rounded-none lg:rounded-xl mt-5">
                        <div class="flex-center-between p-6">
                            <h6 class="area-title text-xl !leading-none"> {{ translate('Categories') }} </h6>
                        </div>
                        <x-theme::blog.blog-category />
                    </div>
                </form>
                <!-- FILTER ITEM -->
                @php
                    $blogs = latestBlogs();
                @endphp

                <x-theme::blog.latest-blog-two :latestBlogs="$blogs" />

                @if (isset($blog->blogCategories) && $blog->blogCategories->count() > 1)
                    <!-- FILTER ITEM -->
                    <div class="bg-primary-50 rounded-none lg:rounded-xl">
                        <div class="flex-center-between p-6">
                            <h6 class="area-title text-xl !leading-none">{{ translate('Tags') }} </h6>
                        </div>
                        <x-theme::tags.tag-list 
                            :blogCategories="$blog->blogCategories"
                            ulClass="p-6 pt-3 border-t border-border flex items-center gap-2.5 flex-wrap"
                            liClass="shrink-0" 
                        />
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
