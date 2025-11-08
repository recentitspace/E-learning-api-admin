<?php

namespace Modules\LMS\Repositories;

use Illuminate\Support\Facades\Mail;
use Modules\LMS\Classes\NotificationFormat;
use Modules\LMS\Emails\NoticesMail;
use Modules\LMS\Models\Courses\CourseNoticeboard;
use Modules\LMS\Models\Purchase\PurchaseDetails;
use Modules\LMS\Models\User;
use stdClass;

class NoticesBoardRepository extends BaseRepository
{
    protected static $model = CourseNoticeboard::class;

    protected static $modelOne = PurchaseDetails::class;

    protected static $modelTwo = User::class;

    protected static $exactSearchFields = [];

    protected static $excludedFields = [
        'save' => ['_token', 'id', 'message'],
        'update' => ['_token', 'id', 'message'],
    ];

    protected static $rules = [
        'save' => [
            'title' => 'required|string',
            'message' => 'required',
            'type' => 'required',
        ],
        'update' => [
            'title' => 'required|string',
            'message' => 'required',
            'type' => 'required',
        ],
    ];

    /**
     * @param  mixed  $request
     */
    public static function save($request): array
    {
        try {
            static::$rules['save'] = [
                'course_id' => (isset($request->type) && $request->type == 'course') ? 'required' : '',
                'message' => 'required',
                'title' => 'required',
                'type' => 'required',
            ];

            $data = [
                'title' => $request->title,
                'message' => $request->message,
            ];
            $request->request->add([
                'description' => $request->message,
            ]);
            if (isset($request->id)) {
                $noticeboard = self::update($request->id, $request->all());
            } else {
                $noticeboard = parent::save($request->all());
            }

            if ($noticeboard['status'] == 'success') {
                Mail::to(self::userEmailGetByType(request: $request, data: $data))->queue(new NoticesMail($data));
            }

            return $noticeboard;
        } catch (\Throwable $th) {
            return [
                'status' => 'success',
                // 'message' => 'Email not Configured',
            ];
        }
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
     * noticesGetByUser
     *
     * @param  $item  $item
     * @return stdClass|object
     */
    public static function noticesGetByUser($item = 10)
    {
        return static::$model::where('user_id', authCheck()->id)->paginate($item);
    }

    /**
     * delete
     *
     * @param  $id  $id
     */
    public static function delete($id, $data = [], $options = [], $relations = []): array
    {
        $data = static::$model::query();
        $options = [];
        if (authCheck()) {
            $options['user_id'] = authCheck()->id;
        }
        $options['id'] = $id;
        $data = $data->where($options)->delete();
        if ($data) {
            return [
                'status' => 'success',
                'data' => translate('successfully delete',)
            ];
        }

        return [
            'status' => 'error',
            'data' => translate('Something Wrong!'),
        ];
    }

    /**
     * userEmailGetByType
     */
    public static function userEmailGetByType($request, $data = null)
    {
        switch ($request->type) {
            case 'student':
                $users = static::$modelTwo::where('guard', 'student')->get();
                if (! empty($data)) {
                    NotificationFormat::notifyToUser($users, $data);
                }

                $emails = [];

                return self::getMails($users);
            case 'instructor':
                $users = static::$modelTwo::where('guard', 'instructor')->get();
                if (! empty($data)) {
                    NotificationFormat::notifyToUser($users, $data);
                }

                $emails = [];

                return self::getMails($users);
            case 'instructor-student':
                $users = static::$modelTwo::where('guard', '!=', 'organization')->get();
                if (! empty($data)) {
                    NotificationFormat::notifyToUser($users, $data);
                }
                $emails = [];

                return self::getMails($users);
            case 'organization':
                $users = static::$modelTwo::where('guard', 'organization')->get();
                if (! empty($data)) {
                    NotificationFormat::notifyToUser($users, $data);
                }

                return self::getMails($users);
            case 'course':
                $enrollments = static::$modelOne::with('user')->where('course_id', $request->course_id)->get();

                $users = [];
                $emails = [];
                foreach ($enrollments as $enrollment) {
                    array_push($emails, $enrollment?->user?->email);
                    array_push($users, $enrollment?->user);
                }
                if (! empty($data)) {
                    NotificationFormat::notifyToUser($users, $data);
                }

                return $emails;
        }
    }

    /**
     *  getMails
     */
    public static function getMails($users): array
    {
        $emails = [];
        foreach ($users as $user) {
            array_push($emails, $user?->email);
        }

        return $emails;
    }
}
