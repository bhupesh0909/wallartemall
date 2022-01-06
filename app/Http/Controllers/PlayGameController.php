<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePlayGameRequest;
use App\Http\Requests\UpdatePlayGameRequest;
use App\Models\GameType;
use App\Repositories\PlayGameRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use DB, DataTables;
use Flash;
use Response;

class PlayGameController extends AppBaseController
{
    /** @var  PlayGameRepository */
    private $playGameRepository;

    public function __construct(PlayGameRepository $playGameRepo)
    {
        $this->playGameRepository = $playGameRepo;
    }

    /**
     * Display a listing of the PlayGame.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
       // $playGames = $this->playGameRepository->paginate(100);
				
		$playGames = DB::table('play_games')
                    ->join('users', 'play_games.user_id', '=', 'users.id')
                    ->leftJoin('game_winner', 'play_games.id', '=', 'game_winner.game_id')
					->select('game_winner.game_type' , 'users.username' , 'play_games.entry_fee' , 'play_games.game_id' , 'play_games.total_players' , 'play_games.created_at' , 'game_winner.status')
					->paginate(15);
					
        return view('play_games.index')
            ->with('playGames', $playGames);
    }

    public function datatable(Request $req){
        // dd($req->all());
        $cols = ['play_games.game_type' , 'users.username' , 'play_games.entry_fee' , 'play_games.game_id' , 'play_games.total_players' , 'play_games.created_at' , 'game_winner.status'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = DB::table('play_games')
                        ->join('users', 'play_games.user_id', '=', 'users.id')
                        ->leftJoin('game_winner', 'play_games.id', '=', 'game_winner.game_id')
                        ->select($cols)->count();
        $data = DB::table('play_games')
                    ->join('users', 'play_games.user_id', '=', 'users.id')
                    ->leftJoin('game_winner', 'play_games.id', '=', 'game_winner.game_id')
                    ->leftJoin('game_types', 'game_types.id', '=', 'play_games.game_id')
					->select($cols);
        for($i = 0; $i < count($cols); $i++){
            $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
        }
        // if(isset($start) && isset($length)){
        //     $userRegistrations = $userRegistrations->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('play_games.id', 'DESC');
        }
        $data = $data->get();
        return DataTables::of($data)->make(true);
    }
    /**
     * Show the form for creating a new PlayGame.
     *
     * @return Response
     */
    public function create()
    {
        $gameType = GameType::get();
        return view('play_games.create',compact('gameType'));
    }

    /**
     * Store a newly created PlayGame in storage.
     *
     * @param CreatePlayGameRequest $request
     *
     * @return Response
     */
    public function store(CreatePlayGameRequest $request)
    {
        $input = $request->all();

        $playGame = $this->playGameRepository->create($input);

        Flash::success('Play Game saved successfully.');

        return redirect(route('playGames.index'));
    }

    /**
     * Display the specified PlayGame.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            Flash::error('Play Game not found');

            return redirect(route('playGames.index'));
        }

        return view('play_games.show')->with('playGame', $playGame);
    }

    /**
     * Show the form for editing the specified PlayGame.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            Flash::error('Play Game not found');

            return redirect(route('playGames.index'));
        }

        return view('play_games.edit')->with('playGame', $playGame);
    }

    /**
     * Update the specified PlayGame in storage.
     *
     * @param int $id
     * @param UpdatePlayGameRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlayGameRequest $request)
    {
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            Flash::error('Play Game not found');

            return redirect(route('playGames.index'));
        }

        $playGame = $this->playGameRepository->update($request->all(), $id);

        Flash::success('Play Game updated successfully.');

        return redirect(route('playGames.index'));
    }

    /**
     * Remove the specified PlayGame from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $playGame = $this->playGameRepository->find($id);

        if (empty($playGame)) {
            Flash::error('Play Game not found');

            return redirect(route('playGames.index'));
        }

        $this->playGameRepository->delete($id);

        Flash::success('Play Game deleted successfully.');

        return redirect(route('playGames.index'));
    }
}
