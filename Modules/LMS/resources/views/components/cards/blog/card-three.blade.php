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
    $title = $translations['title'] ?? ($blog->title ?? '');
    $description = $translations['description'] ?? ($blog->description ?? '');
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

<!-- BLOG CARD -->
<div class="swiper-slide mb-1">
    <div class="flex flex-col bg-white rounded-xl h-full custom-transition overflow-hidden hover:shadow-md group/blog">
        <!-- BLOG THUMBNAIL -->
        <div class="relative aspect-[1.8] overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}" alt="{{ translate('Blog Thumbnail') }}"
                class="size-full object-cover group-hover/blog:scale-110 custom-transition" />
        </div>
        <!-- BLOG CONTENT -->
        <div class="px-5 py-6 border border-border border-t-0 rounded-b-xl grow">
            @if (isset($blog->blogCategories) && !empty($blog->blogCategories))
                @foreach ($blog->blogCategories as $category)
                    @if ($loop->first)
                        @php $categoryTranslations = parse_translation($category);  @endphp
                        <div class="badge b-solid badge-primary-solid font-bold">
                            {{ $categoryTranslations['name'] ?? ($category->name ?? '') }}</div>
                    @endif
                @endforeach
            @endif
            <h6 class="area-title font-bold !text-xl mt-3 group-hover/blog:text-primary custom-transition">
                <a href="{{ route('blog.detail', $blog->slug) }}" class="line-clamp-2"
                    aria-label="Blog Detail Link">
                    {{ $title }}
                </a>
            </h6>
            <div class="area-description line-clamp-2 mt-2">
                {!! clean($description) !!}
            </div>
            <div class="flex-center-between gap-1 flex-wrap pt-4 mt-6 border-t border-heading/10">
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-user-line"></i>
                    <span> {{ $author->first_name ?? ($author->name ?? ($user->name ?? '')) }} </span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-calendar-2-line"></i>
                    <span>
                        {{ customDateFormate($blog->created_at, format: 'd M Y') }}
                    </span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-message-3-line"></i>
                    <span>{{ $commentsCount }} {{ translate('Comments') }} </span>
                </div>
            </div>
        </div>
    </div>
</div>
