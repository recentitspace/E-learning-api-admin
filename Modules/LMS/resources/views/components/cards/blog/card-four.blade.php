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
        $blog->adminAuthor && fileExists('lms/admins', $author->profile_img)
            ? asset('storage/lms/admins/' . $author->profile_img)
            : asset('lms/assets/images/placeholder/profile.jpg');
@endphp


<div class="swiper-slide">
    <div class="flex flex-col bg-white h-full custom-transition p-4 xl:p-6 rounded-2xl group/blog">
        <!-- BLOG THUMBNAIL -->
        <div class="relative aspect-[1.6] rounded-lg overflow-hidden shrink-0">
            <div class="blog-thumb">
                <img data-src="{{ $thumbnail }}" alt="Blog thumbnail"
                    class="size-full object-cover group-hover/blog:scale-110 custom-transition">
            </div>
        </div>
        <!-- BLOG CONTENT -->
        <div class="pt-6 pb-2 grow">
            <div class="flex items-center gap-4">
                @if (isset($blog->blogCategories) && !empty($blog->blogCategories))
                    @foreach ($blog->blogCategories as $category)
                        @if($loop->first)
                            @php $categoryTranslations = parse_translation($category);  @endphp
                            <div class="badge b-outline badge-secondary-outline">{{ $categoryTranslations['name'] ?? $category->name ?? '' }}</div>
                        @endif
                    @endforeach
                @endif
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-wechat-line"></i>
                    <span>{{ $commentsCount }} {{ translate($commentsTitle) }}</span>
                </div>
            </div>
            <h6 class="area-title font-bold !text-xl group-hover/blog:text-secondary mt-6 custom-transition">
                <a href="{{ route('blog.detail', $blog->slug) }}" aria-label="{{ 'Blog Details link' }}"
                    class="line-clamp-2">
                    {{ $title }}
                </a>
            </h6>
            <div class="card-description mt-3 text-heading/70 line-clamp-2">
                {!! clean($description) !!}
            </div>
            <div class="flex-center-between gap-4 pt-4 mt-6 border-t border-heading/10">
                <div class="flex items-center gap-2.5">
                    <div class="size-10 rounded-50 overflow-hidden shrink-0">
                        <img data-src="{{ $profileImg }}" alt="Thumbnail image" class="size-full object-cover">
                    </div>
                    <div class="grow">
                        <h6 class="area-title text-base lg:text-lg font-semibold !leading-none">
                            {{ $author->first_name ?? ($author->name ?? ($user->name ?? '')) }}</h6>
                        <p class="area-description text-sm !leading-none mt-1.5">
                            {{ customDateFormate($blog->created_at, format: 'd M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-eye-line"></i>
                    <span>{{ $blog->view ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
