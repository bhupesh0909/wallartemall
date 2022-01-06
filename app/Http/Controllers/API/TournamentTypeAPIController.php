<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTournamentTypeAPIRequest;
use App\Http\Requests\API\UpdateTournamentTypeAPIRequest;
use App\Models\TournamentType;
use App\Repositories\TournamentTypeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class TournamentTypeController
 * @package App\Http\Controllers\API
 */

class TournamentTypeAPIController extends AppBaseController
{
    /** @var  TournamentTypeRepository */
    private $tournamentTypeRepository;

    public function __construct(TournamentTypeRepository $tournamentTypeRepo)
    {
        $this->tournamentTypeRepository = $tournamentTypeRepo;
    }

    /**
     * Display a listing of the TournamentType.
     * GET|HEAD /tournamentTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $tournamentTypes = $this->tournamentTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit'),['id','tournament_type','status','created_at','updated_at']
        );

        return $this->sendResponse($tournamentTypes->toArray(), 'Tournament Types retrieved successfully');
    }

    /**
     * Store a newly created TournamentType in storage.
     * POST /tournamentTypes
     *
     * @param CreateTournamentTypeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTournamentTypeAPIRequest $request)
    {
        $input = $request->all();

        $tournamentType = $this->tournamentTypeRepository->create($input);

        return $this->sendResponse($tournamentType->toArray(), 'Tournament Type saved successfully');
    }

    /**
     * Display the specified TournamentType.
     * GET|HEAD /tournamentTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var TournamentType $tournamentType */
        $tournamentType = $this->tournamentTypeRepository->find($id);

        if (empty($tournamentType)) {
            return $this->sendError('Tournament Type not found');
        }

        return $this->sendResponse($tournamentType->toArray(), 'Tournament Type retrieved successfully');
    }

    /**
     * Update the specified TournamentType in storage.
     * PUT/PATCH /tournamentTypes/{id}
     *
     * @param int $id
     * @param UpdateTournamentTypeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTournamentTypeAPIRequest $request)
    {
        $input = $request->all();

        /** @var TournamentType $tournamentType */
        $tournamentType = $this->tournamentTypeRepository->find($id);

        if (empty($tournamentType)) {
            return $this->sendError('Tournament Type not found');
        }

        $tournamentType = $this->tournamentTypeRepository->update($input, $id);

        return $this->sendResponse($tournamentType->toArray(), 'TournamentType updated successfully');
    }

    /**
     * Remove the specified TournamentType from storage.
     * DELETE /tournamentTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var TournamentType $tournamentType */
        $tournamentType = $this->tournamentTypeRepository->find($id);

        if (empty($tournamentType)) {
            return $this->sendError('Tournament Type not found');
        }

        $tournamentType->delete();

        return $this->sendSuccess('Tournament Type deleted successfully');
    }
}
