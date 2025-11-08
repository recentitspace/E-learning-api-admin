<?php

namespace Modules\LMS\Http\Controllers\Admin\Courses\Topics;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Courses\Topics\Assignment\AssignmentRepository;
use Modules\LMS\Repositories\Courses\Topics\TopicRepository;
use Modules\LMS\Repositories\Courses\TopicTypeRepository;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected TopicRepository $topic,
        protected TopicTypeRepository $topicType,
        protected AssignmentRepository $assignment
    ) {}

    public function index(): JsonResponse
    {
        //
        $topics = $this->topic->get(options: [], relations: ['topicable.topic_type']);
        return response()->json($topics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $topic = $this->topic->save($request);

        if ($topic['status'] == 'success') {
            toastr()->success(translate('Topic has been saved successfully!'));
        }
        return response()->json($topic);
    }

    /**
     * Show the specified resource.
     */
    public function show($id): JsonResponse
    {
        $topic = $this->topic->first($id, relations: ['topicable.topic_type']);
        return response()->json($topic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request): JsonResponse
    {
        //
        $topic = $this->topic->topicUpdate($id, $request);
        return response()->json($topic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        //
        $topic = $this->topic->delete(id: $id);

        return response()->json($topic);
    }

    /**
     * topicType
     *
     * @param  string  $type
     * @param  mixed  $request
     */
    public function topicType($type, Request $request)
    {

        $courseId = $request->course_id;
        $actionType = $request->action_type ?? '';
        $chapterId = $request->chapter_id ?? '';
        $topic = '';

        if (isset($request->topic_id)) {
            $topic = $this->topic->first($request->topic_id)['data'] ?? '';
        }

        $chapters = $this->topic->chapterGetByCourseId($courseId);
        $topicId = $this->topicType->getTopicTypeId($type);

        $viewData = compact('type', 'chapters', 'courseId', 'topicId', 'topic', 'chapterId', 'actionType');
        $renderedView = view('portal::admin.course.topic-type.topic-type', $viewData)->render();

        return response()->json([
            'status' => 'success',
            'data' => $renderedView
        ]);
    }

    /**
     *  topicSorted
     */
    public function topicSorted(Request $request)
    {
        $chapter = $this->topic->topicSorted($request);

        return response()->json($chapter);
    }

    /**
     *  assignmentFileDelete
     *
     * @param  $id  $id [assignment id]
     */
    public function assignmentFileDelete($id)
    {
        $chapter = $this->assignment->assignmentFileDelete($id);

        return response()->json($chapter);
    }
}
