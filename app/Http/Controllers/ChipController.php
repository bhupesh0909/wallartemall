<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChipRequest;
use App\Http\Requests\UpdateChipRequest;
use App\Repositories\ChipRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Response;

class ChipController extends AppBaseController
{
    /** @var  ChipRepository */
    private $chipRepository;
    private $user;

    public function __construct(ChipRepository $chipRepo, User $user)
    {
        $this->chipRepository = $chipRepo;
        $this->user = $user;
    }

    /**
     * Display a listing of the Chip.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $chips = $this->chipRepository->GetChipDetails();

		return view('chips.index')
            ->with('chips', $chips);
    }

    /**
     * Show the form for creating a new Chip.
     *
     * @return Response
     */
    public function create()
    {
        $users = $this->user->GetPlayers();
        $chip = null;
        return view('chips.create', compact('users','chip'));
    }

    /**
     * Store a newly created Chip in storage.
     *
     * @param CreateChipRequest $request
     *
     * @return Response
     */
    public function store(CreateChipRequest $request)
    {
        $input = $request->all();

        $chip = $this->chipRepository->create($input);
        $update_user_chip = $this->chipRepository->UpdateChipsInUser($input);

        Flash::success('Chip saved successfully.');

        return redirect(route('chips.index'));
    }

    /**
     * Display the specified Chip.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        return view('chips.show')->with('chip', $chip);
    }

    /**
     * Show the form for editing the specified Chip.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chip = $this->chipRepository->find($id);
        $users = $this->user->GetPlayers();
        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        return view('chips.edit', compact('users'))->with('chip', $chip);
    }

    /**
     * Update the specified Chip in storage.
     *
     * @param int $id
     * @param UpdateChipRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChipRequest $request)
    {
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        $chip = $this->chipRepository->update($request->all(), $id);

        Flash::success('Chip updated successfully.');

        return redirect(route('chips.index'));
    }

    /**
     * Remove the specified Chip from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $chip = $this->chipRepository->find($id);
        if (empty($chip)) {
            Flash::error('Chip not found');
            return redirect(route('chips.index'));
        }

        $this->chipRepository->decreaseUserChip($chip['user_id'], $chip['chips_amount']);
        $this->chipRepository->delete($id);

        Flash::success('Chip deleted successfully.');

        return redirect(route('chips.index'));
    }
}
