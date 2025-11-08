<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Theme') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Theme" page-to="Theme" />
    <!-- Start Main Content -->
    <div class="grid grid-cols-12 gap-x-4">
        <!-- Themes -->
        <div class="col-span-full">
            <div class="card p-4 md:p-6">
                <div class="grid grid-cols-12 gap-4">
                    @if (is_array($themes) && count($themes) > 0)
                        @foreach ($themes as $theme)
                            <!-- Single Theme 01 -->
                            <div class="col-span-full lg:col-span-6 3xl:col-span-4">
                                <div
                                    class="relative bg-[#F7F4FF] dark:bg-dark-card-shade p-6 pt-10 dk-border-one rounded-10 dk-theme-card-square group/theme {{ $theme['is_activated'] ? 'active' : '' }}">
                                    <span class="absolute top-4 left-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="9"
                                            viewBox="0 0 35 9" fill="none">
                                            <circle cx="4.28516" cy="4.26611" r="4" fill="#E8504B" />
                                            <circle cx="17.6172" cy="4.26611" r="4" fill="#F1B12D" />
                                            <circle cx="30.9531" cy="4.26611" r="4" fill="#2ACC38" />
                                        </svg>
                                    </span>
                                    <div class="absolute top-2 left-1/2 -translate-x-1/2">
                                        <h6 class="card-title text-base text-primary-600 uppercase">
                                            {{ $theme['name'] ?? $theme['slug'] }}
                                        </h6>
                                    </div>
                                    <div class="flex flex-col gap-7">
                                        <div data-modal-id="theme-preview-modal{{ $theme['id'] ?? null }}"
                                            class="min-h-[200px] relative before:absolute before:size-full before:inset-0 before:bg-black/20 before:z-[1] before:translate-y-5 before:invisible before:opacity-0 group-hover/theme:before:visible group-hover/theme:before:opacity-100 group-hover/theme:before:translate-y-0 before:duration-300 overflow-hidden cursor-pointer">
                                            <img src="{{ theme_asset($theme['slug'] . '/thumbnail.png') }}"
                                                alt="theme" class="self-start">
                                            <div
                                                class="position-center z-[2] invisible opacity-0 translate-y-5 group-hover/theme:visible group-hover/theme:opacity-100 group-hover/theme:translate-y-0 duration-300">
                                                <button class="btn b-solid btn-primary-solid rounded-md">
                                                    {{ translate('Preview') }}
                                                </button>
                                            </div>
                                        </div>
                                        @if ($theme['is_installed'] && !$theme['is_activated'])
                                            <form method="post" action="{{ route('theme.activate') }}">
                                                @csrf
                                                <input type="hidden" name="name"
                                                    value="{{ $theme['name'] ?? $theme['slug'] }}" />
                                                <input type="hidden" name="slug" value="{{ $theme['slug'] }}" />
                                                <input type="hidden" name="id" value="{{ $theme['id'] }}" />

                                                <button type="submit"
                                                    class="btn b-outline btn-primary-outline w-full text-gray-500 dark:text-dark-text hover:!text-white group-[.active]/theme:bg-primary-600 group-[.active]theme:!text-white">
                                                    {{ translate('Activate') }} </button>
                                            </form>
                                        @elseif($theme['is_activated'])
                                            <button type="button"
                                                class="btn b-outline btn-primary-outline w-full text-gray-500 dark:text-dark-text hover:!text-white group-[.active]/theme:bg-primary-600 group-[.active]/theme:!text-white"
                                                disabled>
                                                {{ translate('Activated') }}
                                            </button>
                                        @else
                                            <form method="post" action="{{ route('theme.install') }}">
                                                @csrf
                                                <input type="hidden" name="name"
                                                    value="{{ $theme['name'] ?? $theme['slug'] }}" />
                                                <input type="hidden" name="slug" value="{{ $theme['slug'] }}" />
                                                <button type="submit"
                                                    class="btn b-outline btn-primary-outline w-full text-gray-500 dark:text-dark-text hover:!text-white group-[.active]/theme:bg-primary-600 group-[.active]/theme:!text-white">
                                                    {{ translate('Install') }} </button>
                                            </form>
                                        @endif
                                    </div>
                                    <x-portal::theme.preview :theme="$theme"></x-portal::theme.preview>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- Theme Preview Modal -->
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/modal.js') }}"></script>
    @endpush
</x-dashboard-layout>
