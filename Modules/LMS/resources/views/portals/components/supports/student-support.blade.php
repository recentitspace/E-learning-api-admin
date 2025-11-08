<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
        <thead class="text-primary-500">
            <tr>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ 'Student' }}</th>

                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ 'Ticket Code' }}</th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Title') }} </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Ticket Date') }} </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ translate('Ticket Status') }} </th>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                    {{ translate('Action') }} </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
            @foreach ($tickets as $ticket)
                @php
                    $ticket = $ticket->support;
                    $user = $ticket?->user->userable;
                    $userTranslations = parse_translation($user);

                    $firstName = $userTranslations['first_name'] ?? ($user->first_name ?? '');
                    $lastName = $userTranslations['last_name'] ?? ($user->last_name ?? '');

                    $profileImg =
                        $user?->profile_img && fileExists('lms/students', $user?->profile_img)
                            ? asset('storage/lms/students/' . $user->profile_img)
                            : asset('lms/assets/images/placeholder/profile.jpg');
                @endphp
                <tr>
                    <td class="px-3.5 py-4">
                        <a href="#" class="flex items-center gap-2">
                            <div class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                <img src="{{ $profileImg }}" alt="instructor" class="size-full object-cover">
                            </div>
                            <h6 class="text-heading">

                                @if (isset($user->first_name, $user->last_name))
                                    {{ $firstName . ' ' . $lastName }}
                                @else
                                    {{ $userTranslations['name'] ?? $user->name }}
                                @endif
                            </h6>
                        </a>
                    </td>
                    <td class="px-3.5 py-4">
                        <h6 class="text-md leading-none">#{{ $ticket->ticket_code }}</h6>
                    </td>
                    <td class="px-3.5 py-4">
                        <h6 class="text-md leading-none"><a href="#">{{ $ticket->title }}</a></h6>
                    </td>
                    <td class="px-3.5 py-4">
                        {{ customDateFormate($ticket->updated_at, $format = 'y M d') }}
                    </td>
                    <td class="px-3.5 py-4">

                        @switch($ticket->status)
                            @case('pending')
                                <span class="badge b-solid badge-warning-solid capitalize">
                                    {{ translate($ticket->status) }}
                                </span>
                            @break

                            @case('active')
                                <span class="badge b-solid badge-success-solid capitalize">
                                    {{ translate($ticket->status) }}
                                </span>
                            @break

                            @case('close')
                                <span class="badge b-solid badge-danger-solid capitalize">
                                    {{ translate($ticket->status) }}
                                </span>
                            @break
                        @endswitch

                    </td>
                    <td class="px-3.5 py-4">
                        <div class="flex items-center gap-1">
                            <a href="{{ route($action, ['id' => $ticket->id, 'type' => 'student']) }}"
                                class="btn-icon btn-primary-icon-light size-8">
                                <i
                                    class="ri-{{ $icon == 'reply' ? 'reply' : 'eye' }}-line text-inherit text-[13px]"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
