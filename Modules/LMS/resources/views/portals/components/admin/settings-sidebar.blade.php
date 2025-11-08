<div id="app-settings-sidebar" class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[999]">
    <div class="app-settings-sidebar-inner fixed inset-0 left-auto right-0 rtl:right-auto rtl:left-0 bg-white dark:bg-dark-card-two w-80 sm:w-96 translate-x-full rtl:-translate-x-full duration-300 z-[1000]">
        <!-- CLOSE MENU -->
        <button type="button" class="app-settings-sidebar-close size-11 flex-center bg-white dark:bg-dark-card-two absolute top-8 right-full rtl:right-auto rtl:left-full duration-300">
            <i class="ri-close-line text-gray-500 dark:text-dark-text"></i>
        </button>
        <div class="flex flex-col h-full">
            <div class="p-6 py-3 border-b border-gray-200 dark:border-dark-border-four">
                <h6 class="text-lg font-medium text-gray-500 dark:text-dark-text">
                    {{ translate('Adjust Configurations') }}</h6>
                <p class="text-sm text-gray-700 dark:text-dark-text mt-1">
                    {{ translate('Transform your space to reflect your personality!') }}
                </p>
            </div>
            <!-- Customization Options -->
            <div data-scrollbar class="p-6 pt-3">
                <div class="divide-y divide-input-border/50 dark:divide-dark-border-four space-y-10">
                    <!-- Theme Mode -->
                    <div class="pt-3 first:pt-0">
                        <h6 class="card-title text-base font-medium">{{ translate('Theme Appearance') }}</h6>
                        <div class="grid grid-cols-6 gap-4 mt-2">
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Light') }}</label>
                                <label for="radioThemeLight"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-sun-line text-inherit text-xl"></i>
                                    <input name="radioThemeMode" type="radio" id="radioThemeLight" hidden checked
                                        onchange="toggleThemeMode()">
                                </label>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Dark') }}</label>
                                <label for="radioThemeDark"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-moon-clear-line text-inherit text-xl"></i>
                                    <input name="radioThemeMode" type="radio" id="radioThemeDark" hidden
                                        onchange="toggleThemeMode()">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Theme Card Style -->
                    <div class="pt-3 first:pt-0">
                        <h6 class="card-title text-base font-medium">{{ translate('Theme Card Style') }}</h6>
                        <div class="grid grid-cols-6 gap-4 mt-2">
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Round') }}</label>
                                <label for="radioThemeCardRound"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-rounded-corner text-inherit text-xl"></i>
                                    <input name="radioThemeCardStyle" type="radio" id="radioThemeCardRound" hidden
                                        checked onchange="toggleCardStyle()">
                                </label>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Square') }}</label>
                                <label for="radioThemeCardSquare"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-square-line text-inherit text-xl"></i>
                                    <input name="radioThemeCardStyle" type="radio" id="radioThemeCardSquare" hidden
                                        onchange="toggleCardStyle()">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Theme Width -->
                    <div class="pt-3 first:pt-0">
                        <h6 class="card-title text-base font-medium">{{ translate('Theme Layout Width') }}</h6>
                        <div class="grid grid-cols-6 gap-4 mt-2">
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Full Width') }}</label>
                                <label for="radioThemeWidthFluid"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-fullscreen-fill text-inherit text-xl"></i>
                                    <input name="radioThemeWidth" type="radio" id="radioThemeWidthFluid" hidden
                                        checked onchange="settingThemeWidth()">
                                </label>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="text-xs text-gray-500 dark:text-dark-text-two font-medium mb-1.5 inline-block">{{ translate('Container') }}</label>
                                <label for="radioThemeWidthBox"
                                    class="h-13 text-gray-500 dark:text-dark-text-two dk-border-one !border-2 hover:border-input-border dark:hover:border-dark-border-five rounded-lg dk-theme-card-square flex-center py-2 select-none cursor-pointer has-[:checked]:hover:border-primary has-[:checked]:border-primary leading-none duration-300">
                                    <i class="ri-exchange-box-line text-inherit text-xl"></i>
                                    <input name="radioThemeWidth" type="radio" id="radioThemeWidthBox" hidden
                                        onchange="settingThemeWidth()">
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Reset All Customization -->
            <div class="flex items-center justify-end p-3 bg-gray-200 dark:bg-dark-icon mt-auto">
                <button type="reset" class="btn b-solid btn-danger-solid btn-sm"
                    onclick="resetThemeConfig()">{{ translate('Reset') }}</button>
            </div>
        </div>
    </div>
</div>
