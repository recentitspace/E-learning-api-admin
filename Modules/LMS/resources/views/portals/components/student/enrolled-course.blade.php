@php
    $thumbnail =
        $enrolled?->course?->thumbnail && fileExists('lms/courses/thumbnails', $enrolled?->course?->thumbnail) == true
            ? asset('storage/lms/courses/thumbnails/' . $enrolled?->course?->thumbnail)
            : asset('lms/assets/images/placeholder/thumbnail612.jpg');
    $courseTranslations = parse_translation($enrolled?->course);
    $categoryTranslations = parse_translation($enrolled?->course?->category);
    $subjectTranslations = parse_translation($enrolled?->course?->subject);
    $currency = $enrolled?->course?->coursePrice?->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp
<tr>
    <td class="px-3.5 py-4">
        <div class="flex items-center gap-2">
            <a href="#" class="size-[70px] rounded-50 overflow-hidden dk-theme-card-square">
                <img src="{{ $thumbnail }}" alt="thumb" class="size-full object-cover">
            </a>
            <div>
                <h6 class="text-lg leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                    <a href="{{ route('course.detail', $enrolled?->course?->slug) }}" target="_blank">
                        {{ $courseTranslations['title'] ?? $enrolled?->course?->title }}</a>
                </h6>
                <div class="flex items-center gap-2">
                    @if (isset($enrolled?->course?->instructors))
                        <p class="font-normal text-xs text-gray-900">
                            {{ translate('Instructor') }} -
                            @foreach ($enrolled->course->instructors as $instructor)
                                @php
                                    $userTranslations = parse_translation($instructor?->userable);
                                @endphp
                                {{ $userTranslations['first_name'] ?? $instructor?->userable?->first_name }}
                                {{ $userTranslations['last_name'] ?? $instructor?->userable?->last_name }}
                                @if (!$loop->last)
                                    {{ ',' }}
                                @endif
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </td>
    <td class="px-3.5 py-4">
        <ul class="flex flex-col gap-2">
            @if ($enrolled?->course?->category?->title)
                <li class="flex items-center gap-1">
                    <b> {{ translate('Category') }} :</b>
                    <span>{{ $categoryTranslations['title'] ?? $enrolled?->course?->category?->title }}</span>
                </li>
            @endif

            @if ($enrolled?->subject)
                <li class="flex items-center gap-1">
                    <b> {{ translate('Subject') }} :</b>
                    <span>{{ $subjectTranslations['name'] ?? $enrolled?->course?->subject?->name }}</span>
                </li>
            @endif
        </ul>
    </td>
    <td class="px-3.5 py-4">
        @if ($enrolled?->course?->courseSetting?->is_free)
            {{ translate('Free') }}
        @else
            {{ $currencySymbol }}{{ $enrolled?->course?->coursePrice?->price }}
        @endif
    </td>
    <td class="px-3.5 py-4">
        @switch($enrolled->status)
            @case('processing')
                <span class="badge badge-warning-outline b-outline capitalize">
                    {{ translate('Processing') }}
                </span>
            @break

            @case('complete')
                <span class="badge badge-primary-outline b-outline capitalize">
                    {{ translate('Complete') }}
                </span>
            @break
        @endswitch
    </td>
</tr>
