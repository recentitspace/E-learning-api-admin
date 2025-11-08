<div class="overflow-x-auto scrollbar-table">
    <table
        class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
        <thead class="text-primary-500">
            <tr>
                <th
                    class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                    {{ isset($userType) && $userType == 'student' && $type == 'course' ? translate('Contact') : translate('Ticket Id') }}
                </th>
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
                <tr>
                    @if ($type == 'course' && isset($userType) && $userType == 'student')
                        <td class="px-3.5 py-4">
                            @if (isset($ticket?->courseSupport?->course))
                                @foreach ($ticket?->courseSupport?->course?->instructors as $instructor)
                                    @php
                                        $user = $instructor?->userable ?? null;
                                        $profileImg =
                                            $user->profile_img &&
                                            fileExists('lms/instructors', $user?->profile_img) == true
                                                ? asset("storage/lms/instructors/{$user->profile_img}")
                                                : asset('lms/assets/images/placeholder/profile.jpg');

                                        $userTranslations = parse_translation($user);

                                    @endphp
                                    <a href="#" class="flex items-center gap-2">
                                        <div class="size-10 rounded-50 overflow-hidden dk-theme-card-square">
                                            <img src="{{ $profileImg }}" alt="instructor"
                                                class="size-full object-cover">
                                        </div>
                                        <h6 class="text-heading">
                                            {{ $userTranslations['first_name'] ?? ($user?->first_name ?? '') }}
                                            {{ $userTranslations['last_name'] ?? ($user?->last_name ?? '') }}
                                        </h6>
                                    </a>
                                @endforeach
                            @endif
                        </td>
                    @else
                        <td class="px-3.5 py-4">
                            <h6 class="text-md leading-none">#{{ $ticket->ticket_code }}</h6>
                        </td>
                    @endif
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
                            <a href="{{ route($action, ['id' => $ticket->id, 'type' => $type]) }}"
                                class="btn-icon btn-primary-icon-light size-8">
                                <i class="ri-{{ $icon == 'reply' ? 'reply' : 'eye' }}-line text-inherit text-base"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
