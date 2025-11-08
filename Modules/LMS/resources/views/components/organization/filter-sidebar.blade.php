@php
    $timeZones = get_all_zones('organization');
    $languages = get_all_language('organization');
@endphp
<div class="col-span-full lg:col-span-4">
    <div id="org-filter-drawer"
        class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[99] lg:bg-transparent lg:relative lg:visible lg:opacity-100 lg:z-auto">
        <div
            class="org-filter-drawer-inner bg-white fixed inset-0 left-auto right-0 py-4 w-64 sm:w-80 translate-x-full duration-300 z-[100] lg:relative lg:right-auto lg:py-0 lg:w-full lg:translate-x-0 lg:z-auto">
            <!-- CLOSE DRAWER -->
            <button type="button" aria-label="Drawer close"
                class="org-filter-drawer-close size-11 flex-center lg:hidden bg-white border border-transparent hover:border-primary absolute top-4 right-full custom-transition">
                <i class="ri-close-line text-gray-500 dark:text-dark-text"></i>
            </button>
            <div class="flex flex-col gap-5 max-h-screen lg:max-h-full overflow-auto">
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 p-6 rounded-none lg:rounded-xl lms-accordion">
                    <form>
                        <label for="search-filter" class="relative flex">
                            <span class="text-heading/60 absolute top-1/2 -translate-y-1/2 left-4 z-[1]"><i
                                    class="ri-search-2-line"></i></span>
                            <input type="search" id="search_title" name="search"
                                placeholder="{{ translate('Search Here') }}..."
                                class="form-input text-heading/60 h-12 pl-10 bg-white search-keyword">
                        </label>
                    </form>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Time Zone') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($timeZones->count() > 0)
                            @foreach ($timeZones as $timeZone)
                                <li class="flex items-center gap-2.5">
                                    <label class="flex items-start gap-px cursor-pointer py-2.5 select-none">
                                        <input type="checkbox" value=" {{ $timeZone->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option timeZone">
                                        <span class="text-heading dark:text-white font-medium leading-none">
                                            {{ $timeZone->name }}
                                        </span>
                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li> {{ translate('No Time Zone') }} </li>
                        @endif
                    </ul>
                </div>
                <!-- FILTER ITEM -->
                <div class="bg-primary-50 rounded-none lg:rounded-xl lms-accordion">
                    <div
                        class="flex-center-between p-6 cursor-pointer lms-accordion-button panel-show group/accordion peer/accordion">
                        <h6 class="area-title text-xl !leading-none">
                            {{ translate('Language') }}
                        </h6>
                        <span class="group-[.panel-show]/accordion:-rotate-180">
                            <i class="ri-arrow-down-s-line"></i>
                        </span>
                    </div>
                    <ul
                        class="p-6 pt-3 border-t border-border lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        @if ($languages->count() > 0)
                            @foreach ($languages as $language)
                                @php
                                    $languageTranslations = parse_translation($language);
                                @endphp
                                <li class="flex items-center gap-2.5">
                                    <label class="flex items-start gap-px cursor-pointer py-2.5 select-none">
                                        <input type="checkbox" name="org_time_zone" value="{{ $language->id }}"
                                            class="checkbox checkbox-primary mr-2.5 rtl:mr-0 rtl:ml-2.5 filter-option language">
                                        <span
                                            class="text-heading dark:text-white font-medium leading-none">{{ $languageTranslations['name'] ?? $language->name }}</span>

                                    </label>
                                </li>
                            @endforeach
                        @else
                            <li> {{ translate('No Language') }} </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END FILTER SIDEBAR -->
