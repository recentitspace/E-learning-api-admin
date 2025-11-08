@php
    $image =
        !empty($course->thumbnail) && fileExists('lms/courses/thumbnails', $course->thumbnail)
            ? asset('storage/lms/courses/thumbnails/' . $course->thumbnail)
            : asset('lms/frontend/assets/images/420x252.svg');

    $shortVideo =
        !empty($course->short_video) && fileExists('lms/courses/demo-videos', $course->short_video)
            ? asset('storage/lms/courses/demo-videos/' . $course->short_video)
            : null;

@endphp
@if ($course->video_src_type == 'local')
    <video id="course-demo" playsinline controls data-poster="{{ $image }}">
        <source src="{{ $shortVideo }}" type="video/mp4" />
    </video>
@else
    <!-- VIMEO/YOUTUBE -->
    <div class="plyr__video-embed" id="course-demo">
        <iframe src="{{ $course->demo_url }}" allowfullscreen allowtransparency allow="autoplay"></iframe>
    </div>
@endif
