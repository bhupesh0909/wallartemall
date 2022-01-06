<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateChipAPIRequest;
use App\Http\Requests\API\UpdateChipAPIRequest;
use App\Models\Chip;
use App\Repositories\ChipRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ChipController
 * @package App\Http\Controllers\API
 */

class ChipAPIController extends AppBaseController
{
    /** @var  ChipRepository */
    private $chipRepository;

    public function __construct(ChipRepository $chipRepo)
    {
        $this->chipRepository = $chipRepo;
    }

    /**
     * Display a listing of the Chip.
     * GET|HEAD /chips
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $chips = $this->chipRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($chips->toArray(), 'Chips retrieved successfully');
    }

    /**
     * Store a newly created Chip in storage.
     * POST /chips
     *
     * @param CreateChipAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateChipAPIRequest $request)
    {
        $input = $request->all();

        $chip = $this->chipRepository->create($input);

        return $this->sendResponse($chip->toArray(), 'Chip saved successfully');
    }

    /**
     * Display the specified Chip.
     * GET|HEAD /chips/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Chip $chip */
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            return $this->sendError('Chip not found');
        }

        return $this->sendResponse($chip->toArray(), 'Chip retrieved successfully');
    }

    /**
     * Update the specified Chip in storage.
     * PUT/PATCH /chips/{id}
     *
     * @param int $id
     * @param UpdateChipAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChipAPIRequest $request)
    {
        $input = $request->all();

        /** @var Chip $chip */
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            return $this->sendError('Chip not found');
        }

        $chip = $this->chipRepository->update($input, $id);

        return $this->sendResponse($chip->toArray(), 'Chip updated successfully');
    }

    /**
     * Remove the specified Chip from storage.
     * DELETE /chips/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Chip $chip */
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            return $this->sendError('Chip not found');
        }

        $chip->delete();

        return $this->sendSuccess('Chip deleted successfully');
    }
}
