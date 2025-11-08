<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="{{ translate('Categories') }}" 
        ageRoute="{{ route('category.list') }}"
        pageName="{{ translate('Categories') }}" 
    />
    <div class="container">
        <div class="grid grid-cols-12 gap-4 xl:gap-6">
            @foreach ($categories as $category)
                <x-theme::cards.category.card-one :category="$category" class="col-span-full md:col-span-6 lg:col-span-4" />
            @endforeach
        </div>
        {!! $categories->links('theme::pagination.pagination-one') !!}
    </div>
</x-frontend-layout>
