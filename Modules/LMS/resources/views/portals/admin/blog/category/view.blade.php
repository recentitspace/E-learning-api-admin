<x-dashboard-layout>
    <x-slot:title>
        {{ translate('View Blog Category') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('blog.category.index') }}" title="View" page-to="Category" />
    <div class="grid grid-cols-12 card">
        <div class="col-span-full md:col-span-6">
            <label for="name" class="form-label">{{ translate('Name') }} :</label>
            {{ $category->name }}
        </div>
    </div>
</x-dashboard-layout>
