@php
    $translations = [];
    $userInfo = $user?->userable;
    if ($userInfo) {
        $translations = parse_translation($userInfo);
    }

    $countryTranslations = parse_translation($userInfo?->country);
    $stateTranslations = parse_translation($userInfo?->state);
    $cityTranslations = parse_translation($userInfo?->city);
@endphp

<div class="grid grid-cols-12 gap-x-4">
    <!-- Start Account Setting Form -->
    <div class="col-span-full sm:col-span-6 xl:col-span-8">

        <!-- Basic Information -->
        <div class="card overflow-hidden">
            <div class="px-4 md:p-6 !py-2 bg-gray-200/30 dark:bg-dark-card-two">
                <h6 class="card-title text-lg">{{ translate('Basic Information') }}</h6>
            </div>
            <div class="p-3 md:p-6">
                <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                    @if ($user->guard == 'organization')
                        <div class="col-span-full xl:col-auto leading-none">
                            <h6 class="text-heading dark:text-white font-semibold">
                                {{ translate('Organization Name') }}:
                                <span class="font-normal text-gray-500 dark:text-dark-text">
                                    {{ $translations['name'] ?? $userInfo?->name }}
                                </span>
                            </h6>
                        </div>
                    @else
                        <div class="col-span-full xl:col-auto leading-none">
                            <h6 class="text-heading dark:text-white font-semibold">
                                {{ translate('Full Name') }}:
                                <span class="font-normal text-gray-500 dark:text-dark-text">
                                    {{ ($translations['first_name'] ?? $userInfo?->first_name) . ' ' . ($translations['last_name'] ?? $userInfo?->last_name) }}
                                </span>
                            </h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Biography -->
        <div class="card overflow-hidden">
            <div class="px-4 md:p-6 !py-2 bg-gray-200/30 dark:bg-dark-card-two">
                <h6 class="card-title text-lg">{{ translate('Biography') }}</h6>
            </div>
            <div class="p-3 md:p-6">
                <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                    <div class="col-span-full">
                        <h6 class="text-heading dark:text-white font-semibold">
                            {{ translate('Bio') }}:
                            <span class="font-normal text-gray-500 dark:text-dark-text">
                                {!! clean($translations['about'] ?? $userInfo?->about) !!}
                            </span>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- Address -->
        <div class="card overflow-hidden">
            <div class="px-4 md:p-6 !py-2 bg-gray-200/30 dark:bg-dark-card-two">
                <h6 class="card-title text-lg">{{ translate('Address') }}</h6>
            </div>
            <div class="p-3 md:p-6">
                <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                    <div class="col-span-full xl:col-auto leading-none">
                        <h6 class="text-heading dark:text-white font-semibold">
                            {{ translate('Country') }} :
                            <span class="font-normal text-gray-500 dark:text-dark-text">
                                {{ $countryTranslations['name'] ?? $userInfo?->country?->name }}
                            </span>
                        </h6>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <h6 class="text-heading dark:text-white font-semibold">
                            {{ translate('State') }}
                            <span class="font-normal text-gray-500 dark:text-dark-text">
                                {{ $stateTranslations['name'] ?? $userInfo?->state?->name }}
                            </span>
                        </h6>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <h6 class="text-heading dark:text-white font-semibold">
                            {{ translate('City') }} :
                            <span class="font-normal text-gray-500 dark:text-dark-text">
                                {{ $cityTranslations['name'] ?? $userInfo?->city?->name }}
                            </span>
                        </h6>
                    </div>

                    @if ($userInfo?->location)
                        <div class="col-span-full xl:col-auto leading-none">
                            <h6 class="text-heading dark:text-white font-semibold">
                                {{ translate('Address') }} :
                                <span class="font-normal text-gray-500 dark:text-dark-text">
                                    {{ $translations['location'] ?? $userInfo?->location }}
                                </span>
                            </h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if (isset($user->educations) && $user->educations->count() > 0)
            <div class="card overflow-hidden">
                <div class="px-4 md:p-6 !py-2 bg-gray-200/30 dark:bg-dark-card-two">
                    <div class="flex-center-between">
                        <h6 class="card-title text-lg">{{ translate('Education') }}</h6>
                    </div>
                </div>

                <div class="p-3 md:p-6">
                    <div class="overflow-x-auto scrollbar-table">
                        <table
                            class="table-auto border-collapse w-full whitespace-nowrap text-sm text-left text-gray-500 dark:text-dark-text font-medium">
                            <thead>
                                <tr class="text-primary-500">
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Institute') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Achievement') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Department') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Passing Year') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-gray-200 dark:divide-dark-border-three dark:divide-dark-border-three">
                                @foreach ($user->educations as $education)
                                    <tr>
                                        <td class="p-6 py-4">{{ $education->name ?? '' }}</td>
                                        <td class="p-6 py-4">{{ $education?->pivot?->degree ?? '' }}</td>
                                        <td class="p-6 py-4"> {{ $education?->pivot?->department ?? '' }}</td>
                                        <td class="p-6 py-4">"{{ $education?->pivot?->passing_year ?? '' }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif

        @if (isset($user->experiences) && $user->experiences->count() > 0)
            <!-- Experience -->
            <div class="card overflow-hidden">
                <div class="px-4 md:p-6 !py-2 bg-gray-200/30 dark:bg-dark-card-two">
                    <div class="flex-center-between">
                        <h6 class="card-title text-lg">{{ translate('Experience') }}</h6>
                    </div>
                </div>

                <div class="p-3 md:p-6">
                    <div class="overflow-x-auto scrollbar-table">
                        <table
                            class="table-auto border-collapse w-full whitespace-nowrap text-sm text-left text-gray-500 dark:text-dark-text font-medium">
                            <thead>
                                <tr class="text-primary-500">
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Company') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Role') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('Start Date') }}
                                    </th>
                                    <th
                                        class="p-6 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">
                                        {{ translate('End Date') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody
                                class="divide-y divide-gray-200 dark:divide-dark-border-three dark:divide-dark-border-three">
                                @foreach ($user->experiences as $experience)
                                    <tr>
                                        <td class="p-6 py-4">{{ $experience->name ?? '' }}</td>
                                        <td class="p-6 py-4">{{ $experience?->pivot?->designation ?? '' }}</td>
                                        <td class="p-6 py-4">{{ $experience?->pivot?->start_date ?? '' }}</td>
                                        <td class="p-6 py-4">
                                            {{ $experience?->pivot?->end_date ? $experience?->pivot?->end_date : translate('Currently Working') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @endif
    </div>
    <!-- End Account Setting Form -->
    <!-- Start Profile View -->
    <div class="col-span-full sm:col-span-6 xl:col-span-4">
        <x-portal::admin.user-profile :user=$user guard="{{ $user->guard }}" :translations="$translations" />
    </div>
    <!-- End Profile View -->
</div>
