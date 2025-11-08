<?php

namespace Modules\LMS\Repositories\SupportTicket;

use Illuminate\Support\Str;
use Modules\LMS\Models\User;
use Illuminate\Support\Facades\Validator;
use Modules\LMS\Repositories\BaseRepository;
use Modules\LMS\Models\SupportTicket\SupportFile;
use Modules\LMS\Models\SupportTicket\TicketReply;
use Modules\LMS\Models\SupportTicket\CourseSupport;
use Modules\LMS\Models\SupportTicket\TicketSupport;

class SupportRepository extends BaseRepository
{
    protected static $model = TicketSupport::class;

    protected static $excludedFields = [
        'save' => ['_token', 'support_files', 'course_id'],
        'update' => ['_token', '_method', 'support_files', 'course_id'],
    ];

    protected static $rules = [
        'save' => [],
        'update' => [],
    ];

    /**
     * statusChange
     *
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        self::validation($request, $type = 'save');
        $request->request->add([
            'user_id' => authCheck()->id, // Get the authenticated user's ID
            'ticket_code' => strRandom(4, 'int'), // Generate a random ticket code
        ]);
        $ticket = parent::save($request->all());
        if ($ticket['status'] == 'success') {
            self::attachFiles($ticket['data'], $request->support_files);
            if ($request->type == 'course') {
                $ticket['data']->courseSupport()->create([
                    'course_id' => $request->course_id,
                    'type' => isStudent() ? 'student' : ""
                ]);
            }
        }

        return $ticket;
    }

    /**
     *  delete
     *
     * @param  $id  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $forum = parent::first($id);
        if ($forum['status'] == 'success') {
            $forum['data']->delete();
        }

        return $forum;
    }

    /**
     * attachFiles
     *
     * @param  int  $courseId
     * @param  array AttachFiles
     * @return void
     */
    public static function attachFiles($ticket, $files)
    {
        if (! empty($files)) {
            foreach ($files as $file) {
                $image = Str::random(8) . '.' . str_replace(' ', '-', $file->getClientOriginalName());
                $file->storeAs('public/lms/supports/', $image, 'LMS');
                $ticket->supportFiles()->create(
                    [
                        'file' => $image,
                    ]
                );
            }
        }
    }

    /**
     *  validation
     *
     * @param  mixed  $request
     * @param  string  $type
     */
    public static function validation($request, $type = 'save')
    {
        static::$rules[$type] = [
            'course_id' => $request->type == 'course' ? 'required' : '',
            'support_category_id' => $request->type == 'platform' ? 'required' : '',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ];
    }

    /**
     * statusChange
     *
     * @param  int id
     */
    public function statusChange($id): array
    {
        $forum = parent::first($id);
        $forum = $forum['data'];
        $forum->status = ! $forum->status;
        $forum->update();

        return ['status' => 'success', 'message' => translate('Status Change Successfully')];
    }

    /**
     *  getSupports
     *
     * @param  int  $item
     * @param  string  $type
     * @return object
     */
    public function getSupports($item = 10, $type = 'platform')
    {
        $ticketSupports = TicketSupport::query();
        if (authCheck()) {
            $ticketSupports->where('user_id', authCheck()->id);
        }

        return $ticketSupports->with('user', 'supportCategory')
            ->with(
                ['courseSupport.course' => function ($query) {
                    $query->with('instructors.userable')->select('id', 'title');
                }]
            )
            ->where('type', $type)
            ->paginate($item);
    }

    /**
     *  firstTicketById
     *
     * @param  int  $int
     * @return object
     */
    public function firstTicketById($id)
    {
        return TicketSupport::with('replies.author', 'replies.supportFiles', 'replies.user.userable')
            ->firstWhere('id', $id);
    }

    /**
     *  firstTicketById
     *
     * @param  mixed  $request
     * @return array
     */
    public function ticketReply($request)
    {

        $validator = Validator::make($request->all(), [
            'description' => 'required',
        ]);
        // If validation failed then return the error.
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }


        $ticket = TicketReply::create([
            'ticket_support_id' => $request->ticket_id,
            'description' => $request->description,
            'author_id' => isAdmin() ? $request->user()->id : null,
            'user_id' => !isAdmin() ? $request->user()->id : null
        ]);

        if ($request->support_files) {
            self::attachFiles($ticket, $request->support_files);
        }


        return ['status' => 'success'];
    }

    /**
     *  deleteSupportFile
     *
     * @param  int  $id
     * @return array
     */
    public function deleteSupportFile($id)
    {
        $supportFile = SupportFile::firstWhere('id', $id);
        if (!$supportFile) {
            return [
                'status' => 'error',
                'message' => '!Something Wrong.'
            ];
        }
        parent::fileDelete('lms/supports', $supportFile->file);
        $supportFile->delete();
        return [
            'status' => 'success',
            'message' => 'Delete Successfully.'
        ];
    }


    public function ticketClose($ticketCode): array
    {

        $ticketSupport = TicketSupport::where('ticket_code', $ticketCode)->first();
        $ticketSupport->status = 'close';
        $ticketSupport->update();
        return [
            'status' => 'success',
            'message' => 'Delete Successfully.'
        ];
    }


    public function instructorStudentSupport()
    {
        $user = User::with('courses', 'userable')->where('id', authCheck()->id)->first();
        $courseId = $user->courses->count() > 0  ? $user->courses->pluck('id')->toArray() : [];
        return  CourseSupport::with('support.user.userable')->whereIn('course_id',   $courseId)->where('type', 'student')->paginate(10);
    }
}
