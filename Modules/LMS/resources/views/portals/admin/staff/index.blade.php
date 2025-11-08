@extends('portal::admin.layouts.master')

@section('content')
    <div class="card overflow-hidden">
        <div class="flex flex-col gap-2 sm:flex-center-between sm:flex-row px-4 py-5 sm:p-7 bg-gray-200/30">
            <div>
                <h6 class="card-title"> {{ translate('Our Staff list') }} </h6>
                <p class="card-description">
                    {{ translate('Our Staff Profile here') }}
                </p>
            </div>
            <select data-select name="duration" id="courseCategory"
                class="list-border-primary text-gray-500 dark:text-dark-text self-end sm:self-auto">
                <option value="last-3-month"> {{ translate('Last 3 Month') }} </option>
                <option value="last-month"> {{ translate('Last Month') }} </option>
                <option value="last-week"> {{ translate('Last Week') }} </option>
            </select>
        </div>
        <!-- Start Student List Table -->
        <div class="p-3 sm:p-4">
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
                                {{ translate('Email') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Phone') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($staffs as $staff)
                            <tr>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-3">
                                        <a href="#" class="size-12 rounded-50 overflow-hidden dk-theme-card-square">
                                            <img src="{{ asset('lms/assets/images/placeholder/profile.jpg') }}"
                                                alt="student" class="size-full object-cover">
                                        </a>
                                        <div>
                                            <h6 class="leading-none text-heading dark:text-white font-semibold">
                                                <a href="#">{{ $staff->name }}</a>
                                            </h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4"> {{ $staff->email }}</td>
                                <td class="px-3.5 py-4"> {{ $staff->phone }}</td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="#"
                                            class="btn-icon btn-primary-icon-light size-8">
                                            <i class="ri-message-2-line text-inherit text-base"></i>
                                        </a>
                                        <a href="#!" data-modal-target="deleteStudentModal"
                                            data-modal-toggle="deleteStudentModal"
                                            class="size-7 flex-center rounded-50 bg-danger-200">
                                            <i class="ri-delete-bin-line text-inherit text-base"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Start Pagination -->
            {{ $staffs->links('portal::admin.pagination.paginate') }}
            <!-- End Pagination -->
        </div>
        <!-- End Student List Table -->
    </div>
@endsection
