@php
    $editRoute = 'instructor.edit';
    $deleteRoute = 'instructor.destroy';
    $restoreRoute = 'instructor.restore';
    $verifyRoute = 'instructor.verify.email';
    $statusChangeRoute = 'instructor.status';
    $viewRoute = 'instructor.profile';
    $translateRoute = 'instructor.translate';

    if (isOrganization()) {
        $editRoute = 'organization.instructor.edit';
        $deleteRoute = 'organization.instructor.destroy';
        $restoreRoute = 'organization.instructor.restore';
        $viewRoute = 'organization.instructor.profile';
        $statusChangeRoute = 'organization.instructor.status';
        $translateRoute = 'organization.instructor.translate';
    }

    $isAdmin = isAdmin();

    $title = translate('Do you want to move to Trash');
    $text = translate('If You trash,Instructor and Instructor related all data will be trashed.');

@endphp

<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
        <thead>
            <tr class="text-primary-500">
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Profile') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Email') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Phone') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Total Course') }}
                </th>
                @if ($isAdmin)
                    <th
                        class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                        {{ translate('Email Verify') }}
                    </th>
                    <th
                        class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                        {{ translate('Status') }}
                    </th>
                @endif

                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                    {{ translate('Action') }}
                </th>
            </tr>

        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
            @foreach ($instructors as $instructor)
                @php
                    $userInfo = $instructor->userable ?? null;
                    $userableTranslations = [];
                    $designationTranslations = [];
                    if ($userInfo) {
                        $userableTranslations = parse_translation($userInfo);
                    }

                    if (method_exists($userInfo, 'designation')) {
                        $designationTranslations = parse_translation($userInfo->designation);
                    }

                    $firstName = $userableTranslations['first_name'] ?? ($userInfo?->first_name ?? '');
                    $lastName = $userableTranslations['last_name'] ?? ($userInfo?->last_name ?? '');
                    $designation = $designationTranslations['title'] ?? $userInfo?->designation?->title;
                    $profileImg =
                        $userInfo && fileExists('lms/instructors', $userInfo->profile_img) == true
                            ? asset("storage/lms/instructors/{$userInfo->profile_img}")
                            : asset('lms/assets/images/placeholder/profile.jpg');
                @endphp
                <tr>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-3.5">
                            <a href="#" class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                <img src="{{ $profileImg }}" alt="instructor" class="size-full object-cover">
                            </a>
                            <div>
                                <h6 class="leading-none text-heading dark:text-white font-semibold capitalize">
                                    <a href="#">{{ $firstName . ' ' . $lastName }}</a>
                                </h6>
                                @if ($designation)
                                    <p class="font-spline_sans text-sm font-light mt-1">
                                        {{ $designation }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">{{ $instructor->email ?? '' }}</td>
                    <td class="px-4 py-4">{{ $userInfo?->phone ?? '' }}</td>
                    <td class="px-4 py-4">{{ $instructor?->courses?->count() }}</td>

                    @if ($isAdmin)
                        <td class="px-4 py-4">
                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input type="checkbox" class="appearance-none peer status-change" name="status"
                                    {{ $instructor?->is_verify == 1 ? 'checked' : '' }}
                                    data-action="{{ route($verifyRoute, $instructor?->id) }}">
                                <span class="switcher switcher-primary-solid"></span>
                            </label>
                        </td>
                        <td class="px-4 py-4">

                            @php
                                if ($userInfo?->id) {
                                    $action = route($statusChangeRoute, $userInfo?->id);
                                }
                            @endphp

                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input type="checkbox" class="hidden appearance-none peer status-change" name="status"
                                    data-action="{{ $action ?? '#' }}"
                                    {{ $userInfo && $userInfo?->status == 1 ? 'checked' : '' }}
                                    {{ $instructor->trashed() ? 'disabled' : '' }}>
                                <span class="switcher switcher-primary-solid"></span>
                            </label>
                        </td>
                    @endif


                    <td class="px-4 py-4">

                        <div class="flex items-center gap-1">

                            @if ($instructor->trashed())
                                @php

                                    $title = translate('Do you want to Delete.');
                                    $text = translate(
                                        'If You delete,Instructor and Instructor related all data will be delete permanently.',
                                    );
                                @endphp
                                <button data-action="{{ route($restoreRoute, $instructor->id) }}"
                                    class="btn-icon btn-primary-icon-light size-8 trash-restore-btn-cs"
                                    title="{{ translate('Restore') }}"
                                    data-title="{{ translate('Do you want to restore it') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        viewBox="0 0 512 512">
                                        <path fill="currentColor" fill-rule="evenodd"
                                            d="M160 168.296c64.802 0 117.334 29.715 117.334 66.37q0 1.34-.093 2.665l.028-.294h.065v165.926c0 36.655-52.532 66.37-117.334 66.37c-63.361 0-114.992-28.409-117.256-63.937l-.077-2.433V237.037h.073a38 38 0 0 1-.073-2.37c0-36.656 52.532-66.37 117.333-66.37m0 218.074c-28.365 0-54.38-5.693-74.667-15.17v22.316l.018 1.197c.684 12.202 32.466 31.954 74.657 31.954c23.075 0 44.362-5.79 59.26-15.367c10.256-6.594 14.782-12.874 15.34-16.01l.059-.623V371.2c-20.286 9.478-46.3 15.171-74.667 15.171m0-85.333c-28.361 0-54.373-5.692-74.658-15.167l-.002 35.906l1.446-.009c1.73 1.73 5.179 4.59 11.254 8.027c15.143 8.566 37.48 13.91 61.96 13.91s46.818-5.344 61.96-13.91c7.501-4.243 11-7.609 12.2-9.05l.507-.004l.003-34.875c-20.287 9.478-46.303 15.172-74.67 15.172m0-90.074c-41.237 0-74.666 10.984-74.666 24.533S118.764 260.03 160 260.03c41.238 0 74.667-10.984 74.667-24.534s-33.43-24.533-74.667-24.533m248.775 144.288l-29.779-30.563C401.874 301.564 416 269.765 416 234.667c0-42.82-21.025-80.729-53.316-103.966l-.017 82.632H320V64h149.334v42.667l-68.447-.002c35.432 31.273 57.78 77.027 57.78 128.002c0 47.08-19.063 89.707-49.892 120.584" />
                                    </svg>
                                </button>
                                <a href="{{ route($viewRoute, $instructor->id) }}"
                                    class="btn-icon btn-primary-icon-light size-8">
                                    <i class="ri-eye-line text-inherit text-base"></i>
                                </a>
                                @if ($isAdmin)
                                    <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                        data-action="{{ route($deleteRoute, $instructor->id) }}"
                                        data-title="{{ $title }}" data-text="{{ $text }}">
                                        <i class="ri-delete-bin-line text-inherit text-base"></i>
                                    </button>
                                @endif
                            @else
                                <a href="{{ route($translateRoute, ['id' => $instructor->id, 'locale' => app()->getLocale()]) }}"
                                    class="btn-icon btn-primary-icon-light size-8">
                                    <i class="ri-translate text-inherit text-base"></i>
                                </a>
                                <a href="{{ route($editRoute, $instructor->id) }}"
                                    class="btn-icon btn-primary-icon-light size-8">
                                    <i class="ri-edit-2-line text-inherit text-base"></i>
                                </a>
                                <a href="{{ route($viewRoute, $instructor->id) }}"
                                    class="btn-icon btn-primary-icon-light size-8">
                                    <i class="ri-eye-line text-inherit text-base"></i>
                                </a>
                                <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                    data-action="{{ route($deleteRoute, $instructor->id) }}"
                                    data-title="{{ $title }}" data-text="{{ $text }}">
                                    <i class="ri-delete-bin-line text-inherit text-base"></i>
                                </button>
                            @endif
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Start Pagination -->
    {{ $instructors->links('portal::admin.pagination.paginate') }}
</div>
