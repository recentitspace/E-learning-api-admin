@php
    $blog = $blog ?? null;
    $translations = [];
    if ($blog) {
        $translations = parse_translation($blog);
    }
    $title = $translations['title'] ?? $blog->title ?? '';
    $description = $translations['description'] ?? $blog->description ?? '';
    $thumbnail =
        $blog->thumbnail && fileExists('lms/blogs/', $blog->thumbnail) == true
            ? asset("storage/lms/blogs/{$blog->thumbnail}")
            : asset('lms/frontend/assets/images/450x300.svg');
@endphp
<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Blog Detail" pageRoute="{{ route('blog.list') }}"
        pageName="Blog Detail" />

    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <!-- START BLOG DETAILS CONTENT -->
            <div class="col-span-full lg:col-span-8">
                <div class="flex justify-end lg:hidden">
                    <button type="button" aria-label="Off-canvas drawer" data-offcanvas-id="blog-filter-drawer"
                        class="btn b-outline btn-secondary-outline">
                        <i class="ri-equalizer-line"></i>
                        {{ translate('Filter') }}
                    </button>
                </div>
                <div class="mt-6 lg:mt-0">
                    <div class="aspect-video rounded-xl overflow-hidden">
                        <img data-src="{{ $thumbnail }}" class="size-full object-cover"
                            alt="{{ translate('Blog thumbnail') }}">
                    </div>
                    <!-- BLOG META DATA -->
                    <div class="flex-center-between my-7">
                        <div class="flex items-center flex-wrap gap-x-5 gap-y-2">
                            <!-- category -->
                            @if (isset($blog->blogCategories) && !empty($blog->blogCategories))
                                @foreach ($blog->blogCategories as $category)
                                    @if ($loop->first)
                                        @php $categoryTranslations = parse_translation($category); @endphp
                                        <div class="badge b-solid badge-secondary-solid rounded-full !text-heading shrink-0">
                                            <a href="{{ route('blog.list', ['category' => $category->id]) }}"
                                                aria-label="Category link">
                                                {{ $categoryTranslations['name'] ?? $category->name ?? '' }}
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            <!-- date -->
                            <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                <i class="ri-calendar-2-line"></i>
                                <span>{{ customDateFormate($blog->created_at, format: 'd M Y') }}</span>
                            </div>
                            <!-- comment -->
                            <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                <i class="ri-message-3-line"></i>
                                <span> {{ $blog?->comments?->count() ?? 0 }} {{ translate('Comments') }}</span>
                            </div>
                        </div>

                    </div>
                    <div class="[&>:not(:first-child)]:mt-14">
                        <!-- DETAILS -->
                        <article class="blog-details-content">
                            <h3 class="area-title xl:text-[40px] mb-5">{{ $title }}</h3>
                            <div>
                                {!! clean($description) !!}
                            </div>
                        </article>
                        <!-- COMMENTS -->
                        <x-theme::comments.blog-comment :blog="$blog" />
                    </div>
                </div>
            </div>
            <!-- END BLOG DETAILS CONTENT -->

            <!-- START BLOG SIDEBAR -->
            <x-theme::blog.sidebar :blog="$blog" />
            <!-- END BLOG SIDEBAR -->
        </div>
    </div>

</x-frontend-layout>
