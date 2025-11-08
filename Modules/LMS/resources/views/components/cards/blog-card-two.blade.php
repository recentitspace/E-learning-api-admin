{{-- <ul class="p-6 pt-3 border-t border-border [&>:not(:first-child)]:mt-5 [&>:not(:first-child)]:pt-5 [&>:not(:first-child)]:border-t [&>:not(:first-child)]:border-border">
    @foreach ($latestBlogs as $blog)
        @php
            $translations = parse_translation($blog);
            $title = $translations['title'] ?? $blog->title ?? '';
            $thumbnail =
                $blog->thumbnail && fileExists('lms/blogs/', $blog->thumbnail) == true
                    ? asset("storage/lms/blogs/{$blog->thumbnail}")
                    : asset('lms/frontend/assets/images/450x300.svg');
        @endphp
        <li class="flex items-center gap-2.5">
            <a href="{{ route('blog.detail', $blog->slug) }}" class="size-20 rounded-50 overflow-hidden shrink-0"
                aria-label="Blog thumbnail image">
                <img data-src="{{ $thumbnail }}" alt="Blog thumbnail" class="size-full object-cover">
            </a>
            <div class="grow">
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-calendar-2-line"></i>
                    <span>{{ customDateFormate($blog->created_at, format: 'd M Y') }}</span>
                </div>
                <h6 class="area-title !text-base font-bold line-clamp-2 mt-2">
                    <a href="{{ route('blog.detail', $blog->slug) }}" aria-label="Blog title">
                        {{ $title }}
                    </a>
                </h6>
            </div>
        </li>
    @endforeach
</ul> --}}
