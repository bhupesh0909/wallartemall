<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRefferRequest;
use App\Http\Requests\UpdateRefferRequest;
use App\Repositories\ReferRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ReferController extends AppBaseController
{
    /** @var  ReferRepository */
    private $referRepository;

    public function __construct(ReferRepository $referRepo)
    {
        $this->referRepository = $referRepo;
    }

    /**
     * Display a listing of the Refer.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $refers = $this->referRepository->all();

        return view('refers.index')
            ->with('refers', $refers);
    }

    /**
     * Show the form for creating a new Refer.
     *
     * @return Response
     */
    public function create()
    {
        return view('refers.create');
    }

    /**
     * Store a newly created Refer in storage.
     *
     * @param CreateRefferRequest $request
     *
     * @return Response
     */
    public function store(CreateRefferRequest $request)
    {
        $input = $request->all();

        $reffer = $this->referRepository->create($input);

        Flash::success('Refer saved successfully.');

        return redirect(route('refers.index'));
    }

    /**
     * Display the specified Refer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reffer = $this->referRepository->find($id);

        if (empty($reffer)) {
            Flash::error('Refer not found');

            return redirect(route('refers.index'));
        }

        return view('refers.show')->with('reffer', $reffer);
    }

    /**
     * Show the form for editing the specified Refer.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reffer = $this->referRepository->find($id);

        if (empty($reffer)) {
            Flash::error('Refer not found');

            return redirect(route('refers.index'));
        }

        return view('refers.edit')->with('reffer', $reffer);
    }

    /**
     * Update the specified Refer in storage.
     *
     * @param int $id
     * @param UpdateRefferRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRefferRequest $request)
    {
        $reffer = $this->referRepository->find($id);

        if (empty($reffer)) {
            Flash::error('Refer not found');

            return redirect(route('refers.index'));
        }

        $reffer = $this->referRepository->update($request->all(), $id);

        Flash::success('Refer updated successfully.');

        return redirect(route('refers.index'));
    }

    /**
     * Remove the specified Refer from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reffer = $this->referRepository->find($id);

        if (empty($reffer)) {
            Flash::error('Refer not found');

            return redirect(route('refers.index'));
        }

        $this->referRepository->delete($id);

        Flash::success('Refer deleted successfully.');

        return redirect(route('refers.index'));
    }
}
