<div class="bg-white border border-border rounded-xl h-[400px] shadow-md">
    <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
        @if (isset($title))
            <h2 class="card-title"> {{ translate($title) }}</h2>
        @endif
        @if (isset($description))
            <p class="card-description">{{ translate($description) }}</p>
        @endif
        @if (isset($btn) && $btn == true)
            <a href="{{ $url ?? '#' }}" target="_blank" class="btn b-solid btn-primary-solid font-normal !bg-[#79b530] rounded-[5px] !px-6 mt-5" aria-label="Go to Link">
                {{ translate($btnText ?? 'Buy on CodeCanyon') }}
            </a>
        @endif
    </div>
</div>
