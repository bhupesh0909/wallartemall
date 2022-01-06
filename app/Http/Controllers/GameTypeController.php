<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGameTypeRequest;
use App\Http\Requests\UpdateGameTypeRequest;
use App\Models\GameType;
use App\Repositories\GameTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use Image;
class GameTypeController extends AppBaseController
{
    /** @var  GameTypeRepository */
    private $gameTypeRepository;

    public function __construct(GameTypeRepository $gameTypeRepo)
    {
        $this->gameTypeRepository = $gameTypeRepo;
    }

    /**
     * Display a listing of the GameType.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $gameTypes = $this->gameTypeRepository->all();

        return view('game_types.index')
            ->with('gameTypes', $gameTypes);
    }

    /**
     * Show the form for creating a new GameType.
     *
     * @return Response
     */
    public function create()
    {
        return view('game_types.create');
    }

    /**
     * Store a newly created GameType in storage.
     *
     * @param CreateGameTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateGameTypeRequest $request)
    {
		
		
		$request->validate([
				'game_type' => 'required',
				//'game_type' => 'required',
				'game_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		     ],[
				'game_icon.mimes' => 'Game icon must be in jpeg/jpg/png format.',
			]
		);
		
		
		
        $input = $request->all();
        if ($request->hasfile('game_icon')) {
            $image = $request->file('game_icon');
            $hash = hash_file('sha256', $image, false);
            $name = $hash . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/game_icons');
			
			 $img = Image::make($image->getRealPath());
				$img->resize(150, 150, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destinationPath.'/'.$name);
		   
			
			
          //  $image->move($destinationPath, $name);
            
			//$image_path = url('public/images/game_icons') . '/' . $name;
			$image_path = $name;
            $input['game_icon'] = $image_path;
        }
        $gameType = $this->gameTypeRepository->create($input);
        Flash::success('Game Type saved successfully.');
        return redirect(route('gameTypes.index'));
    }

    /**
     * Display the specified GameType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            Flash::error('Game Type not found');

            return redirect(route('gameTypes.index'));
        }

        return view('game_types.show')->with('gameType', $gameType);
    }

    /**
     * Show the form for editing the specified GameType.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            Flash::error('Game Type not found');

            return redirect(route('gameTypes.index'));
        }

        return view('game_types.edit')->with('gameType', $gameType);
    }

    /**
     * Update the specified GameType in storage.
     *
     * @param int $id
     * @param UpdateGameTypeRequest $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            Flash::error('Game Type not found');

            return redirect(route('gameTypes.index'));
        }
		
		$request->validate([
				'game_type' => 'required',
				//'game_type' => 'required',
				'game_icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
		     ],[
				'game_icon.mimes' => 'Game icon must be in jpeg/jpg/png format.',
			]
		);
		
		
		
		
        $gameType = $this->gameTypeRepository->update([
            'game_type' => $request->game_type,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ], $id);


        if ($request->hasfile('game_icon')) {
            $image = $request->file('game_icon');
            $hash = hash_file('sha256', $image, false);
            $name = $hash . '.' . $image->getClientOriginalExtension();
			
			$destinationPath = public_path('/images/game_icons');
			 
			 
			 $img = Image::make($image->getRealPath());
				$img->resize(150, 150, function ($constraint) {
					$constraint->aspectRatio();
				})->save($destinationPath.'/'.$name);
		   
			
			//$destinationPath = public_path('/images/game_icons');
           
           // $image->move($destinationPath, $name);
           // $image_path = url('public/images/game_icons') . '/' . $name;
            $image_path = $name;
            $game_icon = $image_path;
            $this->gameTypeRepository->update([
                'game_type' => $request->game_type,
                'is_active' => $request->is_active,
                'description' => $request->description,
                'game_icon' => $game_icon,
            ], $id);
        }

        Flash::success('Game Type updated successfully.');

        return redirect(route('gameTypes.index'));
    }

    /**
     * Remove the specified GameType from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            Flash::error('Game Type not found');

            return redirect(route('gameTypes.index'));
        }

        $this->gameTypeRepository->delete($id);

        Flash::success('Game Type deleted successfully.');

        return redirect(route('gameTypes.index'));
    }

    public function GameAction($game_id)
    {
        $game_type = GameType::where('id', $game_id)->first();
        if ($game_type->is_active == 1) {
            GameType::where('id', $game_id)->update(['is_active' => '0']);
        } else {
            GameType::where('id', $game_id)->update(['is_active' => '1']);
        }
        return redirect()->back();
//        return response::json(['status' => 1, 'game_action' => [], 'message' => 'Status Updated Successfully']);
    }
}