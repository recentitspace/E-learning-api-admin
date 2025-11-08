@php
    $thumbnail =
        $enrolled?->courseBundle?->thumbnail &&
        fileExists('lms/courses/bundles', $enrolled?->courseBundle?->thumbnail) == true
            ? asset('storage/lms/courses/bundles/' . $enrolled?->courseBundle?->thumbnail)
            : asset('lms/assets/images/placeholder/thumbnail612.jpg');
@endphp
<tr>
    <td class="px-3.5 py-4">
        <div class="flex items-center gap-2">
            <a href="{{ route('bundle.list') }}" class="size-[70px] rounded-50 overflow-hidden dk-theme-card-square">
                <img src="{{ $thumbnail }}" alt="thumb" class="size-full object-cover">
            </a>
            <h6 class="text-lg leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1">
                <a href="{{ route('bundle.list') }}" target="_blank">
                    {{ $enrolled?->courseBundle?->title }}</a>
            </h6>
        </div>
    </td>
    <td class="px-3.5 py-4">
        {{ translate('Bundle') }}
    </td>
    <td class="px-3.5 py-4">
        @if ($enrolled?->courseBundle?->price !== 0)
            ${{ $enrolled?->courseBundle?->price }}
        @else
            {{ translate('Free') }}
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
