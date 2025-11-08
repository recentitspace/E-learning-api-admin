@php
    $image =
        !empty($bundle->thumbnail) && fileExists('lms/courses/bundles', $bundle->thumbnail)
            ? asset('storage/lms/courses/bundles/' . $bundle->thumbnail)
            : asset('lms/frontend/assets/images/420x252.svg');

    $shortVideo =
        !empty($bundle->video_demo) && fileExists('lms/courses/bundles/videos', $bundle->video_demo)
            ? asset('storage/lms/courses/bundles/videos/' . $bundle->video_demo)
            : null;

@endphp
@if ($bundle->video_src_type == 'local')
    <video id="course-demo" playsinline controls data-poster="{{ $image }}">
        <source src="{{ $shortVideo }}" type="video/mp4" />
    </video>
@else
    <!-- VIMEO/YOUTUBE -->
    <div class="plyr__video-embed" id="course-demo">
        <iframe src="{{ $bundle->video_demo }}" allowfullscreen allowtransparency allow="autoplay"></iframe>
    </div>
@endif
