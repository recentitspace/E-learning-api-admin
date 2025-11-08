<x-dashboard-layout>
    <x-slot:title>{{ translate('Enrollment/Manage') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Student List" page-to="Enroll" action-route="{{ route('enrollment.create') }}" />

    @if ($enrollments->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Name') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Instructor/Organization') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Course/Bundle') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Enroll') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Payment Method') }}
                            </th>

                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Payment Status') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($enrollments as $enrollment)
                            @php
                                $userInfo = $enrollment?->user?->userable ?? null;
                                $instructors = $enrollment?->course?->instructors ?? [];
                                $bundleInstructor = $enrollment?->courseBundle->instructor ?? null;
                                $bundleOrganization = $enrollment?->courseBundle->organization ?? null;

                                $studentTranslations = parse_translation($userInfo);

                            @endphp
                            <tr>
                                <td class="px-2 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col space-y-2.5">
                                            <h6 class="text-sm">
                                                <span class="text-heading dark:text-dark-text font-semibold">
                                                    {{ translate('Name') }}:
                                                </span>
                                                {{ $studentTranslations['first_name'] ?? $userInfo?->first_name }}
                                                {{ $studentTranslations['last_name'] ?? $userInfo?->last_name }}
                                            </h6>
                                            <h6 class="text-sm">
                                                <span class="text-heading dark:text-dark-text font-semibold">
                                                    {{ translate('Email') }}:
                                                </span>
                                                {{ $enrollment?->user?->email }}
                                            </h6>
                                            <h6 class="text-sm">
                                                <span class="text-heading dark:text-dark-text font-semibold">
                                                    {{ translate('Phone') }}:
                                                </span>
                                                {{ $userInfo?->phone }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 py-4">
                                    @if (isset($instructors) && !empty($instructors))
                                        @foreach ($instructors as $instructor)
                                            @php
                                                $instructorInfo = $instructor?->userable ?? null;
                                                $instructorTranslations = parse_translation($instructorInfo);
                                            @endphp
                                            {{ $instructorTranslations['first_name'] ?? $instructorInfo->first_name }}
                                            {{ $instructorTranslations['last_name'] ?? $instructorInfo->last_name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @elseif($bundleInstructor)
                                        @php
                                            $bundleUser = $bundleInstructor->userable ?? null;
                                            $bundleUserTranslations = parse_translation($bundleUser);
                                        @endphp
                                        {{ $bundleUserTranslations['first_name'] ?? $user->first_name }}
                                        {{ $bundleUserTranslations['last_name'] ?? $user->last_name }}
                                    @elseif($bundleOrganization)
                                        @php
                                            $orgUser = $bundleOrganization->userable ?? null;
                                            $orgUserTranslations = parse_translation($orgUser);
                                        @endphp
                                        {{ $orgUserTranslations['name'] ?? $user->name }}
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    @if ($enrollment->purchase_type == 'course')
                                        @php
                                            $courseTranslations = parse_translation($enrollment->course);
                                        @endphp
                                        <a href="{{ route('course.edit', $enrollment->course_id) }}">
                                            {{ str_limit($courseTranslations['title'] ?? $enrollment->course?->title, 20, '...') }}</a>
                                    @elseif ($enrollment->purchase_type == 'bundle')
                                        @php
                                            $bundleTranslations = parse_translation($enrollment->courseBundle);
                                        @endphp

                                        <a href="{{ route('bundle.list') }}">
                                            {{ str_limit($bundleTranslations['title'] ?? $enrollment->courseBundle?->title, 20, '...') }}</a>
                                    @endif
                                </td>
                                <td class="px-2 py-4">
                                    {{ customDateFormate($enrollment->created_at, $format = 'd M Y h:i a') }}
                                </td>

                                <td class="px-2 py-4">
                                    {{ $enrollment?->purchase->payment_method }}
                                </td>
                                <td class="px-2 py-4">
                                    @switch($enrollment?->purchase->status)
                                        @case('success')
                                            <span class="badge b-solid badge-warning-solid capitalize">
                                                {{ translate('success') }}
                                            </span>
                                        @break

                                        @case('fail')
                                            <span class="badge b-solid badge-danger-solid capitalize">
                                                {{ translate('fail') }}
                                            </span>
                                        @break
                                    @endswitch
                                </td>

                                <td>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('enrollment.show', $enrollment->id) }}"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-eye-line text-inherit text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $enrollments->links('portal::admin.pagination.paginate') }}
        </div>
    @else
        <x-portal::admin.empty-card title="No enrollment" action="{{ route('enrollment.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
