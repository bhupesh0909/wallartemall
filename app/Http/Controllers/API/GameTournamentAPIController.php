<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGameTournamentAPIRequest;
use App\Http\Requests\API\UpdateGameTournamentAPIRequest;
use App\Models\GameType;
use App\Models\GameTournament;
use App\Models\TournamentRegistration;
use App\Repositories\GameTournamentRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

/**
 * Class GameTournamentController
 * @package App\Http\Controllers\API
 */
class GameTournamentAPIController extends AppBaseController
{
    /** @var  GameTournamentRepository */
    private $gameTournamentRepository;
    private $user;

    private $tournamentRegistration;

    public function __construct(GameTournamentRepository $gameTournamentRepo, User $user, TournamentRegistration $tournamentRegistration)
    {
        $this->gameTournamentRepository = $gameTournamentRepo;
        $this->user = $user;
        $this->tournamentRegistration = $tournamentRegistration;
    }

    /**
     * Display a listing of the GameTournament.
     * GET|HEAD /gameTournaments
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $gameTournaments = $this->gameTournamentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($gameTournaments->toArray(), 'Game Tournaments retrieved successfully');
    }

    /**
     * Store a newly created GameTournament in storage.
     * POST /gameTournaments
     *
     * @param CreateGameTournamentAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateGameTournamentAPIRequest $request)
    {
        $input = $request->all();

        $gameTournament = $this->gameTournamentRepository->create($input);

        return $this->sendResponse($gameTournament->toArray(), 'Game Tournament saved successfully');
    }

    /**
     * Display the specified GameTournament.
     * GET|HEAD /gameTournaments/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var GameTournament $gameTournament */
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            return $this->sendError('Game Tournament not found');
        }

        return $this->sendResponse($gameTournament->toArray(), 'Game Tournament retrieved successfully');
    }

    /**
     * Update the specified GameTournament in storage.
     * PUT/PATCH /gameTournaments/{id}
     *
     * @param int $id
     * @param UpdateGameTournamentAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameTournamentAPIRequest $request)
    {
        $input = $request->all();

        /** @var GameTournament $gameTournament */
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            return $this->sendError('Game Tournament not found');
        }

        $gameTournament = $this->gameTournamentRepository->update($input, $id);

        return $this->sendResponse($gameTournament->toArray(), 'GameTournament updated successfully');
    }

    /**
     * Remove the specified GameTournament from storage.
     * DELETE /gameTournaments/{id}
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var GameTournament $gameTournament */
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            return $this->sendError('Game Tournament not found');
        }

        $gameTournament->delete();

        return $this->sendSuccess('Game Tournament deleted successfully');
    }

    public function TournamentRegistration(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            // $tournament = GameType::find($request['t_id']);
            // search in all active tournaments
            $tournament = GameTournament::where('id', $request['tournament_id'])->where('start_date', '>=', DB::raw('CURDATE()'))->orWhereNull('start_date')->first();
            $totalRegistrations = TournamentRegistration::select(DB::raw("COUNT(user_id) as total_registrations"))->where('t_id', $request['tournament_id'])->groupBy('t_id')->first();
            // dd($tournament->toArray(), $totalRegistrations->toArray(),
            // isset($tournament) && $chk_valid_user && isset($totalRegistrations) && $tournament->starting_stack < $totalRegistrations->total_registrations);
			if(is_null($tournament)){
                return response::json(['status' => 0, 'tournament_registration' => null, 'message' => ['Tournament not found.']]);
            }elseif(isset($tournament) && $chk_valid_user && isset($totalRegistrations) && $tournament->starting_stack < $totalRegistrations->total_registrations){
                return response::json(['status' => 0, 'tournament_registration' => null, 'messsage' => ['Tournament full.']]);
            }elseif ($chk_valid_user) {
                $alreadyRegistered = TournamentRegistration::where('user_id',$request['user_id'])->where('t_id',$request['tournament_id'])->whereBetween('created_at', [now()->subMinutes(1), now()])->latest('created_at')->first();
                if($alreadyRegistered){
                    $existingRecord = [];
                    $existingRecord['user_id'] = $alreadyRegistered->user_id;
                    $existingRecord['tournament_id'] = $alreadyRegistered->t_id;
                    $existingRecord['created_at'] = date('Y-m-d H:i:s', strtotime($alreadyRegistered->created_at));
                    $existingRecord['updated_at'] = date('Y-m-d H:i:s', strtotime($alreadyRegistered->updated_at));
                    $existingRecord['id'] = $alreadyRegistered->id;
                    return response::json(['status' => 1, 'tournament_registration' => $existingRecord, 'message' => ['You are already registered for this tournament.']]);
                }else{
                    $UserTournamentRegistration = $this->tournamentRegistration->UserTournamentRegistration($request->all());
                    $UserTournamentRegistration->tournament_id = $UserTournamentRegistration->t_id;
                    return response::json(['status' => 1, 'tournament_registration' => $UserTournamentRegistration, 'message' => ['You are registered for up coming tournament. Please note that this will be a paid tournament kindly maintain sufficient chips during game play']]);
                }
            } else {
                return response::json(['status' => 0, 'tournament_registration' => null, 'message' => ['User not Authenticate.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'tournament_registration' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GetTournamentList($user_id = null)
    {
        try {
            $tournament_list = $this->gameTournamentRepository->TournamentList($user_id)->toArray();
            $tournament_list = array_map(function($tournament_list){
                $ret = $tournament_list;
                $ret['tournament_id'] = $ret['id'];
                $ret['total_slots'] = $ret['starting_stack'];
                $ret['is_registered'] = ($ret['is_registered'] > 0)? true : false;
                $ret['has_played'] = ($ret['has_played'] > 0)? true : false;
                $ret['banner'] = URL::to("tournament-images/{$ret['banner']}");
                unset($ret['id']);
                unset($ret['t_id']);
                return $ret;
            }, $tournament_list);
            // dd($tournament_list);
            return response::json(['status' => 1, 'tournament_list' => $tournament_list, 'message' => ['Get tournament list.']]);
        } catch (\Exception $e) {
            // dd($e);
            return response::json(['status' => 0, 'tournament_list' => null, 'message' => ['Something went wrong! Please try again.']]);
        }
    }
}
