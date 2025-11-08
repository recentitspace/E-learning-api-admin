<ul class="p-6 pt-3 border-t border-border">
    @foreach (get_all_blog_category(status: 1) as $blogCategory)
        @php
            $categoryTranslations = parse_translation($blogCategory);
        @endphp
        <li class="py-2">
            <a class="text-heading dark:text-white font-medium leading-none"
                href="{{ route('blog.list', ['category' => $blogCategory->id]) }}">{{ $categoryTranslations['name'] ?? $blogCategory->name }}</a>
        </li>
    @endforeach
</ul>
