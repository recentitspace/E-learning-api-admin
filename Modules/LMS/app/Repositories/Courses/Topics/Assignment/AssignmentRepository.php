<?php

namespace Modules\LMS\Repositories\Courses\Topics\Assignment;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\LMS\Models\Courses\TopicType;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\Courses\Topics\Assignment;
use Modules\LMS\Models\Courses\Topics\AssignmentFile;

class AssignmentRepository extends BaseRepository
{
    protected static $model = Assignment::class;
    protected static $exactSearchFields = [];

    // Define allowed file extensions for uploaded files.
    protected static $allowedFileExtensions = ['pdf', 'txt', 'csv', 'zip', 'docx'];

    protected static $rules = [
        'save' => [
            'chapter_id' => 'required',
            'title' => 'required',
            'duration' => 'required',
            'submission_date' => 'required',
            'topic_type' => 'required',
            'source_files' => 'required',
            'description' => 'required',
        ],
        'update' => [
            'chapter_id' => 'required',
            'topic_type' => 'required',
            'title' => 'required',
            'description' => 'required',
            'duration' => 'required',
            'submission_date' => 'required',

        ],
    ];

    protected static $excludedFields = [
        'save' => ['chapter_id', 'topic_type', 'source_files', '_token', 'chapter_id', 'course_id'],
        'update' => ['chapter_id', 'topic_type', 'source_files', '_token', 'chapter_id', 'course_id', 'assignment_id'],
    ];

    /**
     * @param Request $request
     */
    public static function save($request): array
    {

        // Add the topic_type_id to the request based on the provided topic_type.
        self::addTopicTypeId($request);
        // Determine whether to update an existing record or create a new one.
        $response = isset($request->assignment_id)
            ? self::update($request->assignment_id, $request->all())
            : parent::save($request->all());

        if ($response['status'] === 'success') {
            $topicData = [
                'chapter_id' => $request->chapter_id,
                'course_id' => $request->course_id,
            ];
            self::fileSave($response['data']->id, $request->source_files);
            isset($request->assignment_id)
                ? $response['data']->topic()->update($topicData)
                : $response['data']->topic()->create($topicData);
        }

        return $response;
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        return parent::update($id, $data);
    }


    /**
     * Add topic_type_id to the request data.
     * 
     * @param Request $request The incoming request.
     */
    protected static function addTopicTypeId($request)
    {
        // Assuming topicType is a method that maps topic_type to a corresponding ID.
        $request->request->add([
            'topic_type_id' => self::topicType($request->topic_type),
        ]);
    }

    /**
     * topicType
     *
     * @param  string  $typeName
     * @return int
     */
    public static function topicType($typeName)
    {
        $topicType = TopicType::where('slug', $typeName)->select('id')->first();

        return $topicType->id;
    }

    /**
     * Handle the upload of multiple files.
     * 
     * @param array $sourceFiles The array of files to be processed.
     * @param int|null $assignmentId The ID of the related assignment, if applicable.
     * @param int|null $examId The ID of the related exam, if applicable.
     *  */
    public static function fileSave($assignmentId, $sourceFiles, $examId = null, $fileTile = null)
    {
        // Check if there are files to process.
        if (empty($sourceFiles)) {
            return;
        }
        // Iterate over each file and process it individually.
        foreach ($sourceFiles as $sourceFile) {
            // Check if the file is valid (allowed extension).
            if (self::isValidFile($sourceFile)) {
                // Generate a unique filename for storage.
                $fileName = self::generateFileName($sourceFile);

                // Store the file in the designated directory.
                self::storeFile($sourceFile, $fileName);

                // Create a database record for the stored file.
                self::createFileRecord($fileName, $assignmentId, $examId, $fileTile);
            }
        }
    }

    /**
     * Delete an assignment file by its ID.
     * 
     * @param int $id The ID of the assignment file to delete.
     * @return array The result of the deletion operation, including status and message.
     */
    public function assignmentFileDelete($id)
    {
        $assignmentFile = AssignmentFile::where('id', $id)->first();
        if (!$assignmentFile) {
            return [
                'status' => 'error',
                'data' => 'Something Wrong!',
            ];
        }
        parent::fileDelete(folder: 'lms/courses/topics/assignments', file: $assignmentFile->file);
        $assignmentFile->delete();
        return [
            'status' => 'success',
            'data' => 'delete successfully',
        ];
    }

    public static function getById($id, $courseId)
    {
        return static::$model::withWhereHas('topic', function ($query) use ($courseId) {
            $query->with(['chapter.course' => function ($query) {
                $query->select('id', 'title', 'slug');
            }])
                ->where('course_id', $courseId);
        })->where('id', $id)->first();
    }

    /**
     *  deleteSource
     *
     * @param  int  $id
     */
    public static function deleteSource($id)
    {
        // Retrieve all files associated with the given exam ID.
        $sourceFiles = AssignmentFile::where('user_exam_id', $id)->get();

        // If no files are found, return false.
        if ($sourceFiles->isEmpty()) {
            return false;
        }
        // Loop through each file, delete from storage and then from the database.
        foreach ($sourceFiles as $sourceFile) {
            parent::fileDelete(folder: 'lms/courses/topics/assignments', file: $sourceFile->file);
            $sourceFile->delete();
        }
    }

    /**
     * Validate if the file has an allowed extension.
     * 
     * @param object $file The file to validate.
     * @return bool True if the file is valid, false otherwise.
     */
    protected static function isValidFile($file)
    {
        // Ensure the file is set and retrieve its extension.
        if (!$file) {
            return false;
        }

        $extension = $file->getClientOriginalExtension();

        // Check if the file's extension is in the list of allowed extensions.
        return in_array($extension, static::$allowedFileExtensions);
    }

    /**
     * Generate a unique filename for the file.
     * 
     * @param object $file The file for which to generate a name.
     * @return string The generated filename.
     */
    protected static function generateFileName($file)
    {
        // Generate a random 8-character string and append the original file name,
        // replacing spaces with hyphens for URL safety.
        return Str::random(8) . '.' . str_replace(' ', '-', $file->getClientOriginalName());
    }

    /**
     * Store the file in the specified directory.
     * 
     * @param object $file The file to store.
     * @param string $fileName The name to save the file as.
     */
    protected static function storeFile($file, $fileName)
    {
        // Store the file in the 'public/lms/courses/topics/assignments/' directory
        // under the 'LMS' disk configuration.
        $file->storeAs('public/lms/courses/topics/assignments/', $fileName, 'LMS');
    }

    /**
     * Create a database record for the stored file.
     * 
     * @param string $fileName The name of the stored file.
     * @param int|null $assignmentId The ID of the related assignment, if applicable.
     * @param int|null $examId The ID of the related exam, if applicable.
     */
    protected static function createFileRecord($fileName, $assignmentId = null, $examId = null, $fileTile = null)
    {
        // Insert a new record in the database for the uploaded file.
        AssignmentFile::create([
            'assignment_id' => $assignmentId, // Store the assignment ID if provided.
            'user_exam_id' => $examId,        // Store the exam ID if provided.
            'file' => $fileName,
            'file_name' => $fileTile           // Store the generated filename.
        ]);
    }
}
