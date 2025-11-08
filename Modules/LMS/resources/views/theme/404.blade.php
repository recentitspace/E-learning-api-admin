<x-frontend-layout>
    <div class="w-screen h-screen main-content p-3">
        <div class="size-full flex-center flex-col max-w-screen-sm mx-auto">
            <img data-src="{{ asset('lms/frontend/assets/images/404.svg') }}" alt="404">
            <a href="{{ route('home.index') }}" aria-label="Go back to home"
                class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px] mt-10">
                <i class="ri-arrow-left-line"></i>
                {{ translate('Go Back Home') }}
            </a>
        </div>
    </div>
</x-frontend-layout>
