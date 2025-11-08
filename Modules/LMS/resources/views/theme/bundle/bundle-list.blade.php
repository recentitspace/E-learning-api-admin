<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Our Bundles" pageRoute="{{ route('bundle.list') }}"
        pageName="Bundle" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-4 xl:gap-7">
            @foreach ($bundles as $bundle)
                <div class="col-span-full md:col-span-6 lg:col-span-4">
                    <x-theme::cards.bundle.card-one :bundle="$bundle" borderClass="true" />
                </div>
            @endforeach
        </div>
        <!-- END CONTENT -->
    </div>
</x-frontend-layout>
