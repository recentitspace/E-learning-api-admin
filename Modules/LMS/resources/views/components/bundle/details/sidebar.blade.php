@php
    $thumbnail =
        $bundle->thumbnail && fileExists('lms/courses/bundles', $bundle->thumbnail) == true
            ? asset("storage/lms/courses/bundles/{$bundle->thumbnail}")
            : asset('lms/frontend/assets/images/420x252.svg');
    $currency = $bundle?->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp
<div class="col-span-full lg:col-span-4">
    <div class="bg-primary-50 p-6 rounded-2xl">
        <div data-modal-id="demo-video-modal"
            class="flex-center relative cursor-pointer w-full aspect-video rounded-2xl overflow-hidden">
            <img data-src="{{ $thumbnail }}" alt="Course thumbnail" class="size-full object-cover">
            <!-- CONTROLLER -->
            <div class="flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                <button type="button" aria-label="Open demo video modal button"
                    class="btn-icon size-9 b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                    <i class="ri-play-fill text-base"></i>
                </button>
            </div>
        </div>
        <table class="w-full mt-7">
            <caption class="area-title text-xl text-left rtl:text-right"> {{ translate('This Bundle Includes') }}:
            </caption>
            <tbody class="divide-y divide-border mt-1">
                <tr>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">{{ $bundle->duration }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <i class="ri-bar-chart-2-line"></i>
                            <span class="text-heading dark:text-white mb-0.5">
                                {{ translate('Bundle Level') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">
                            @foreach ($bundle->levels as $level)
                                @php $levelTranslations = parse_translation($level); @endphp
                                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
                                @if (!$loop->first)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <i class="ri-book-line"></i>
                            <span class="text-heading dark:text-white mb-0.5">
                                {{ translate('Total Course') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">
                            {{ count($bundle?->courses) }}
                        </div>
                    </td>
                </tr>
                @if ($bundle?->is_certificate)
                    <tr>
                        <td class="px-1 py-4 text-left rtl:text-right">
                            <div
                                class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                <i class="ri-award-line"></i>
                                <span class="text-heading dark:text-white mb-0.5">
                                    {{ translate('Certificate') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-1 py-4 text-right rtl:text-left">
                            <div class="text-heading dark:text-white font-semibold leading-none">
                                {{ translate('Yes') }}
                            </div>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <span class="text-heading dark:text-white text-lg font-bold mb-0.5">
                                {{ translate('Price') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div
                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center justify-end gap-1.5">
                            <span>{{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        @if (!$hasPurchase)
            @auth
                <button type="button" aria-label="Enroll the bundle"
                    class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12 add-to-cart"
                    data-course-id="{{ $bundle->id }}" data-type="bundle">
                    {{ translate('Add To Cart') }}
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                </button>
            @endauth
            @guest
                <a href="{{ route('login') }}"
                    class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full w-full font-medium">
                    {{ translate('Add To Cart') }}
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                </a>
            @endguest
        @else
            <button type="button" aria-label="Enroll the bundle"
                class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12 disabled"
                data-bundle-id="{{ $bundle->id }}" data-type="bundle">
                {{ translate('purchased') }}

            </button>
        @endif
    </div>
</div>
<!-- START DEMO VIDEO MODAL -->
<x-theme::bundle.details.demo-video :bundle="$bundle" />
<!-- END DEMO VIDEO MODAL -->
