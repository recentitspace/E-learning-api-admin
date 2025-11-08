<!-- BLOG CARD -->
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
    $thumbnail =
        $blog->thumbnail && fileExists('lms/blogs/', $blog->thumbnail)
            ? asset('storage/lms/blogs/' . $blog->thumbnail)
            : asset('lms/frontend/assets/images/450x300.svg');
    $commentsCount = $blog?->comments?->count() ?? 0;
    $commentsTitle = Str::plural('Comments', $commentsCount);

    $profileImg =
        $blog->adminAuthor && fileExists('lms/admins/', $author->profile_img)
            ? asset('storage/lms/admins/' . $author->profile_img)
            : asset('lms/assets/images/placeholder/profile.jpg');
@endphp
<div class="swiper-slide">
    <div class="flex flex-col bg-white custom-transition h-full group/blog">
        <!-- BLOG THUMBNAIL -->
        <div class="relative aspect-[1.64] overflow-hidden shrink-0">
            <div class="blog-thumb">
                <img data-src="{{ $thumbnail }}" alt="Blog Thumbnail"
                    class="size-full object-cover group-hover/blog:scale-110 custom-transition">
            </div>
        </div>
        <!-- BLOG CONTENT -->
        <div class="px-5 py-6 pb-10 border border-border border-t-0 grow">
            <div class="flex items-center gap-4 pb-4 mb-6 border-b border-heading/10">
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-user-line"></i>
                    {{ $author->first_name ?? ($author->name ?? ($user->name ?? '')) }}
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-calendar-2-line"></i>
                    <span>{{ customDateFormate($blog->created_at, format: 'd M Y') }}</span>
                </div>
            </div>
            <h6 class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                <a href="{{ route('blog.detail', $blog->slug) }}" aria-label="Blog Details link" class="line-clamp-2">
                    {{ $title }}
                </a>
            </h6>
        </div>
    </div>
</div>
