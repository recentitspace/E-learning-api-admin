@php
    $viewRoute = 'student.profile';
    $editRoute = 'student.edit';
    if (isInstructor()) {
        $viewRoute = 'instructor.student.profile';
    } elseif (isOrganization()) {
        $viewRoute = 'organization.student.profile';
    }

    $isAdmin = isAdmin();
@endphp
<div class="card">
    <div class="overflow-x-auto scrollbar-table">
        <table class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text">
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
                @foreach ($students as $student)
                    @php
                        $userInfo = $student?->userable ?? null;
                        $profileImg =
                            isset($userInfo->profile_img) && fileExists('lms/students', $userInfo->profile_img) == true
                                ? asset('storage/lms/students/' . $userInfo->profile_img)
                                : asset('lms/assets/images/placeholder/profile.jpg');

                        $translations = parse_translation($userInfo);

                    @endphp
                    <tr>
                        <td class="px-4 py-4">
                            <a href="{{ route($viewRoute, $student->id) }}" class="flex items-center gap-3.5">
                                <div class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                    <img src="{{ $profileImg }}" alt="student" class="size-full object-cover">
                                </div>
                                <h6 class="leading-none text-heading dark:text-white font-semibold capitalize">
                                    {{ $translations['first_name'] ?? $userInfo->first_name }}
                                    {{ $translations['last_name'] ?? $userInfo->last_name }}
                                </h6>
                            </a>
                        </td>
                        <td class="px-4 py-4">{{ $student?->email }}</td>
                        <td class="px-4 py-4">{{ $userInfo?->phone }}</td>
                        <td class="px-4 py-4">{{ $student?->enrollments?->count() }}</td>
                        @if ($isAdmin)
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
                                        {{ $userInfo?->status == 1 ? 'checked' : '' }}
                                        data-action="{{ $action ?? '#' }}">
                                    <span class="switcher switcher-primary-solid"></span>
                                </label>
                            </td>
                        @endif
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route($viewRoute, $student->id) }}"
                                    class="btn-icon btn-primary-icon-light size-8">
                                    <i class="ri-eye-line text-inherit text-base"></i>
                                </a>
                                @if ($isAdmin)
                                    <a href="{{ route($editRoute, $student->id) }}"
                                        class="btn-icon btn-primary-icon-light size-8">
                                        <i class="ri-edit-2-line text-inherit text-base"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Start Pagination -->
        {{ $students->links('portal::admin.pagination.paginate') }}
    </div>
</div>
