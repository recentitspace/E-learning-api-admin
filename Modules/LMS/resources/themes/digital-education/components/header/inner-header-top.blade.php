<div class="py-3.5 hidden lg:block group-[.sticky]/header:hidden">
    <div class="flex-center-between gap-2 flex-wrap">
        <div class="flex items-center justify-start space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
            <p class="area-description text-sm text-white/80">
                {{ translate('New Students') }} :
                <a href="all-course.html" class="text-primary">{{ translate('Save up to 35') }}%</a>
            </p>
        </div>
        <div class="flex items-center justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
            <div class="flex items-center">
                @if (count(app('languages')) > 0)
                    <div class="flex items-center">
                        <form method="get" action="{{ route('language.set') }}" id="language-form">
                            @csrf
                            <input type="hidden" name="admin_id"
                                value="{{ auth('admin')->check() ? auth('admin')->user()->id : null }}">
                            <input type="hidden" name="user_id"
                                value="{{ auth()->check() ? auth()->user()->id : null }}">
                            <select name="locale" aria-label="Choose Language"
                                onchange="event.preventDefault();
                            document.getElementById('language-form').submit();"
                                class="text-white *:text-heading font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm bg-heading">
                                @foreach (app('languages') as $language)
                                    <option value="{{ $language->code }}"
                                        {{ app()->getLocale() == $language->code ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
