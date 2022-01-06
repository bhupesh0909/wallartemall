<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSendInvitationRequest;
use App\Http\Requests\UpdateSendInvitationRequest;
use App\Repositories\SendInvitationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class SendInvitationController extends AppBaseController
{
    /** @var  SendInvitationRepository */
    private $sendInvitationRepository;

    public function __construct(SendInvitationRepository $sendInvitationRepo)
    {
        $this->sendInvitationRepository = $sendInvitationRepo;
    }

    /**
     * Display a listing of the SendInvitation.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $sendInvitations = $this->sendInvitationRepository->all();

        return view('send_invitations.index')
            ->with('sendInvitations', $sendInvitations);
    }

    /**
     * Show the form for creating a new SendInvitation.
     *
     * @return Response
     */
    public function create()
    {
        return view('send_invitations.create');
    }

    /**
     * Store a newly created SendInvitation in storage.
     *
     * @param CreateSendInvitationRequest $request
     *
     * @return Response
     */
    public function store(CreateSendInvitationRequest $request)
    {
        $input = $request->all();

        $sendInvitation = $this->sendInvitationRepository->create($input);

        Flash::success('Send Invitation saved successfully.');

        return redirect(route('sendInvitations.index'));
    }

    /**
     * Display the specified SendInvitation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            Flash::error('Send Invitation not found');

            return redirect(route('sendInvitations.index'));
        }

        return view('send_invitations.show')->with('sendInvitation', $sendInvitation);
    }

    /**
     * Show the form for editing the specified SendInvitation.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            Flash::error('Send Invitation not found');

            return redirect(route('sendInvitations.index'));
        }

        return view('send_invitations.edit')->with('sendInvitation', $sendInvitation);
    }

    /**
     * Update the specified SendInvitation in storage.
     *
     * @param int $id
     * @param UpdateSendInvitationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSendInvitationRequest $request)
    {
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            Flash::error('Send Invitation not found');

            return redirect(route('sendInvitations.index'));
        }

        $sendInvitation = $this->sendInvitationRepository->update($request->all(), $id);

        Flash::success('Send Invitation updated successfully.');

        return redirect(route('sendInvitations.index'));
    }

    /**
     * Remove the specified SendInvitation from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            Flash::error('Send Invitation not found');

            return redirect(route('sendInvitations.index'));
        }

        $this->sendInvitationRepository->delete($id);

        Flash::success('Send Invitation deleted successfully.');

        return redirect(route('sendInvitations.index'));
    }
}
