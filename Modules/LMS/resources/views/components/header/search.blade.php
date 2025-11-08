<form action="{{ route('course.list') }}" class="hidden xl:block shrink-0" method="GET">
    <input type="search" class="form-input {{ $class['input'] ?? ' rounded-full' }}" name="q"
        placeholder="{{ translate('Search') }}...">
</form>
