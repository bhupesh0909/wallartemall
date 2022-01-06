<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameTournamentRequest;
use App\Http\Requests\UpdateGameTournamentRequest;
use App\Models\TournamentType;
use App\Repositories\GameTournamentRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class GameTournamentController extends AppBaseController
{
    /** @var  GameTournamentRepository */
    private $gameTournamentRepository;

    public function __construct(GameTournamentRepository $gameTournamentRepo)
    {
        $this->gameTournamentRepository = $gameTournamentRepo;
    }

    /**
     * Display a listing of the GameTournament.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $gameTournaments = $this->gameTournamentRepository->all();
        $gameTournaments = $this->gameTournamentRepository->getTournamentLists();
        return view('game_tournaments.index')
            ->with('gameTournaments', $gameTournaments);
    }

    /**
     * Show the form for creating a new GameTournament.
     *
     * @return Response
     */
    public function create()
    {
        $tournament_types = TournamentType::get();

        return view('game_tournaments.create', compact('tournament_types'));
    }

    /**
     * Store a newly created GameTournament in storage.
     *
     * @param CreateGameTournamentRequest $request
     *
     * @return Response
     */
    public function store(CreateGameTournamentRequest $request)
    {

        $input = $request->all();
        // dd($input, $request->file());
		$request->validate([
				't_format' => 'required',
				'start_date' => 'required',
				'entry' => 'required|max:10',
				'starting_stack' => 'required|max:10',
                'prize' => 'required|max:10',
                'banner' => 'required|mimes:jpeg,jpg,png',
		     ]
		);
		if($request->hasFile('banner')){
            $fileName = time().'.'.$request->file('banner')->getClientOriginalExtension();
            $filePath = public_path("tournament-images/{$fileName}");
            $request->banner->move(base_path('public/tournament-images/'), $filePath);
        }
        $input['t_id'] = md5(uniqid(rand(1, 8), true));
        $input['banner'] = $fileName;
        $gameTournament = $this->gameTournamentRepository->create($input);
        Flash::success('Game Tournament saved successfully.');

        return redirect(route('gameTournaments.index'));
    }

    /**
     * Display the specified GameTournament.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            Flash::error('Game Tournament not found');

            return redirect(route('gameTournaments.index'));
        }

        return view('game_tournaments.show')->with('gameTournament', $gameTournament);
    }

    /**
     * Show the form for editing the specified GameTournament.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gameTournament = $this->gameTournamentRepository->find($id);
        $tournament_types = TournamentType::get();
        if (empty($gameTournament)) {
            Flash::error('Game Tournament not found');

            return redirect(route('gameTournaments.index'));
        }

        return view('game_tournaments.edit',compact('tournament_types'))->with('gameTournament', $gameTournament);
    }

    /**
     * Update the specified GameTournament in storage.
     *
     * @param int $id
     * @param UpdateGameTournamentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameTournamentRequest $request)
    {
        $input = $request->all();
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            Flash::error('Game Tournament not found');

            return redirect(route('gameTournaments.index'));
        }

		$request->validate([
				't_format' => 'required',
				'start_date' => 'required',
				'entry' => 'required|max:10',
				'starting_stack' => 'required|max:10',
				'prize' => 'required|max:10',
                'banner' => 'required|mimes:jpeg,jpg,png',
		     ]
		);
		if($request->hasFile('banner')){
            $fileName = time().'.'.$request->file('banner')->getClientOriginalExtension();
            $filePath = public_path("tournament-images/{$fileName}");
            $request->banner->move(base_path('public/tournament-images/'), $filePath);
            $input['banner'] = $fileName;
            if(!empty($gameTournament->banner)){
                //delete old profile image
                unlink(public_path("tournament-images/{$gameTournament->banner}"));
            }
        }
		
        $gameTournament = $this->gameTournamentRepository->update($input, $id);

        Flash::success('Game Tournament updated successfully.');

        return redirect(route('gameTournaments.index'));
    }

    /**
     * Remove the specified GameTournament from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gameTournament = $this->gameTournamentRepository->find($id);

        if (empty($gameTournament)) {
            Flash::error('Game Tournament not found');

            return redirect(route('gameTournaments.index'));
        }

        $this->gameTournamentRepository->delete($id);

        Flash::success('Game Tournament deleted successfully.');

        return redirect(route('gameTournaments.index'));
    }
}
