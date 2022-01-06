<?php

namespace App\Repositories;

use App\Models\GameWinner;
use App\Models\PlayGame;
use App\Repositories\BaseRepository;
use App\User;

/**
 * Class PlayGameRepository
 * @package App\Repositories
 * @version November 27, 2019, 6:06 am UTC
 */
class PlayGameRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'game_type',
        'game_id',
        'user_id',
        'total_players',
        'entry_fee',
        'game_status'
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
        return PlayGame::class;
    }

    public function UserGameStatus($request)
    {
        return GameWinner::create([
            'user_id' => $request['user_id'],
            'tournament_id' => $request['tournament_id']??null,
            'room_id' => $request['room_id'],
            'game_type' => $request['game_type'],
            'game_id' => $request['game_id'],
            'status' => $request['status'],
            'win_amount' => $request['win_amount'],
        ]);
    }

    public function UpdateCash($user_id, $win_amount)
    {
        $get_user_amount = User::where('id', $user_id)->pluck('total_amount');
        $totla_amount = $get_user_amount[0] + $win_amount;
        return User::where('id', $user_id)->update(['total_amount' => $totla_amount]);
    }

    public function GetGameHistory($user_id)
    {
        return GameWinner::where('user_id', $user_id)->get();
    }
}