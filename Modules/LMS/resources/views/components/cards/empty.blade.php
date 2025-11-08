<div class="bg-white border border-border rounded-xl h-[300px] shadow-md mt-5">
    <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
        @if ($title ?? '')
            <h2 class="area-title"> {{ translate($title) }}</h2>
        @endif
        @if (isset($description))
            <p class="area-description">{{ translate($description) }}</p>
        @endif

        @if (isset($btn) && $btn == true)
            <a href="{{ $btnAction ?? route('home.index') }}" class="btn b-solid btn-info-solid" aria-label="Go to home">
                {{ translate($btntext ?? 'Home') }}</a>
        @endif
    </div>
</div>
