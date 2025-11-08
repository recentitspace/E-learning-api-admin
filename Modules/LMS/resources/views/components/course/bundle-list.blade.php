@if (count($bundles) > 0)
    <div class="grid grid-cols-12 gap-5 mt-10">
        @foreach ($bundles as $bundle)
            <x-theme::cards.bundle-card-one :bundle="$bundle" />
        @endforeach
    </div>
@else
    <x-theme::cards.empty btnAction="{{ route('course.list') }}" title="No Bundle" />
@endif
{!! $bundles->links('theme::pagination.pagination-one') !!}
