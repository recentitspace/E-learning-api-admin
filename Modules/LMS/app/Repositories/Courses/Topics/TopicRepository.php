<?php

namespace Modules\LMS\Repositories\Courses\Topics;

use Illuminate\Support\Facades\Validator;
use Modules\LMS\Enums\TopicTypes;
use Modules\LMS\Models\Courses\Topic;
use Modules\LMS\Models\Courses\Topics\Assignment;
use Modules\LMS\Models\Courses\Topics\Quiz;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Repositories\Courses\ChapterRepository;
use Modules\LMS\Repositories\Courses\Topics\Assignment\AssignmentRepository;
use Modules\LMS\Repositories\Courses\Topics\Quizzes\QuizRepository;
use Modules\LMS\Repositories\Courses\Topics\Reading\ReadingRepository;
use Modules\LMS\Repositories\Courses\Topics\Video\VideoRepository;

class TopicRepository extends BaseRepository
{
    protected static $model = Topic::class;


    protected static $exactSearchFields = [];

    protected static $rules = [
        'save' => [],
        'update' => [],
    ];

    protected static $excludedFields = [
        'save' => ['description'],
        'update' => ['description'],
    ];

    /**
     * Method save
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {

        try {
            $response = match ($request->topic_type) {
                TopicTypes::SUPPLEMENT => SupplementRepository::save($request),
                TopicTypes::QUIZ => QuizRepository::save($request),
                TopicTypes::VIDEO => VideoRepository::save($request),
                TopicTypes::ASSIGNMENT => AssignmentRepository::save($request),
                TopicTypes::READING => self::saveReading($request),
                default => [
                    'status' => 'error',
                    'data' => translate('Invalid topic type')
                ]
            };

            return $response['status'] === 'success'
                ? ['status' => 'success', 'type' => 'course']
                : $response;
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'data' => $th->getMessage()
            ];
        }
    }

    /**
     * Save Reading data with validation
     *
     * @param  mixed  $request
     * @return array
     */
    protected static function saveReading($request): array
    {
        static::$rules['save'] = [
            'title' => 'required',
            'description' => 'required',
            'chapter_id' => 'required',
        ];

        $validator = Validator::make($request->all(), static::$rules['save']);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray()
            ];
        }

        return ReadingRepository::save($request);
    }

    /**
     * @param  int  $id
     * @param  mixed  $request
     */
    public function topicUpdate($id, $request)
    {
        try {
            $data = match ($request->topic_type) {
                TopicTypes::SUPPLEMENT => $this->updateOrCreateTopic(
                    SupplementRepository::class,
                    $request->supplement_id,
                    $request->all(),
                    $request->chapter_id,
                    'update'
                ),
                TopicTypes::QUIZ => $this->updateOrCreateTopic(
                    QuizRepository::class,
                    $request->quiz_id,
                    $request->all(),
                    $request->chapter_id,
                    'create'
                ),
                default => ['status' => 'error', 'data' =>  translate('Invalid topic type')],
            };

            return $data;
        } catch (\Throwable $th) {
            return ['status' => 'error', 'data' => $th->getMessage()];
        }
    }

    /**
     * Helper method to handle topic update or creation.
     *
     * @param  string  $repositoryClass
     * @param  mixed   $id
     * @param  array   $data
     * @param  int     $chapterId
     * @param  string  $operation  'update' or 'create'
     * @return array
     */
    protected function updateOrCreateTopic($repositoryClass, $id, array $data, int $chapterId, string $operation): array
    {
        $repository = new $repositoryClass();
        $response = $repository->update($id, $data);

        if ($response['status'] !== 'success') {
            return $response;
        }
        $topic = $response['data']->topic();
        return $operation === 'update'
            ? $topic->update(['chapter_id' => $chapterId])
            : $topic->create(['chapter_id' => $chapterId]);
    }

    /**
     * topicSorted
     *
     * @param  mixed  $request
     * @return array
     */
    public function topicSorted($request)
    {
        if (!is_array($request->itemIds)) {
            return [
                'status' => 'error',
                'data' => 'Something went wrong!',
            ];
        }

        $order = 1;
        // Using bulk updates with mapped orders for efficiency
        $topics = static::$model::whereIn('id', $request->itemIds)->get();
        foreach ($topics as $topic) {
            $topic->update(['order' => $order++]);
        }

        return [
            'status' => 'success',
            'data' => translate('Sorted Successfully'),
        ];
    }

    /**
     * chapterGetByCourseId
     *
     * @param  int  $courseId
     * @return object
     */
    public static function chapterGetByCourseId($courseId)
    {
        return ChapterRepository::getChapterByCourse($courseId);
    }

    /**
     *  getTopicByCourse
     *
     * @param  array  $coursesId  []
     * @param  int  $item  [pagination item]
     */
    public static function getTopicByCourse($coursesId, $type, $item = null)
    {
        if (!$coursesId) {
            return false;
        }
        $topic = Topic::query();

        if ($type == 'quiz') {
            $topic->whereHasMorph('topicable', [Quiz::class]);
        }
        if ($type == 'assignment') {
            $topic->whereHasMorph('topicable', [Assignment::class]);
        }

        if (is_array($coursesId)) {
            $topic->with('course', 'topicable')
                ->whereIn('course_id', $coursesId);
        } else {
            $topic->with('course', 'topicable')
                ->where('course_id', $coursesId);
        }
        return $item ? $topic->paginate($item) : $topic->get();
    }


    /**
     *  delete
     *
     * @param  int  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $topic = static::$model::with('topicable.topic_type')->where('id', $id)->first();
        if (!$topic) {
            return [
                'status' => 'error',
                'data' => 'Something Wrong!',
            ];
        }
        if ($topic->topicable->topic_type->slug == 'video') {
            parent::fileDelete(folder: 'lms/courses/topics/videos', file: $topic?->topicable?->system_video);
        }
        if ($topic->topicable->topic_type->slug == 'assignment') {
            foreach ($topic?->topicable?->sourceFiles as $sourceFile) {
                if (! empty($sourceFile)) {
                    parent::fileDelete(folder: 'lms/courses/topics/assignments', file: $sourceFile->file);
                }
            }
            $topic?->topicable?->sourceFiles()->delete();
        }

        if ($topic->topicable->topic_type->slug == 'quiz') {
            $topic?->topicable?->questions()->delete();
        }
        $topic->topicable->delete();
        $topic->delete();
        return [
            'status' => 'success',
            'data' => translate('Delete Successfully'),
            'type' => 'topic',
        ];
    }
}
