<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAwardsRequest;
use App\Http\Requests\UpdateAwardsRequest;
use App\Repositories\AwardsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AwardsController extends AppBaseController
{
    /** @var  AwardsRepository */
    private $awardsRepository;

    public function __construct(AwardsRepository $awardsRepo)
    {
        $this->awardsRepository = $awardsRepo;
    }

    /**
     * Display a listing of the Awards.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $awards = $this->awardsRepository->all();

        return view('awards.index')
            ->with('awards', $awards);
    }

    /**
     * Show the form for creating a new Awards.
     *
     * @return Response
     */
    public function create()
    {
        return view('awards.create');
    }

    /**
     * Store a newly created Awards in storage.
     *
     * @param CreateAwardsRequest $request
     *
     * @return Response
     */
    public function store(CreateAwardsRequest $request)
    {
        $input = $request->all();

        $awards = $this->awardsRepository->create($input);

        Flash::success('Awards saved successfully.');

        return redirect(route('awards.index'));
    }

    /**
     * Display the specified Awards.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            Flash::error('Awards not found');

            return redirect(route('awards.index'));
        }

        return view('awards.show')->with('awards', $awards);
    }

    /**
     * Show the form for editing the specified Awards.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            Flash::error('Awards not found');

            return redirect(route('awards.index'));
        }

        return view('awards.edit')->with('awards', $awards);
    }

    /**
     * Update the specified Awards in storage.
     *
     * @param int $id
     * @param UpdateAwardsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAwardsRequest $request)
    {
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            Flash::error('Awards not found');

            return redirect(route('awards.index'));
        }

        $awards = $this->awardsRepository->update($request->all(), $id);

        Flash::success('Awards updated successfully.');

        return redirect(route('awards.index'));
    }

    /**
     * Remove the specified Awards from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $awards = $this->awardsRepository->find($id);

        if (empty($awards)) {
            Flash::error('Awards not found');

            return redirect(route('awards.index'));
        }

        $this->awardsRepository->delete($id);

        Flash::success('Awards deleted successfully.');

        return redirect(route('awards.index'));
    }
}
