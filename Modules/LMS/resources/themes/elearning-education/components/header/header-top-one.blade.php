<div class="bg-[#1B253A] py-3.5 hidden md:block">
    <div class="max-w-[1600px] mx-auto px-[12px]">
        <div class="flex-center-between">
            <div class="flex items-center justify-start space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
                <p class="area-description text-sm text-white/80">
                    {{ translate( 'New members: get your first 15 days of tutor Premium for free!' ) }}
                    <a href="{{ route('course.list') }}" aria-label="Discount course link" class="text-secondary">{{ translate( 'Unlock discount now' ) }}!</a>
                </p>
            </div>
            <div class="flex items-center justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
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
                                class="text-white *:text-heading dark:text-white font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm bg-heading">
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
