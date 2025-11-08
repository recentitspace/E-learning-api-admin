@php
    if (!($blog && is_object($blog))) {
        return;
    }

    $author = $blog->adminAuthor ?? null;
    $user = null;

    if (!$author) {
        $author = $blog->author ?? null;
        $user = $author->userable ?? null;
    }
    $translations = parse_translation($blog);
    $title = $translations['title'] ?? $blog->title ?? '';
    $description = $translations['description'] ?? $blog->description ?? '';
    $thumbnail =
        $blog->thumbnail && fileExists('lms/blogs/', $blog->thumbnail)
            ? asset('storage/lms/blogs/' . $blog->thumbnail)
            : asset('lms/frontend/assets/images/450x300.svg');
    $commentsCount = $blog?->comments?->count() ?? 0;
    $commentsTitle = Str::plural('Comments', $commentsCount);

    $profileImg =
        $blog->adminAuthor && fileExists('lms/admins/', $author->profile_img)
            ? asset("storage/lms/admins/{$author->profile_img}")
            : asset('lms/assets/images/placeholder/profile.jpg');
@endphp

<div class="col-span-full lg:col-span-6">
    <div class="flex flex-col sm:flex-row items-center bg-white rounded-2xl overflow-hidden h-full custom-transition group/blog">
        <!-- BLOG THUMBNAIL -->
        <div class="relative aspect-video sm:aspect-square w-full sm:max-w-52 md:max-w-60 xl:max-w-64 overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}" alt="{{ 'Blog Thumbnail' }}"
                class="size-full object-cover group-hover/blog:scale-110 custom-transition">
        </div>
        <!-- BLOG CONTENT -->
        <div class="flex flex-col justify-center py-4 px-6 xl:px-8 border border-heading/15 border-t-0 sm:border-l-0 rtl:sm:border-l rtl:sm:border-r-0 sm:border-t rounded-b-2xl sm:rounded-r-2xl rtl:sm:rounded-r-0 rtl:sm:rounded-l-2xl sm:rounded-l-none rtl:sm:rounded-r-none h-full grow">
            <h6 class="area-title font-bold !text-xl group-hover/blog:text-primary custom-transition">
                <a href="{{ route('blog.detail', $blog->slug) }}" aria-label="Blog details link"
                    class="line-clamp-2">
                    {{ $title }}
                </a>
            </h6>
            <div class="area-description line-clamp-2 mt-2">
                {!! clean($description) !!}
            </div>
            <div class="flex items-center flex-wrap gap-1 mt-6">
                <div class="badge b-solid badge-secondary-solid rounded-full !text-heading h-7 shrink-0">
                    <i class="ri-calendar-2-line"></i>
                    <span
                        class="text-[14px] font-semibold">{{ customDateFormate($blog->created_at, format: 'd M Y') }}</span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-message-3-line"></i>
                    <span>{{ $commentsCount }} {{ translate($commentsTitle) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
