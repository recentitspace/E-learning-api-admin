@php
    $startTopicId = $start_topic_id ?? null;
    $auth = $auth ?? '';
    $purchaseCheck = $purchaseCheck ?? '';
    if ($auth && $purchaseCheck !== false) {
        $route = route('play.course', [
            'slug' => $course->slug,
            'topic_id' => $topic->id,
            'type' => $topic->topic_type?->slug,
            'chapter_id' => $chapterId ?? null,
        ]);
    } else {
        $route = '#';
    }
@endphp
<div class="border-t border-border hover:bg-slate-200 relative {{ $startTopicId == $topic->id ? 'active' : '' }}">

    <a href="{{ $sideBarShow == 'video-play' ? '#' : $route }}"
        class=" flex flex-col gap-2 px-3 py-4 leading-none cursor-pointer {{ $sideBarShow == 'video-play' ? 'video-lesson-item' : '' }}"
        aria-label="{{ $topic->title }}" data-type="{{ $sideBarShow == 'video-play' ? $topic->topic_type?->slug : '' }}"
        data-id="{{ $sideBarShow == 'video-play' ? $topic->id : '' }}"
        data-action="{{ $sideBarShow == 'video-play' ? route('learn.course.topic') . '?course_id=' . $course->id . '&chapter_id=' . $topic?->chapter_id . '&topic_id=' . $topic->id : '' }}">
        <h6 class="text-sm font-normal">
            {{ $key + 1 }}.
            {{ $topic->title }} ({{ $topic?->topic_type?->slug }})
        </h6>
        @if ($topic->duration)
            <div class="flex items-center gap-1 ml-4 text-xs text-slate-900">
                {!! $icon ?? '' !!}
                {{ $topic->duration }}{{ translate('min') }}
            </div>
        @endif
    </a>

    @if (!$auth || ($auth && $purchaseCheck == false))
        <span class="absolute top-1/2 -translate-y-1/2 right-2 rtl:right-auto rtl:left-2 text-heading">
            <i class="ri-lock-line"></i>
        </span>
    @endif
</div>
