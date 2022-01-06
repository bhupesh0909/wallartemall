<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAwardsAPIRequest;
use App\Http\Requests\API\UpdateAwardsAPIRequest;
use App\Models\Awards;
use App\Repositories\AwardsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AwardsController
 * @package App\Http\Controllers\API
 */

class AwardsAPIController extends AppBaseController
{
    /** @var  AwardsRepository */
    private $awardsRepository;

    public function __construct(AwardsRepository $awardsRepo)
    {
        $this->awardsRepository = $awardsRepo;
    }

    /**
     * Display a listing of the Awards.
     * GET|HEAD /awards
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $awards = $this->awardsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($awards->toArray(), 'Awards retrieved successfully');
    }

    /**
     * Store a newly created Awards in storage.
     * POST /awards
     *
     * @param CreateAwardsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateAwardsAPIRequest $request)
    {
        $input = $request->all();

        $awards = $this->awardsRepository->create($input);

        return $this->sendResponse($awards->toArray(), 'Awards saved successfully');
    }

    /**
     * Display the specified Awards.
     * GET|HEAD /awards/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Awards $awards */
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            return $this->sendError('Awards not found');
        }

        return $this->sendResponse($awards->toArray(), 'Awards retrieved successfully');
    }

    /**
     * Update the specified Awards in storage.
     * PUT/PATCH /awards/{id}
     *
     * @param int $id
     * @param UpdateAwardsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAwardsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Awards $awards */
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            return $this->sendError('Awards not found');
        }

        $awards = $this->awardsRepository->update($input, $id);

        return $this->sendResponse($awards->toArray(), 'Awards updated successfully');
    }

    /**
     * Remove the specified Awards from storage.
     * DELETE /awards/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Awards $awards */
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            return $this->sendError('Awards not found');
        }

        $awards->delete();

        return $this->sendSuccess('Awards deleted successfully');
    }
}
