<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSendInvitationAPIRequest;
use App\Http\Requests\API\UpdateSendInvitationAPIRequest;
use App\Models\AcceptInvitation;
use App\Models\SendInvitation;
use App\User;
use App\Repositories\SendInvitationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SendInvitationController
 * @package App\Http\Controllers\API
 */
class SendInvitationAPIController extends AppBaseController
{
    /** @var  SendInvitationRepository */
    private $sendInvitationRepository;
    private $user;

    public function __construct(SendInvitationRepository $sendInvitationRepo,User $user)
    {
        $this->sendInvitationRepository = $sendInvitationRepo;
        $this->user = $user;
    }

    /**
     * Display a listing of the SendInvitation.
     * GET|HEAD /sendInvitations
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sendInvitations = $this->sendInvitationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sendInvitations->toArray(), 'Send Invitations retrieved successfully');
    }

    /**
     * Store a newly created SendInvitation in storage.
     * POST /sendInvitations
     *
     * @param CreateSendInvitationAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSendInvitationAPIRequest $request)
    {
        $input = $request->all();

        $sendInvitation = $this->sendInvitationRepository->create($input);

        return $this->sendResponse($sendInvitation->toArray(), 'Send Invitation saved successfully');
    }

    /**
     * Display the specified SendInvitation.
     * GET|HEAD /sendInvitations/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SendInvitation $sendInvitation */
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            return $this->sendError('Send Invitation not found');
        }

        return $this->sendResponse($sendInvitation->toArray(), 'Send Invitation retrieved successfully');
    }

    /**
     * Update the specified SendInvitation in storage.
     * PUT/PATCH /sendInvitations/{id}
     *
     * @param int $id
     * @param UpdateSendInvitationAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSendInvitationAPIRequest $request)
    {
        $input = $request->all();

        /** @var SendInvitation $sendInvitation */
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            return $this->sendError('Send Invitation not found');
        }

        $sendInvitation = $this->sendInvitationRepository->update($input, $id);

        return $this->sendResponse($sendInvitation->toArray(), 'SendInvitation updated successfully');
    }

    /**
     * Remove the specified SendInvitation from storage.
     * DELETE /sendInvitations/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SendInvitation $sendInvitation */
        $sendInvitation = $this->sendInvitationRepository->find($id);

        if (empty($sendInvitation)) {
            return $this->sendError('Send Invitation not found');
        }

        $sendInvitation->delete();

        return $this->sendSuccess('Send Invitation deleted successfully');
    }

    public function SendInvitation(Request $request)
    {
        try {
			$input = $request->all(); 
            $get_user_details = User::where('id', $input['user_id'])->get()->toArray();
                
             if(count($get_user_details)<1){
                return response::json(['status' => 0, 'message' => ['User dose not exists...']]);
            }

            if($request->amount <= 0){
                return response::json(['status' => 0, 'send_invitation' => '', 'message' => ['Amount should be more than 0.']]);
            }
			else if (in_array($input['user_id'], explode(',', $input['send_to'])))
			{
				return response::json(['status' => 0, 'send_invitation' => '', 'message' => ['You can\'t send invitation yourself.']]);
			}
			else{
                
               $flag = $this->sendInvitationRepository->SendInvitation($input['user_id'], $input['send_to']);
              

               if(empty($flag['unsent_flag'])){
                    return response::json(['status' => 1, 'send_invitation' => '', 'message' => ['Invitation successfully sent.']]);
               }else{
                    return response::json(['status' => 0, 'send_invitation' => '', 'message' => ['Given users are not registed '.$flag['unsent_flag']]]);
               }
			  
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'send_invitation' => '', 'message' => [$e->getMessage()]]);
        }
    }

    public function AcceptInvitation(Request $request)
    {
        try {
			
			if($request->user_id == $request->invited_by)
			{
				return response::json(['status' => 1, 'accept_invitation' => '', 'message' => ['You can\'t accept invitation by yourself.']]);
			}	
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {

                $input = $request->all();
                $chk_invited_by = $this->user->ValidUser($request->invited_by);
                if($chk_invited_by){
                    $this->sendInvitationRepository->AcceptInvitation($input['invited_by'], $input['user_id']);
                    return response::json(['status' => 1, 'accept_invitation' => '', 'message' => ['You can play with us.']]);
                }else{
                    return response::json(['status' => 1, 'accept_invitation' => null, 'message' => ['The user you invited by does not exists.']]);
                }
            }else{
                return response::json(['status' => 0, 'accept_invitation' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'send_invitation' => '', 'message' => [$e->getMessage()]]);
        }
    }
}