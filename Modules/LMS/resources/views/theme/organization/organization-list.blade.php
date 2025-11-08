@if (count($organizations) > 0)
    <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-10">
        @foreach ($organizations as $organization)
            <x-theme::cards.organization-card-one :organization="$organization" />
        @endforeach
    </div>
    {!! $organizations->links('theme::pagination.pagination-one') !!}
@else
    <x-theme::cards.empty title="No Organization" />
@endif
