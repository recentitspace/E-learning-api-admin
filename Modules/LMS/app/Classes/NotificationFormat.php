<?php

namespace Modules\LMS\Classes;

use Illuminate\Support\Facades\Notification;
use Modules\LMS\Enums\NotificationFormatStatus;
use Modules\LMS\Models\General\NotificationTemplate;
use Modules\LMS\Notifications\NotifyAdmin;

class NotificationFormat
{
    protected static $model = NotificationTemplate::class;

    private static $instance;

    public static function notificationToAdmin($senderTo, $data)
    {
        try {

            $notification = static::$model::firstWhere('template_name', NotificationFormatStatus::USER_REGISTERED);
            $body = str_replace(['[user_name]', '[user_role]', '[time_date]'], [$data['user_name'], $data['role'], $data['created_at']], $notification->description);
            $bodyContent = [
                'title' => $notification->title,
                'message' => $body,
            ];
            self::sendNotification($senderTo, $bodyContent);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function notifyAccountStatus($senderTo, $data)
    {
        try {

            $notification = static::$model::firstWhere('template_name', NotificationFormatStatus::ACCOUNT_STATUS);
            $body = str_replace(['[_status_]'], [$data['status']], $notification->description);
            $bodyContent = [
                'title' => str_replace(['[_status_]'], [$data['status']], $notification->title),
                'message' => $body,
            ];
            self::sendNotification($senderTo, $bodyContent);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function notifyToUser($senderTo, $data)
    {
        try {

            Notification::send($senderTo, new NotifyAdmin($data));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function sendNotification($senderTo, $bodyContent)
    {
        Notification::send($senderTo, new NotifyAdmin($bodyContent));
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new NotificationFormat;
        }

        return self::$instance;
    }
}
