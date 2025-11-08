<ul class="{{ $ulClass ?? 'p-6 pt-3 border-t border-border flex items-center gap-2.5 flex-wrap' }}">
    @foreach ($blogCategories as $category)
        @if (!$loop->first)
            <li class="{{ $liClass ?? 'shrink-0' }}">
                <a href="{{ route('blog.list', ['category' => $category->id]) }}" aria-label="Category item"
                    class="badge badge-primary-outline b-outline rounded-full">
                    {{ $category->name }}
                </a>
            </li>
        @endif
    @endforeach
</ul>
