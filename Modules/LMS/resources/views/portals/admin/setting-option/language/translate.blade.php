<x-dashboard-layout>
    <div class="card overflow-hidden">
        <a href="{{ route('site.language') }}"
            class="size-7 flex-center bg-gray-200 dark:bg-dark-icon rounded-sm dk-theme-card-square">
            <i class="ri-arrow-left-line text-[18px]"></i>
        </a>
        <x-slot:title>{{ translate('Language Manage') }}</x-slot:title>
        <div class="flex items-center justify-end gap-4">
            <form method="GET" class="sm:block" id="change-translate-language">
                <select onchange="window.location.href=this.options[this.selectedIndex].value" name="id"
                    class="text-gray-500 dark:text-dark-text font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                    @foreach (app('languages') as $lang)
                        <option value="{{ $lang->id }}" {{ request()->id == $lang->id ? 'selected' : '' }}>
                            {{ $lang->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <form method="GET">
                <div class="flex items-center justify-end gap-2">
                    <div
                        class="w-56 md:w-72 leading-none text-sm relative text-gray-900 dark:text-dark-text hidden sm:block">
                        <span class="absolute top-1/2 -translate-y-[40%] left-3.5">
                            <i class="ri-search-line text-gray-900 dark:text-dark-text text-[14px]"></i>
                        </span>
                        <input type="text" name="search" id="header-search"
                            placeholder="{{ translate('Search here') }} ..."
                            class="form-input border-gray-200 dark:border-dark-border pl-[36px] pr-12 py-4 rounded-full dk-theme-card-square">
                        <span
                            class="absolute top-1/2 -translate-y-[40%] right-4 hidden lg:flex lg:items-center lg:gap-0.5 select-none">
                            <i class="ri-command-line text-[12px]"></i><span>+</span><span>{{ translate('k') }}</span>
                        </span>
                    </div>
                    <button type="submit" class="btn b-solid btn-primary-solid">
                        {{ translate('Search') }}
                    </button>
                </div>
            </form>
        </div>


        <form action="{{ route('translate.store', $language->id) }}" method="POST">
            @csrf

            <div class="overflow-x-auto">
                <table
                    class="table-auto border-collapse w-full text-wrap whitespace-nowrap text-left text-gray-500 dark:text-dark-text text-sm leading-none">
                    <thead>
                        <tr>
                            <th class="px-3 py-2 w-10">#</th>
                            <th class="px-3 py-2 w-1/2">{{ translate('Key') }}</th>
                            <th class="px-3 py-2">{{ translate('Value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($langKeys as $key => $translation)
                            <tr>
                                <td class="px-3 py-2" data-label="Serial">
                                    {{ ($langKeys->currentpage() - 1) * $langKeys->perpage() + $key + 1 }}
                                </td>
                                <td class="px-3 py-2" data-label="Lang_Key">{{ $translation->lang_value }}</td>
                                <td class="px-3 py-2" data-label="Value">
                                    <input type="text" class="form-input w-full"
                                        name="values[{{ $translation->lang_key }}]"
                                        value="{{ translate_value($language->code, $translation->lang_key) }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="justify-content-center">
                    {{ $langKeys->appends(['search' => $searchKey])->links('portal::admin.pagination.paginate') }}
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid w-max mt-5">
                    {{ translate('Save') }}
                </button>
            </div>
        </form>
    </div>
</x-dashboard-layout>
