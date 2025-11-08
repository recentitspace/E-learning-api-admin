@php 
    $general = get_theme_option(key: 'general') ?? []; 
@endphp

<div class="bg-primary py-3 hidden md:block">
    <div class="container">
        <div class="flex items-center justify-start">
            <div class="flex items-center gap-5">
                @if (isset($general['email']))
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="12" viewBox="0 0 17 12" fill="none">
                            <path d="M2.5 0H14.5C15.325 0 16 0.675 16 1.5V10.5C16 11.325 15.325 12 14.5 12H2.5C1.675 12 1 11.325 1 10.5V1.5C1 0.675 1.675 0 2.5 0Z" fill="white" />
                            <path d="M15.5713 1.71411L8.49989 6.74983L1.42847 1.71411" stroke="#5F3EED" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="round" />
                        </svg>
                        <a href="mailto:{{ $general['email'] }}" aria-label="Contact mail" class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
                            {{ $general['email'] }}
                        </a>
                    </div>
                @endif
                @if (isset($general['phone']))
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" class="rtl:rotate-[270deg]">
                            <path d="M13.9718 10.4817V12.5893C13.9726 12.7849 13.9325 12.9786 13.8542 13.1578C13.7758 13.3371 13.6608 13.498 13.5167 13.6303C13.3725 13.7626 13.2023 13.8633 13.0169 13.9259C12.8316 13.9886 12.6352 14.0119 12.4403 13.9943C10.2786 13.7594 8.20202 13.0207 6.37757 11.8376C4.68016 10.7589 3.24105 9.31984 2.16244 7.62243C0.975167 5.78969 0.2363 3.70306 0.00570216 1.53156C-0.0118535 1.33729 0.0112345 1.1415 0.0734958 0.956639C0.135757 0.77178 0.235828 0.601911 0.367336 0.457846C0.498845 0.313781 0.65891 0.198678 0.837341 0.119863C1.01577 0.0410494 1.20866 0.000251806 1.40372 6.81111e-05H3.51128C3.85222 -0.00328744 4.18275 0.117444 4.44126 0.33976C4.69976 0.562076 4.86861 0.870806 4.91633 1.20841C5.00528 1.88287 5.17025 2.54511 5.40809 3.18249C5.50261 3.43394 5.52307 3.70721 5.46704 3.96993C5.41101 4.23265 5.28084 4.4738 5.09196 4.66481L4.19976 5.55701C5.19983 7.31581 6.65609 8.77206 8.41489 9.77214L9.30709 8.87994C9.4981 8.69106 9.73925 8.56089 10.002 8.50486C10.2647 8.44883 10.538 8.46929 10.7894 8.56381C11.4268 8.80164 12.089 8.96662 12.7635 9.05557C13.1048 9.10371 13.4164 9.2756 13.6392 9.53855C13.862 9.8015 13.9804 10.1372 13.9718 10.4817Z" fill="white" />
                        </svg>
                        <a href="tel:+{{ $general['phone'] }}" aria-label="Contact phone" class="text-sm !leading-none font-semibold text-white/80 hover:text-white custom-transition">
                            {{ translate('Call') }}:
                            {{ $general['phone'] }}
                        </a>
                    </div>
                @endif
            </div>
            @if (count(app('languages')) > 0)
                <div class="flex items-center justify-end [&>:not(:first-child)]:pl-5 grow">
                    <form method="get" action="{{ route('language.set') }}" id="language-form">
                        @csrf
                        <input type="hidden" name="admin_id" value="{{ auth('admin')->check() ? auth('admin')->user()->id : null }}">
                        <input type="hidden" name="user_id" value="{{ auth()->check() ? auth()->user()->id : null }}">
                        <select 
                            name="locale" 
                            aria-label="Choose Language"
                            onchange="event.preventDefault();
                            document.getElementById('language-form').submit();"
                            class="text-white *:text-heading dark:text-white font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm p-1"
                        >
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
