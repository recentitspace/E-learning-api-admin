<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-non">
        <thead class="text-primary-500">
            <tr>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Certificate') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Certificate ID') }}
                </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Certificate Type') }}
                </th>

                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Certificate Date') }}
                </th>

                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                    {{ translate('Action') }}
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
            @foreach ($certificates as $certificate)
                <tr>
                    <td class="items-center gap-2 px-3.5 py-4">
                        <h6 class="leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                            {{ $certificate->subject ?? '' }}
                        </h6>
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $certificate->certificate_id ?? 0 }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ $certificate?->type }}
                    </td>
                    <td class="px-3.5 py-4">
                        {{ customDateFormate($certificate->certificated_date, format: 'm D  Y') }}
                    </td>
                    <td class="px-3.5 py-4">
                        <a href="{{ route('student.certificate.download', $certificate->id) }}" target="_blank"
                            class="btn b-solid btn-info-solid btn-sm" title="{{ translate('Certificate Download') }}">
                            {{ translate('View') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
