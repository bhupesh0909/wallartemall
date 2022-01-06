<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateGameTypeAPIRequest;
use App\Http\Requests\API\UpdateGameTypeAPIRequest;
use App\Models\GameType;
use App\Repositories\GameTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class GameTypeController
 * @package App\Http\Controllers\API
 */
class GameTypeAPIController extends AppBaseController
{
    /** @var  GameTypeRepository */
    private $gameTypeRepository;

    public function __construct(GameTypeRepository $gameTypeRepo)
    {
        $this->gameTypeRepository = $gameTypeRepo;
    }

    /**
     * Display a listing of the GameType.
     * GET|HEAD /gameTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        /*$gameTypes = $this->gameTypeRepository->where('is_active','1')->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );*/

        $gameTypes = GameType::where('is_active', '1')->get();
        return response::json(['status' => 1, 'game_types' => $gameTypes, 'message' => ['Game Types retrieved successfully']]);
//        return $this->sendResponse($gameTypes->toArray(), 'Game Types retrieved successfully');
    }

    /**
     * Store a newly created GameType in storage.
     * POST /gameTypes
     *
     * @param CreateGameTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateGameTypeAPIRequest $request)
    {
        $input = $request->all();

        $gameType = $this->gameTypeRepository->create($input);

        return $this->sendResponse($gameType->toArray(), 'Game Type saved successfully');
    }

    /**
     * Display the specified GameType.
     * GET|HEAD /gameTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var GameType $gameType */
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            return $this->sendError('Game Type not found');
        }

        return $this->sendResponse($gameType->toArray(), 'Game Type retrieved successfully');
    }

    /**
     * Update the specified GameType in storage.
     * PUT/PATCH /gameTypes/{id}
     *
     * @param int $id
     * @param UpdateGameTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGameTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var GameType $gameType */
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            return $this->sendError('Game Type not found');
        }

        $gameType = $this->gameTypeRepository->update($input, $id);

        return $this->sendResponse($gameType->toArray(), 'GameType updated successfully');
    }

    /**
     * Remove the specified GameType from storage.
     * DELETE /gameTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var GameType $gameType */
        $gameType = $this->gameTypeRepository->find($id);

        if (empty($gameType)) {
            return $this->sendError('Game Type not found');
        }

        $gameType->delete();

        return $this->sendSuccess('Game Type deleted successfully');
    }
}
