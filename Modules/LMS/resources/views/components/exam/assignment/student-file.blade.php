<!-- NO ASSIGNMETN BANNER -->
@if (isset($userExam) && !empty($userExam))

    @php
        $user = $userExam->user?->userable ?? null;
        $profile_img = $user?->profile_img ?? '';
        $image =
            $profile_img && fileExists('lms/instructors', $profile_img) == true
                ? asset("storage/lms/instructors/{$profile_img}")
                : asset('lms/frontend/assets/images/370x396.svg');
    @endphp

    <div class="bg-white border border-border rounded-lg p-4">
        <div class="flex items-center gap-3">
            <div class="size-12 rounded-50 overflow-hidden shrink-0">
                <img data-src="{{ $image }}" alt="Instructor profile image">
            </div>
            <div>
                <h6 class="area-title text-base font-bold !leading-none">
                    {{ $user?->first_name . ' ' . $user?->last_name }}
                </h6>
                <p class="text-heading/70 leading-none text-xs mt-2">
                    {{ customDateFormate($userExam->created_at, format: 'D M Y') | customDateFormate($userExam->created_at, format: 'h:i am') }}
                </p>
            </div>
        </div>
        <div class="area-description mt-5">
            <p>
                {{ $userExam->description }}
            </p>
        </div>
        <div class="flex items-center gap-4 mt-5">
            @foreach ($userExam->sourceFiles as $sourceFile)
                @if (fileExists('lms/courses/topics/assignments', $sourceFile->file) == true && $sourceFile->file != '')
                    <a href="{{ asset("storage/lms/courses/topics/assignments/{$sourceFile->file}") }}"
                        aria-label="Assignment information"
                        class="flex items-center gap-3 px-4 py-2 bg-primary-50 rounded-md border border-transparent hover:border-primary select-none custom-transition">
                        <i class="ri-file-download-line"></i>
                        <div>
                            <h6 class="area-title text-sm font-semibold !leading-none">
                                {{ $sourceFile->file_name ?? translate('Assignment file') }}</h6>
                            <p class="text-heading/70 leading-none text-xs mt-2 uppercase">
                                {{ getFileExtension($sourceFile->file) }}</p>
                        </div>
                    </a>
                @endif
            @endforeach

        </div>
    </div>
@else
    <div class="bg-white border border-border rounded-xl h-[400px]">
        <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
            <h2 class="area-title text-2xl">
                {{ translate('No Submissions Yet') }}
            </h2>
            <p class="area-description">
                {{ translate('There are no submissions at the moment.Please check back later or remind your students to upload their assignments') }}.
            </p>
        </div>
    </div>
@endif
