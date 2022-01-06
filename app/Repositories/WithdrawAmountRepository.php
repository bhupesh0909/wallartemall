<?php

namespace App\Repositories;

use App\Models\WithdrawAmount;
use App\Repositories\BaseRepository;
use App\User;

/**
 * Class Withdraw_amountRepository
 * @package App\Repositories
 * @version December 11, 2019, 4:40 pm UTC
 */
class WithdrawAmountRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'amount',
        'is_released'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WithdrawAmount::class;
    }

    public function GetWithdrawAmountList()
    {
        return WithdrawAmount::with('user')->paginate(100);
    }

    public function WithdrawAmountTransaction($request)
    {
        $get_user_details = User::select('total_amount', 'redeem')->where('id', $request['user_id'])->get();

        if ($get_user_details[0]['total_amount'] >= $request['amount']) {
            User::where('id', $request['user_id'])->update([
                'total_amount' => $get_user_details[0]['total_amount'] - $request['amount'],
//                'redeem' => $get_user_details[0]['redeem'] + $request['amount']
            ]);

            return WithdrawAmount::create([
                'user_id' => $request['user_id'],
                'amount' => $request['amount'],
                'deductions' => $request['total_deduction'],
                'net_amount' => $request['amount_after_deduction']
            ]);
        } else {
            return false;
        }

    }

    public function UpdateUnderProcess($w_id)
    {
        dd($w_id);
    }

    public function UpdateReleaseStatus($w_id)
    {
        $w_details = WithdrawAmount::where('id', $w_id)->first();
        if ($w_details->is_released == "pending") {
            WithdrawAmount::where('id', $w_id)->update(['is_released' => 'checked']);
            return 2;
        } else {
            $user_redeem = User::select('redeem')->where('id', $w_details->user_id)->pluck('redeem');
            if(!empty($user_redeem->toArray())){
                $total_redeem = $user_redeem[0] + $w_details->amount;
                User::where('id', $w_details->user_id)->update(['redeem' => $total_redeem]);
                return WithdrawAmount::where('id', $w_id)->update(['is_released' => 'released']);
            }else{
                return false;
            }
        }
    }

    public function CalculateTransactionFees($amount)
    {
        dd($amount);
    }

}
