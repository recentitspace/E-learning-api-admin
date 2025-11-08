@php
    $title = translate('Do you want to move to Trash');
    $text = translate('If You trash,Student and Student related all data will be trashed.');

@endphp


<x-dashboard-layout>
    <x-slot:title> {{ translate('Manage Student') }} </x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="All Student" page-to="Student" action-route="{{ route('student.create') }}" />


    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card title="Total Student" value="{{ $reports['total_users'] }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Active Student"
                value="{{ $reports['total_active'] }}" />
            <x-portal::admin.course-overview-card color-type="danger" title="Deactivate Student"
                value="{{ $reports['total_inactive'] }}" />
            <x-portal::admin.course-overview-card color-type="primary" title="Verified"
                value="{{ $reports['total_verified'] }}" />
            <x-portal::admin.course-overview-card color-type="danger" title="Unverified"
                value="{{ $reports['total_unverified'] }}" />
        </div>
    </div>
    <div class="card">
        <form method="get">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <input type="text" class="form-input" placeholder="{{ translate('Search name') }}" name="name_search" autocomplete="off" value="{{ Request()->name_search ?? '' }}">
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <select class="singleSelect" name="status">
                        @php
                            $status = Request()->status ?? '';
                        @endphp
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ translate('All') }}</option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>{{ translate('Active') }}
                        </option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>
                            {{ translate('Inactive') }}</option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <select class="singleSelect" name="verify">
                        @php
                            $verify = Request()->verify ?? '';
                        @endphp
                        <option value="all" {{ $verify == 'all' ? 'selected' : '' }}>{{ translate('All') }}</option>
                        <option value="verified" {{ $verify == 'verified' ? 'selected' : '' }}>{{ translate('Verified') }}</option>
                        <option value="unverified" {{ $verify == 'unverified' ? 'selected' : '' }}>{{ translate('Un Verified') }}</option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <div class="flex items-end">
                        <button class="btn b-solid btn-info-solid mr-3">{{ translate('Filter') }}</button>
                        <a href="{{ route('student.index') }}" class="btn b-solid btn-info-solid">
                            {{ translate('Refresh') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="flex items-center gap-2 pb-5 mb-5 border-b border-gray-200 dark:border-dark-border">
        <a href="{{ route('student.index', ['filter' => 'all']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'all' ? 'active' : '' }}">{{ translate('All') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['total'] ?? 0 }}</span>
        </a></a>
        <a href="{{ route('student.index') }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'published' ? 'active' : '' }}">
            {{ translate('Published') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['published'] ?? 0 }}</span></a>
        <a href="{{ route('student.index', ['filter' => 'trash']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'trash' ? 'active' : '' }}">
            {{ translate('Trash') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['trashed'] ?? 0 }}</span>
        </a>
    </div>
    @if ($students->count() > 0)
        <div class="card">
            <div class="overflow-x-auto scrollbar-table">
                <table
                    class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text">
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
                                {{ translate('Enrolled Course') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Email Verify') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>

                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($students as $student)
                            @php
                                $userInfo = $student?->userable ?? null;
                                $userableTranslations = [];
                                $designationTranslations = [];
                                
                                if ($userInfo) {
                                    $userableTranslations = parse_translation($userInfo);
                                }
                                
                                $firstName = $userableTranslations['first_name'] ?? $userInfo?->first_name ?? '';
                                $lastName = $userableTranslations['last_name'] ?? $userInfo?->last_name ?? '';

                                $profileImg =
                                    $userInfo && fileExists('lms/students', $userInfo?->profile_img) == true
                                        ? asset("storage/lms/students/{$userInfo?->profile_img}")
                                        : asset('lms/assets/images/placeholder/profile.jpg');
                            @endphp
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3.5">
                                        <a href="#"
                                            class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                            <img src="{{ $profileImg }}" alt="student"
                                                class="size-full object-cover">
                                        </a>
                                        <div>
                                            <h6
                                                class="leading-none text-heading dark:text-white font-semibold capitalize">
                                                <a href="#">
                                                    {{ $firstName . ' ' . $lastName }}
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">{{ $student?->email }}</td>
                                <td class="px-4 py-4">{{ $userInfo?->phone }}</td>
                                <td class="px-4 py-4">{{ $student?->enrollments?->count() }}</td>
                                <td class="px-4 py-4">
                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer status-change" name="status"
                                            {{ $student?->is_verify == 1 ? 'checked' : '' }}
                                            data-action="{{ route('student.verify.email', $student?->id) }}">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        if ($userInfo?->id) {
                                            $action = route('student.status', $userInfo?->id);
                                        }
                                    @endphp
                                    <label class="inline-flex items-center me-5 cursor-pointer">
                                        <input type="checkbox" class="appearance-none peer status-change" name="status"
                                            {{ $userInfo && $userInfo?->status == 1 ? 'checked' : '' }}
                                            data-action="{{ $action ?? '#' }}">
                                        <span class="switcher switcher-primary-solid"></span>
                                    </label>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('student.translate', ['id' => $student->id, 'locale' => app()->getLocale()]) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-translate text-inherit text-base"></i>
                                        </a>
                                        @if ($student->trashed())
                                            @php
                                                $title = translate('Do you want to Delete.');
                                                $text = translate('If You delete It, Student and Student related all data will be delete Permanently.');
                                            @endphp
                                            <button data-action="{{ route('student.restore', $student->id) }}"
                                                class="btn-icon btn-primary-icon-light size-8 trash-restore-btn-cs"
                                                title="{{ translate('Restore') }}" data-title="{{ translate('Do you want to restore it') }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 512 512">
                                                    <path fill="currentColor" fill-rule="evenodd"
                                                        d="M160 168.296c64.802 0 117.334 29.715 117.334 66.37q0 1.34-.093 2.665l.028-.294h.065v165.926c0 36.655-52.532 66.37-117.334 66.37c-63.361 0-114.992-28.409-117.256-63.937l-.077-2.433V237.037h.073a38 38 0 0 1-.073-2.37c0-36.656 52.532-66.37 117.333-66.37m0 218.074c-28.365 0-54.38-5.693-74.667-15.17v22.316l.018 1.197c.684 12.202 32.466 31.954 74.657 31.954c23.075 0 44.362-5.79 59.26-15.367c10.256-6.594 14.782-12.874 15.34-16.01l.059-.623V371.2c-20.286 9.478-46.3 15.171-74.667 15.171m0-85.333c-28.361 0-54.373-5.692-74.658-15.167l-.002 35.906l1.446-.009c1.73 1.73 5.179 4.59 11.254 8.027c15.143 8.566 37.48 13.91 61.96 13.91s46.818-5.344 61.96-13.91c7.501-4.243 11-7.609 12.2-9.05l.507-.004l.003-34.875c-20.287 9.478-46.303 15.172-74.67 15.172m0-90.074c-41.237 0-74.666 10.984-74.666 24.533S118.764 260.03 160 260.03c41.238 0 74.667-10.984 74.667-24.534s-33.43-24.533-74.667-24.533m248.775 144.288l-29.779-30.563C401.874 301.564 416 269.765 416 234.667c0-42.82-21.025-80.729-53.316-103.966l-.017 82.632H320V64h149.334v42.667l-68.447-.002c35.432 31.273 57.78 77.027 57.78 128.002c0 47.08-19.063 89.707-49.892 120.584" />
                                                </svg>
                                            </button>
                                        @else
                                            <a href="{{ route('student.edit', $student->id) }}"
                                                class="btn-icon btn-primary-icon-light size-8">
                                                <i class="ri-edit-2-line text-inherit text-base"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('student.profile', $student->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                        <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route('student.destroy', $student->id) }}"
                                            data-title="{{ $title }}" data-text="{{ $text }}">
                                            <i class="ri-delete-bin-line text-inherit text-base"></i>
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Start Pagination -->
                {{ $students->links('portal::admin.pagination.paginate') }}
                <!-- End Pagination -->
            </div>
        </div>
    @else
        <x-portal::admin.empty-card title="No Student" />
    @endif
</x-dashboard-layout>
