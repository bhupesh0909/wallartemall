<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePlayGameAPIRequest;
use App\Http\Requests\API\UpdatePlayGameAPIRequest;
use App\Models\AcceptInvitation;
use App\Models\GameWinner;
use App\Models\PlayGame;
use App\Models\GameType;
use App\Repositories\PlayGameRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PlayGameController
 * @package App\Http\Controllers\API
 */
class PlayGameAPIController extends AppBaseController
{
    /** @var  PlayGameRepository */
    private $playGameRepository;
    private $user;
    private $playgames;

    public function __construct(PlayGameRepository $playGameRepo, User $user, PlayGame $playgames)
    {
        $this->playGameRepository = $playGameRepo;
        $this->user = $user;
        $this->playgames = $playgames;
    }

    /**
     * Display a listing of the PlayGame.
     * GET|HEAD /playGames
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $playGames = $this->playGameRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($playGames->toArray(), 'Play Games retrieved successfully');
    }

    /**
     * Store a newly created PlayGame in storage.
     * POST /playGames
     *
     * @param CreatePlayGameAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePlayGameAPIRequest $request)
    {
        $input = $request->all();

        $playGame = $this->playGameRepository->create($input);

        return $this->sendResponse($playGame->toArray(), 'Play Game saved successfully');
    }

    /**
     * Display the specified PlayGame.
     * GET|HEAD /playGames/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PlayGame $playGame */
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            return $this->sendError('Play Game not found');
        }

        return $this->sendResponse($playGame->toArray(), 'Play Game retrieved successfully');
    }

    /**
     * Update the specified PlayGame in storage.
     * PUT/PATCH /playGames/{id}
     *
     * @param int $id
     * @param UpdatePlayGameAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlayGameAPIRequest $request)
    {
        $input = $request->all();

        /** @var PlayGame $playGame */
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            return $this->sendError('Play Game not found');
        }

        $playGame = $this->playGameRepository->update($input, $id);

        return $this->sendResponse($playGame->toArray(), 'PlayGame updated successfully');
    }

    /**
     * Remove the specified PlayGame from storage.
     * DELETE /playGames/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PlayGame $playGame */
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            return $this->sendError('Play Game not found');
        }

        $playGame->delete();

        return $this->sendSuccess('Play Game deleted successfully');
    }

    public function PlayGame(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                // $game = GameType::where('id', $request->game_id)->exists();
                // if($game){
                if ($request->entry_fee < 0) {
                    return response::json(['status' => 0, 'play_games' => null, 'message' => ['Fees amount should be more than 0.']]);
                } elseif ($request->entry_fee == 0 && $request->game_type === 'fun') {//For Practise
                    $game_played = $this->playgames->StartGame($request->all());
                    $user = $this->user->GetAccountInfo($request->user_id);
                    $this->user->updateTotalAmount($request->user_id, $user->total_amount - $request->entry_fee);
                    $game_played->room_id = $game_played->id;
                    unset($game_played->id);
                    return response::json(['status' => 1, 'play_games' => $game_played, 'message' => ['Game Started successfully.']]);
                } else {
                    $account_statement = $this->user->AccountStatement($request->user_id, $request->entry_fee);
                    if ($account_statement) {
                        $game_played = $this->playgames->StartGame($request->all());
                        $user = $this->user->GetAccountInfo($request->user_id);
                        $game_played->room_id = $game_played->id;
                        unset($game_played->id);
                        $this->user->updateTotalAmount($request->user_id, $user->total_amount - $request->entry_fee);
                        return response::json(['status' => 1, 'play_games' => $game_played, 'message' => ['Game Started successfully.']]);
                    } else {
                        return response::json(['status' => 0, 'play_games' => null, 'message' => ['You don\'t have enough money.']]);
                    }
                }
                // }else{
                //     return response::json(['status' => 0, 'play_games' => null, 'message' => 'Game does not exists.']);
                // }
            } else {
                return response::json(['status' => 0, 'play_games' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'play_games' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GameWinner(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $game = GameType::where('id', $request->game_id)->exists();
                if ($game) {
                    if ($request->game_type == 'dealership') {
                        $count = AcceptInvitation::where('get_commission', '0')
                            ->where('send_by', $request->invited_by)->count();
                        $commission = 5;
                        $total_commission = $commission * $count;
                        $win_amount = $request->win_amount;
                        if ($win_amount < 0) {
                            return response::json(['status' => 0, 'game_winner' => null, 'message' => ['Win amount cannot be of negative value.']]);
                        }
                        $earn_commission = $win_amount * $total_commission / 100;
                        $get_commission = AcceptInvitation::where('send_by', $request->invited_by)
                            ->where('get_commission', '0')->get();
                        foreach ($get_commission as $o) {
                            AcceptInvitation::where('send_by', $request->invited_by)->where('get_commission', '0')
                                ->update(['get_commission' => '1']);
                        }
                        $total_amount = User::select('total_amount')->where('id', $request->invited_by)->first();
                        $total = $total_amount['total_amount'] + $earn_commission;
                        User::where('id', $request->invited_by)->update(['total_amount' => $total]);
                    }
                    if ($request->status == 'win') {
                        $this->playGameRepository->UpdateCash($request->user_id, $request->win_amount);
                        $game_winner = $this->playGameRepository->UserGameStatus($request->all());
                        unset($game_winner['updated_at'], $game_winner['created_at'], $game_winner['id']);
                        return response::json(['status' => 1, 'game_winner' => $game_winner, 'message' => ['You are winner of the game.']]);
                    } else {
                        $game_loss = $this->playGameRepository->UserGameStatus($request->all());
                        unset($game_loss['updated_at'], $game_loss['created_at'], $game_loss['id']);
                        return response::json(['status' => 1, 'game_winner' => $game_loss, 'message' => ['You loss the game.']]);
                    }
                } else {
                    return response::json(['status' => 0, 'game_winner' => null, 'message' => ['Game does not exists.']]);
                }
            } else {
                return response::json(['status' => 0, 'game_winner' => null, 'message' => ['User does not Authenticate.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'game_winner' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GameHistory(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $game_history = $this->playGameRepository->GetGameHistory($request->all());
                return response::json(['status' => 1, 'game_history' => $game_history, 'message' => ['Get user game history.']]);
            } else {
                return response::json(['status' => 0, 'game_winner' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'game_winner' => null, 'message' => [$e->getMessage()]]);
        }
    }
}
