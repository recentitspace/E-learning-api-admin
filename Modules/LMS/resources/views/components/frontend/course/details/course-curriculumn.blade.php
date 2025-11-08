<div id="course-curriculumn" class="tabcontent hidden">
    <h3 class="lg:text-32 sm:text-28 text-xl font-semibold text-heading mb-4">
        {{ translate('Course Curriculum') }}
    </h3>
    <div class="space-y-5">
        @foreach ($course->chapters as $chapter)
            <div class="border border-gray-200 rounded-md">
                <div class="accordion course-over-accord group/courseAccord">
                    <h5 class="font-medium text-heading grow">
                        {{ $chapter->title }}
                    </h5>
                    <h6 class="text-gray shrink-0"> 
                        {{ translate('Lesson') }}:
                        <strong>{{ $chapter?->topics?->count() }}</strong>
                    </h6>
                </div>
                <div class="accordionpanel panel">
                    @foreach ($chapter->topics as $topic)
                        @if ($topic?->topicable?->topic_type?->slug == 'video')
                            <a href="{{ authCheck() ? route('play.course', $course->slug . '?type=' . $topic?->topicable?->topic_type?->slug . '&item=' . $topic->id) : '#' }}" class="course-accord-item gap-5 hover:bg-slate-100 group/curriculum" aria-label="Course curriculum">
                                <div class="flex items-center gap-2 font-medium group-hover/curriculum:text-primary duration-200 grow">
                                    <i class="ri-file-video-line"></i>
                                    <span class="-mb-1 line-clamp-1">{{ $topic?->topicable?->title }}</span>
                                </div>
                                <div class="text-primary text-sm flex items-center justify-center gap-4 shrink-0">{{ translate('Video') }}: {{ $topic?->topicable?->duration }}</div>
                            </a>
                        @endif

                        @if ($topic?->topicable?->topic_type?->slug == 'reading')
                            <a href="{{ authCheck() ? route('play.course', $course->slug . '?type=' . $topic?->topicable?->topic_type?->slug . '&item=' . $topic->id) : '#' }}" class="course-accord-item gap-5 hover:bg-slate-100 group/curriculum" aria-label="Course curriculum">
                                <div class="flex items-center gap-2 font-medium group-hover/curriculum:text-primary duration-200 grow">
                                    <i class="ri-file-text-line"></i>
                                    <span class="-mb-1 line-clamp-1">{{ $topic?->topicable?->title }}</span>
                                </div>
                                <div class="text-primary text-sm flex items-center justify-center gap-4 shrink-0">{{ translate('Read') }}</div>
                            </a>
                        @endif

                        @if ($topic?->topicable?->topic_type?->slug == 'supplement')
                            <a href="{{ authCheck() ? route('play.course', $course->slug . '?type=' . $topic?->topicable?->topic_type?->slug . '&item=' . $topic->id) : '#' }}" class="course-accord-item gap-5 hover:bg-slate-100 group/curriculum" aria-label="Course curriculum">
                                <div class="flex items-center gap-2 font-medium group-hover/curriculum:text-primary duration-200 grow">
                                    <i class="ri-file-text-line"></i>
                                    <span class="-mb-1 line-clamp-1">{{ $topic?->topicable?->title }}</span>
                                </div>
                                <div class="text-primary text-sm flex items-center justify-center gap-4 shrink-0">{{ translate('Read') }}</div>
                            </a>
                        @endif

                        @if ($topic?->topicable?->topic_type?->slug == 'assignment')
                            <a href="{{ authCheck() ? route('play.course', $course->slug . '?type=' . $topic?->topicable?->topic_type?->slug . '&item=' . $topic->id) : '#' }}" class="course-accord-item gap-5 hover:bg-slate-100 group/curriculum" aria-label="Course curriculum">
                                <div class="flex items-center gap-2 font-medium group-hover/curriculum:text-primary duration-200 grow">
                                    <i class="ri-a-b"></i>
                                    <span class="-mb-1 line-clamp-1">{{ $topic?->topicable?->title }}</span>
                                </div>
                                <div class="text-primary text-sm flex items-center justify-center gap-4 shrink-0">{{ translate('Assignment') }}</div>
                            </a>
                        @endif

                        @if ($topic?->topicable?->topic_type?->slug == 'quiz')
                            <a href="{{ authCheck() ? route('play.course', $course->slug . '?type=' . $topic?->topicable?->topic_type?->slug . '&item=' . $topic->id) : '#' }}" class="course-accord-item gap-5 hover:bg-slate-100 group/curriculum" aria-label="Course curriculum">
                                <div class="flex items-center gap-2 font-medium group-hover/curriculum:text-primary duration-200 grow">
                                    <i class="ri-questionnaire-line"></i>
                                    <span class="-mb-1 line-clamp-1">{{ $topic?->topicable?->title }}</span>
                                </div>
                                <div class="text-primary text-sm flex items-center justify-center gap-4 shrink-0">{{ translate('Quiz') }}</div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>