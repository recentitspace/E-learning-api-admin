<?php

namespace Modules\LMS\Repositories\Financial;

use Modules\LMS\Enums\PayoutStatus;
use Modules\LMS\Models\Auth\Instructor;
use Modules\LMS\Models\Financial\Payout;
use Modules\LMS\Models\Auth\Organization;
use Modules\LMS\Repositories\BaseRepository;

class PayoutRepository extends BaseRepository
{
    protected static $model = Payout::class;
    public static function payoutRequest()
    {
        $user  = authCheck();
        $payout =  static::$model::create([
            'payout_number' => strtoupper(orderNumber(prefix: 'cs')),
            'user_id' =>  $user->id,
            'amount' =>  $user?->userable?->user_balance,
            'status' => PayoutStatus::PENDING,
        ]);

        if (!$payout) {
            return [
                'status' => 'error',
                'message' => translate('Request not Successfully ')
            ];
        }

        self::userBalanceUpdate($user);
        return [
            'status' => 'success',
            'message' => translate('Request Successfully')
        ];
    }
    public static function userBalanceUpdate($user)
    {
        switch ($user->guard) {
            case 'organization':
                $organization = Organization::where('id', $user->userable->id)->first();
                $organization->update([
                    'user_balance' =>  0
                ]);
                break;
            case 'instructor':
                $instructor = Instructor::where('id', $user->userable->id)->first();
                $instructor->update([
                    'user_balance' =>  0
                ]);
                break;
        }
    }
    public static function payoutReport()
    {
        $data['total_request_amount'] =  static::$model::where('user_id', authCheck()->id)->sum('amount');
        $data['total_pending_amount'] =  static::$model::where(['user_id' => authCheck()->id, 'status' => PayoutStatus::PENDING])->sum('amount');
        $data['total_paid_amount'] =  static::$model::where(['user_id' => authCheck()->id, 'status' => PayoutStatus::APPROVED])->sum('amount');
        return $data;
    }
    public static function adminReport(): array
    {
        $data['total_request_amount'] =  static::$model::sum('amount');
        $data['total_pending_amount'] =  static::$model::where(['status' => PayoutStatus::PENDING])->sum('amount');
        $data['total_paid_amount'] =  static::$model::where(['status' => PayoutStatus::APPROVED])->sum('amount');
        return $data;
    }

    public static function statusChange($id, $request)
    {
        $payout = static::$model::firstWhere('id', $id);
        $payout->update([
            'status' => $request->status
        ]);

        if (!$payout) {
            return [
                'status' => 'error',
                'message' => translate('Wrong Request')
            ];
        }

        return [
            'status' => 'success',
            'type' => true
        ];
    }
}
