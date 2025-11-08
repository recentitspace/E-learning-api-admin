<article>
    <h2 class="area-title text-xl mb-5">
        {{ translate('Course Assignments') }}
    </h2>
    <div class="overflow-x-auto">
        <table class="table-auto w-full whitespace-nowrap border-separate border-spacing-x-0 border-spacing-y-2">
            <tbody>
                @foreach ($assignments as $key => $assignment)
                    <tr>
                        <td class="px-4 py-3 rounded-row-border">
                            <div class="flex items-center gap-2">
                                <i class="ri-draft-line"></i>
                                <h6 class="area-title text-base !leading-none font-bold">
                                    {{ $key + 1 }} . {{ $assignment?->topicable?->title }}
                                </h6>
                            </div>
                        </td>
                        <td class="px-4 py-3 rounded-row-border">
                            {{ customDateFormate($assignment?->created_at, 'D m Y') }}
                        </td>
                        <td class="px-4 py-3 rounded-row-border">
                            @php
                                $userExam = userAssignmentCheck($assignment?->topicable->id);
                                $passMark = $assignment?->topicable?->pass_mark ?? null;
                                $class = 'badge-warning-outline';
                                $status = 'pending';
                                if ($userExam && $passMark <= $userExam->score) {
                                    $class = 'badge-success-outline';
                                    $status = 'Pass';
                                } elseif ($userExam && $passMark > $userExam->score) {
                                    $class = 'badge-danger-outline';
                                    $status = 'Failed';
                                } else {
                                    $class = 'badge-primary-outline';
                                    $status = 'No Submit';
                                }
                            @endphp
                            <span
                                class="badge {{ $class }} b-outline rounded-full">{{ translate($status) }}</span>
                        </td>
                        <td class="px-4 py-3 rounded-row-border w-10">
                            <a href="{{ route('exam.start', ['course_id' => $assignment->course_id, 'type' => 'assignment', 'exam_type_id' => $assignment?->topicable->id]) }}"
                                class="btn b-light btn-primary-light btn-sm !rounded-full"
                                aria-label="View assignment link">
                                <i class="ri-eye-line"></i>
                                {{ translate('View') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</article>
