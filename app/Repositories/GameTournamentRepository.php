<?php

namespace App\Repositories;

use App\Models\GameTournament;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
/**
 * Class GameTournamentRepository
 * @package App\Repositories
 * @version November 22, 2019, 5:49 am UTC
 */
class GameTournamentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        't_type',
        't_id',
        't_format',
        'start_date',
        'entry',
        'starting_stack',
        'prize',
        'level',
        'no_of_prizes',
        'r_user',
        'cash_prize'
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
        return GameTournament::class;
    }

    public function TournamentList($user_id = null)
    {
        if(!isset($user_id)){
            return GameTournament::get();
        }else{
            // return GameTournament::where('user_id', $user_id);
            $cols = [
                'game_tournaments.id',
                'game_tournaments.t_format',
                'game_tournaments.t_type',
                'game_tournaments.t_id',
                'game_tournaments.t_format',
                'game_tournaments.start_date',
                'game_tournaments.entry as entry_fees',
                'game_tournaments.starting_stack',
                'game_tournaments.prize',
                'game_tournaments.no_of_prizes',
                'game_tournaments.banner',
                'tournament_registrations.user_id',
                DB::raw('COUNT(tournament_registrations.user_id) AS total_registrations'),
            ];
            if(!isset($user)){
                $cols[] = DB::raw("SUM(CASE WHEN tournament_registrations.user_id = {$user_id} THEN 1 ELSE 0 END) AS is_registered");
                $cols[] = DB::raw("SUM(CASE WHEN game_winner.user_id = {$user_id} THEN 1 ELSE 0 END) AS has_played");
            }
            $data = GameTournament::select($cols)
                                    // ->leftjoin('tournament_registrations', 'tournament_registrations.t_id', '=', 'game_tournaments.id')
                                    ->leftJoin('tournament_registrations', function($join) {
                                        $join->on('tournament_registrations.t_id', '=', 'game_tournaments.id'); 
                                      })
                                    ->leftJoin('play_games', function($join) {
                                        $join->on('tournament_registrations.t_id', '=', 'play_games.tournament_id');
                                      })
                                    ->leftJoin('game_winner', function($join) {
                                        $join->on('game_winner.tournament_id', '=', 'play_games.tournament_id');
                                        $join->on('game_winner.user_id', '=', 'play_games.user_id');
                                      })
                                    ->where('game_tournaments.start_date', '>=', DB::raw('CURDATE()'))
                                    ->groupBy('tournament_registrations.t_id')
                                    ->orderBy('game_tournaments.created_at', 'DESC');
            // dd($data->toSql());
            return $data->get();
        }
    }

    public function getTournamentLists(){
        $data = GameTournament::select('game_tournaments.id','tt.tournament_type', 'game_tournaments.t_id', 'game_tournaments.t_format', 'game_tournaments.start_date', 'game_tournaments.entry', 'game_tournaments.starting_stack', 'game_tournaments.prize', 'game_tournaments.no_of_prizes', 'game_tournaments.total_reg_users')
        ->from('game_tournaments')
        ->join('tournament_types as tt', 'game_tournaments.t_type', '=', 'tt.id')
        ->orderBy('id', 'DESC');
        return $data->get();
    }
}
