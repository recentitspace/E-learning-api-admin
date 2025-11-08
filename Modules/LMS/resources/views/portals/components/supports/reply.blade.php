@php

    $closeAction = route('support-ticket.close', $ticket->ticket_code);
    if (isStudent()) {
        $closeAction = route('student.ticket.close', $ticket->ticket_code);
    }

    if (isInstructor()) {
        $closeAction = route('instructor.ticket.close', $ticket->ticket_code);
    }

    if (isOrganization()) {
        $closeAction = route('organization.ticket.close', $ticket->ticket_code);
    }
@endphp



<div class="card flex justify-between">
    <div class="ticket-title">
        {{ $ticket->title }}
    </div>
    <a href="#" class="btn btn-danger-solid b-solid "
        onclick="event.preventDefault(); document.getElementById('close-form').submit();">
        <span class="group-data-[sidebar-size=sm]:hidden block">{{ translate('Ticket Close') }}</span>
    </a>
    <form id="close-form" action="{{ $closeAction }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

<form method="post" action="{{ $action }}" class="form" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

    <div class="card">
        <h6 class="card-title text-[18px]">
            {{ translate('Description') }}:
        </h6>
        <div class="card-description text-gray-500 dark:text-dark-text text-base">{!! clean($ticket->description) !!}</div>
    </div>
    <div>

        @if ($ticket->replies->count() == 0 && isset($replyForm) && $replyForm != true)
            <h2 class="card-title">
                {{ translate('You Should reply as soon as possible') }}.
            </h2>
        @endif
        <div class="card p-0 overflow-hidden lms-chat-box">

            @if ($ticket->replies->count() > 0)
                <div class="flex">
                    <div class="chat-body grow">
                        <div class="h-[calc(100vh_-_theme('spacing.header')_*_5.6)] xl:h-[calc(100vh_-_theme('spacing.header')_*_5.85)] smooth-scrollbar p-6"
                            data-scrollbar>

                            <ul class="flex flex-col gap-3">
                                @foreach ($ticket->replies as $reply)
                                    <li class="flex chat-message group/item [&.authority]:justify-end">
                                        <div class="flex gap-3">
                                            @php
                                                $user = $reply->user->userable ?? $reply->author;
                                                $path =
                                                    $reply->user && $reply->user->userable
                                                        ? 'lms/instructors'
                                                        : 'lms/admins';

                                                $profileImg =
                                                    $user->profile_img && fileExists("{$path}", $user->profile_img)
                                                        ? asset("storage/{$path}/{$user->profile_img}")
                                                        : asset('lms/assets/images/placeholder/profile.jpg');
                                            @endphp

                                            <a href="#"
                                                class="flex-center self-end rounded-50 size-9 bg-slate-100 shrink-0 group-[.authority]/item:order-2">
                                                <img src="{{ $profileImg }}" alt="client"
                                                    class="object-cover rounded-full h-9">
                                            </a>

                                            <div
                                                class="grow flex flex-col group-[.authority]/item:items-end gap-1 group-[.authority]/item:order-1">
                                                <div class="flex gap-1 group/msg">
                                                    <div class="flex flex-col gap-1 group-[.authority]/item:order-2">
                                                        <div
                                                            class="relative px-4 py-2.5 font-spline_sans text-sm text-gray-500 dark:text-dark-text bg-white dark:bg-dark-icon dk-border-one rounded-full rounded-bl-none 2xl:max-w-sm group-[.authority]/item:border-none group-[.authority]/item:bg-primary-500 group-[.authority]/item:text-white group-[.authority]/item:rounded-bl-full group-[.authority]/item:rounded-br-none group-[.authority]/item:order-2">
                                                            {!! clean($reply->description) !!}
                                                            @if (isset($reply->supportFiles) && !empty($reply->supportFiles))
                                                                @foreach ($reply->supportFiles as $supportFile)
                                                                    <div class="support-area">
                                                                        <a
                                                                            href="{{ asset('storage/lms/supports/' . $supportFile->file) }}">
                                                                            {{ $supportFile->file }}</a>
                                                                        <button class="delete btn-support-delete"
                                                                            data-action="{{ route('support-ticket.delete.file', $supportFile->id) }}">
                                                                            {{ translate('Delete') }}
                                                                        </button>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div
                                                            class="font-spline_sans text-xs leading-none text-gray-900 dark:text-dark-text group-[.authority]/item:order-2 group-[.authority]/item:self-end">
                                                            {{ customDateFormate($reply->created_at, $format = 'm:s A') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @if (isset($userType) && $userType != 'student' && $ticket->status !== 'close')
                <div class="mt-6">
                    <textarea name="description" class="summernote"></textarea>
                </div>
                <div class="flex-center-between p-6">
                    <div
                        class="file-container file-input-label bg-transparent text-[#727175] h-11 w-max dk-theme-card-square">
                        <span
                            class="px-3 rounded-lg rounded-r-none border-r bg-[#EEEEEE] dark:bg-dark-icon border-input-border dark:border-dark-border-four flex-center before:font-remix before:text-xl text-sm before:content-['\f24e'] dark:before:text-dark-text-two dk-theme-card-square"></span>
                        <label for="attatch-support-file" class="p-2.5 grow">
                            <input type="file" name="support_files[]" id="attatch-support-file"
                                class="hidden file-src" multiple>
                            <span class="file-name text-sm"> {{ translate('No file choose') }} </span>
                        </label>
                    </div>
                    <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square px-5">
                        {{ translate('Reply') }}
                    </button>
                </div>
            @endif
        </div>
    </div>
</form>
