<div id="theme-preview-modal{{ $theme['id'] ?? null }}"
    class="fixed inset-0 z-modal flex-center !hidden bg-black bg-opacity-50 modal">
    <div
        class="modal-content bg-white dark:bg-dark-card-two rounded-lg shadow-lg w-full max-w-screen-lg transform transition-all duration-300 opacity-0 -translate-y-10 m-4">

        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-dark-border">
            <h2 class="text-xl font-semibold">{{ translate('Theme Preview') }}</h2>
            <button type="button"
                class="absolute top-3 end-2.5 text-gray-500 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center close-modal-btn">
                <i class="ri-close-line text-inherit"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="p-4 max-h-[80vh] overflow-auto">
            <div class="flex flex-col-reverse lg:flex-row gap-6">
                <div class="grow flex flex-col">
                    <h2 class="text-heading dark:text-white text-2xl">{{ $theme['name'] ?? '' }}</h2>
                    <div class="text-gray-500 dark:text-dark-text text-sm"> {{ translate('by') }}
                        <strong>{{ $theme['author'] ?? null }}</strong>
                    </div>
                    <p class="card-description mt-5">
                        {{ $theme['description'] }}
                    </p>

                    <div class="mt-auto flex items-center justify-end">

                        @if ($theme['is_installed'] && !$theme['is_activated'])
                            <form method="post" action="{{ route('theme.activate') }}">
                                @csrf
                                <input type="hidden" name="name" value="{{ $theme['name'] ?? $theme['slug'] }}" />
                                <input type="hidden" name="slug" value="{{ $theme['slug'] }}" />
                                <input type="hidden" name="id" value="{{ $theme['id'] }}" />
                                <div class="mt-auto flex items-center justify-end">
                                    <button class="btn b-solid btn-primary-solid btn-sm">
                                        {{ translate('Activate') }}</button>
                                </div>
                            </form>
                        @elseif($theme['is_activated'])
                            <button type="button" class="btn b-solid btn-primary-solid btn-sm" disabled>
                                {{ translate('Activated') }}
                            </button>
                        @else
                            <form method="post" action="{{ route('theme.install') }}">
                                @csrf
                                <input type="hidden" name="name" value="{{ $theme['name'] ?? $theme['slug'] }}" />
                                <input type="hidden" name="slug" value="{{ $theme['slug'] }}" />
                                <button type="submit" class="btn b-solid btn-primary-solid btn-sm">
                                    {{ translate('Install') }} </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="relative theme-preview shrink-0 w-full lg:w-[60%] max-w-[1200px]">
                    <img src="{{ theme_asset($theme['slug'] . '/thumbnail.png') }}" alt="theme" class="">
                    <span class="absolute top-4 left-4">
                        <span
                            class="badge b-solid badge-primary-solid !bg-heading">{{ $theme['version'] ?? '' }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
