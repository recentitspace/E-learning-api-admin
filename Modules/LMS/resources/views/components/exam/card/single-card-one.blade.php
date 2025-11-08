@php
    $timeDuration = $cartType ?? null;
@endphp

<!-- Single Overview Card -->
<div class="col-span-full sm:col-span-6 md:col-span-4 xl:col-span-2">
    <div class="bg-primary-50 rounded-xl flex-center flex-col text-center py-12 px-4">
        <div class="size-14 rounded-50 flex-center bg-white border-[1.5px] border-border p-2">
            {!! $icon ?? '' !!}
        </div>
        <div class="area-title text-2xl !leading-none mt-5 {{ $timeDuration == 'time-duration' ? ' quiz-time' : '' }} {{ $class ?? '' }}"
            data-quiz-minute = "{{ $timeCount ?? '' }}">
            {!! $title ?? '' !!}
        </div>
        @if ($description ?? '')
            <p class="area-description text-sm mt-2"> {{ translate($description) }}</p>
        @endif

    </div>
</div>
