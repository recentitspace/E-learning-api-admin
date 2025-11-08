<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="Our Blogs" 
        pageRoute="{{ route('blog.list') }}"
        pageName="Blogs" 
    />
    <div class="container">
        @if ($blogs->count() > 0)
            <div class="grid grid-cols-12 gap-4 xl:gap-6">
                <x-theme::cards.blog-card-one :blogs="$blogs" class="col-span-full md:col-span-6 lg:col-span-4" />
            </div>
            {!! $blogs->links('theme::pagination.pagination-one') !!}
        @else
            <x-theme::cards.empty btnAction="{{ route('blog.list') }}" title="No Blog" />
        @endif
    </div>
</x-frontend-layout>
