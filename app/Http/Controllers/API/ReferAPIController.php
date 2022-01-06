<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReferAPIRequest;
use App\Http\Requests\API\UpdateReferAPIRequest;
use App\Models\Refer;
use App\Repositories\ReferRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\User;
use Validator;

/**
 * Class ReferController
 * @package App\Http\Controllers\API
 */
class ReferAPIController extends AppBaseController
{
    /** @var  ReferRepository */
    private $referRepository;
    private $user;

    public function __construct(ReferRepository $referRepo, User $user)
    {
        $this->referRepository = $referRepo;
        $this->user = $user;
    }

    /**
     * Display a listing of the Refer.
     * GET|HEAD /Refers
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $refers = $this->referRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($refers->toArray(), 'Refers retrieved successfully');
    }

    /**
     * Store a newly created Refer in storage.
     * POST /Refers
     *
     * @param CreateReferAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateReferAPIRequest $request)
    {
        $input = $request->all();

        $refer = $this->referRepository->create($input);

        return $this->sendResponse($refer->toArray(), 'Refer saved successfully');
    }

    /**
     * Display the specified Refer.
     * GET|HEAD /Refers/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Refer $refer */
        $refer = $this->referRepository->find($id);

        if (empty($refer)) {
            return $this->sendError('Refer not found');
        }

        return $this->sendResponse($refer->toArray(), 'Refer retrieved successfully');
    }

    /**
     * Update the specified Refer in storage.
     * PUT/PATCH /Refers/{id}
     *
     * @param int $id
     * @param UpdateReferAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReferAPIRequest $request)
    {
        $input = $request->all();

        /** @var Refer $refer */
        $refer = $this->referRepository->find($id);

        if (empty($refer)) {
            return $this->sendError('Refer not found');
        }

        $refer = $this->referRepository->update($input, $id);

        return $this->sendResponse($refer->toArray(), 'Refer updated successfully');
    }

    /**
     * Remove the specified Refer from storage.
     * DELETE /Refers/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Refer $refer */
        $refer = $this->referRepository->find($id);

        if (empty($refer)) {
            return $this->sendError('Refer not found');
        }

        $refer->delete();

        return $this->sendSuccess('Refer deleted successfully');
    }

    public function ReferFriend(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [      
                 'user_id' => 'required|numeric',                 
                 'refer_to' => 'required|numeric',
                
             ],[]);
        
            if (!$validator->passes()) {
                 return response::json(['status' => 0,'message' => $validator->errors()->all()]);
            }

            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if($chk_valid_user){
                if(isset($request->refer_to)){
                   
                    $chk_refer_to = User::where('id', $request->refer_to)->first();
                   if(!$chk_refer_to){
                        return response::json(['status' => 0, 'refer_friend' => null, 'message' => ['Referee does not exists.']]);
                    }else{
                        if($request->user_id == $request->refer_to){
                            return response::json(['status' => 0, 'refer_friend' => null, 'message' => ['The referer and referee can not be same.']]);
                        }else{
                            $refer = $this->referRepository->Referfriend($request->all());
                            if(!empty($refer)){
                                $response = ['refer_by'=>$request->user_id,'refer_to'=>$request->refer_to];
                            }
                            return response::json(['status' => 1, 'refer_friend' => $response, 'message' => ['You refer to your friend.']]);
                        }
                    }
                }
            }else{
                return response::json(['status' => 0, 'refer_friend' => null, 'message' => ['User is not authenticated.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'message' => [$e->getMessage()]]);
        }
    }

    public function GetReward(Request $request)
    {
        try {
            $refer = $this->referRepository->GetReward($request->all());
            if ($refer) {
                return response::json(['status' => 1, 'get_reward' => '', 'message' => ['You will get reward in sometimes.']]);
            } else {
                return response::json(['status' => 0, 'get_reward' => '', 'message' => ['Invalid Code Please Check.']]);
            }
            return response::json(['status' => 1, 'get_reward' => $refer, 'message' => ['You reward friend.']]);
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'message' => [$e->getMessage()]]);
        }
    }
}