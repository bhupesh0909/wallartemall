<?php

namespace App\Repositories;

use App\Models\Chip;
use App\Repositories\BaseRepository;
use App\User;
use DB;

/**
 * Class ChipRepository
 * @package App\Repositories
 * @version December 8, 2019, 6:47 am UTC
 */
class ChipRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'chips_amount'
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
        return Chip::class;
    }

    public function GetUserDetails()
    {
        return Chip::with('users')->get();
    }
	
	
    public function GetChipDetails()
    {
        return Chip::with('users')->select('user_id',DB::raw('sum(chips_amount) as chips_amount'))->groupBy('user_id')->get();
    }

    public function UpdateChipsInUser($request)
    {
        $get_user_inplay_cash = User::where('id', $request['user_id'])->pluck('inplay_cash');
        $total_user_cash = User::where('id', $request['user_id'])->pluck('total_amount');
        $updatedCash = $total_user_cash[0]+$request['chips_amount'];
        $inplay_cash = $request['chips_amount'] + $get_user_inplay_cash[0];
        return User::where('id', $request['user_id'])->update(['inplay_cash' => $inplay_cash,'total_amount'=> $updatedCash]);
    }

    public function decreaseUserChip($user_id, $chip_amount)
    {
        $get_user_chip = User::where('id', $user_id)->pluck('inplay_cash');
        $chip = $get_user_chip[0] - $chip_amount;

        return User::where('id', $user_id)->update(['inplay_cash' => $chip]);
    }
}