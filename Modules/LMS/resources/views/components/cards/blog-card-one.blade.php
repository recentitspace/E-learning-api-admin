@if (!empty($blogs))
    @foreach ($blogs as $blog)
        @php
            $translations = parse_translation($blog);
            $title = $translations['title'] ?? $blog->title ?? '';
            $thumbnail =
                $blog->thumbnail && fileExists('lms/blogs', $blog->thumbnail) == true
                    ? asset("storage/lms/blogs/{$blog->thumbnail}")
                    : asset('lms/frontend/assets/images/450x300.svg');
        @endphp

        <div class="swiper-slide {{ $class ?? null }}">
            <div class="bg-primary-50 rounded-2xl p-5 h-full group/blog">
                <!-- BLOG THUMBNAIL -->
                <div class="relative aspect-video rounded-2xl overflow-hidden">
                    <div class="blog-thumb">
                        <img data-src="{{ $thumbnail }}" alt="Blog Thumbnail"
                            class="size-full object-cover group-hover/blog:scale-110 custom-transition">
                    </div>
                    <!-- badge -->
                    @if (isset($blog->blogCategories) && !empty($blog->blogCategories))
                        @foreach ($blog->blogCategories as $category)
                            @if($loop->first)
                                @php $categoryTranslations = parse_translation($category);  @endphp
                                <span
                                    class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 right-4 z-10">{{ $categoryTranslations['name'] ?? $category->name ?? '' }}</span>
                            @endif
                        @endforeach
                    @endif
                </div>
                <!-- BLOG CONTENT -->
                <div class="mt-6">
                    <div class="flex-center-between flex-wrap gap-1 pb-4 mb-6 border-b border-heading/10">
                        <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                            <i class="ri-user-line"></i>
                            @php
                                $admin = $blog->adminAuthor ?? null;
                                $author = $blog->author ?? null;
                            @endphp
                            @if ($admin)
                                <span>{{ $admin->name }}</span>
                            @else
                                @php
                                    $user = $author->userable ?? null;
                                    $name = $user->first_name ?? ($user->name ?? null);
                                @endphp
                                <span>{{ $name }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                            <i class="ri-calendar-2-line"></i>
                            <span>{{ customDateFormate($blog->created_at, format: 'd M Y') }}</span>
                        </div>
                        @if ($blog->comments->count() > 0)
                            <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                                <i class="ri-message-3-line"></i>
                                <span> {{ $blog->comments->count() }} {{ translate('Comments') }}</span>
                            </div>
                        @endif
                    </div>
                    <h6 class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                        <!-- title -->
                        <a href="{{ route('blog.detail', $blog->slug) }}" class="line-clamp-2" aria-label="Blog title">
                            {{ $title }}
                        </a>
                    </h6>
                    <a href="{{ route('blog.detail', $blog->slug) }}"
                        class="btn btn-sm text-heading dark:text-white group-hover/blog:text-primary font-medium custom-transition mt-6"
                        aria-label="View blog details">
                        {{ translate('View Detail') }}
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
@endif
