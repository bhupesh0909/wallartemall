<?php

namespace App\Http\Controllers\API;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Http\Requests\API\CreateTransactionAPIRequest;
use App\Http\Requests\API\UpdateTransactionAPIRequest;
use App\Models\Transaction;
use App\Models\UserCard;
use App\Repositories\TransactionRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Razorpay\Api\Api;
use Response;
use Validator;

/**
 * Class TransactionController
 * @package App\Http\Controllers\API
 */
class TransactionAPIController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;
    private $user;
    private $transaction;

    private $usercard;

    public function __construct(TransactionRepository $transactionRepo, Transaction $transaction, User $user, UserCard $userCard)
    {
        $this->transactionRepository = $transactionRepo;
        $this->user = $user;
        $this->transaction = $transaction;
        $this->usercard = $userCard;
    }

    /**
     * Display a listing of the Transaction.
     * GET|HEAD /transactions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $transactions = $this->transactionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($transactions->toArray(), 'Transactions retrieved successfully');
    }

    /**
     * Store a newly created Transaction in storage.
     * POST /transactions
     *
     * @param CreateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionAPIRequest $request)
    {
        $input = $request->all();

        $transaction = $this->transactionRepository->create($input);

        return $this->sendResponse($transaction->toArray(), 'Transaction saved successfully');
    }

    /**
     * Display the specified Transaction.
     * GET|HEAD /transactions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        return $this->sendResponse($transaction->toArray(), 'Transaction retrieved successfully');
    }

    /**
     * Update the specified Transaction in storage.
     * PUT/PATCH /transactions/{id}
     *
     * @param int $id
     * @param UpdateTransactionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionAPIRequest $request)
    {
        $input = $request->all();

        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction = $this->transactionRepository->update($input, $id);

        return $this->sendResponse($transaction->toArray(), 'Transaction updated successfully');
    }

    /**
     * Remove the specified Transaction from storage.
     * DELETE /transactions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Transaction $transaction */
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            return $this->sendError('Transaction not found');
        }

        $transaction->delete();

        return $this->sendSuccess('Transaction deleted successfully');
    }

    public function Order(Request $request)
    {
        try {
            $api = new Api(env('Razorpay_Key_Id'), env('Razorpay_Key_Secret'));
            dd($api);
            $payment = PaytmWallet::with('receive');
            $payment->prepare([
                'order' => '123',
                'user' => 'Priyank Panchal',
                'mobile_number' => '7020265006',
                'email' => 'ppanchal912@gmail.com',
                'amount' => $request->amount,
                'callback_url' => url('api/payment/status')
            ]);
            return $payment->receive();
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'order' => null, 'msg' => $e->getMessage()]);
        }
    }

    public function paymentCallback()
    {
        $transaction = PaytmWallet::with('receive');
        $response = $transaction->response();
        $order_id = $transaction->getOrderId();


        if ($transaction->isSuccessful()) {
//            EventRegistration::where('order_id',$order_id)->update(['status'=>2, 'transaction_id'=>$transaction->getTransactionId()]);


            dd('Payment Successfully Paid.');
        } else if ($transaction->isFailed()) {
//            EventRegistration::where('order_id',$order_id)->update(['status'=>1, 'transaction_id'=>$transaction->getTransactionId()]);
            dd('Payment Failed.');
        }
    }


    public function AddCash(Request $request)
    {
        try {

             $validator = Validator::make($request->all(), [ 
                    'user_id'=>'required|numeric',
                    'amount'=>'required|numeric|between:100,50000',
                    'card_number'=>'required|digits:16',
                    'expire_date'=>'required|max:6',
                    'card_holder_name'=>'required|string|max:20',
                    'card_type'=>'required|string|max:15',                    
                    'pan_number'=>'required|max:10',                    
                    'ifsc_code'=>'required|max:10', 

                 ],[                
                    

                    
                ]);
                      
                 
            if (!$validator->passes()) {
                 return response::json(['status' => 0,'message' => $validator->errors()->all()]);
            }              
 

            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $userdata = User::where('id', $request->user_id)->first();
                if($userdata->active_user == 0){
                    return response::json(['status' => 0, 'transaction' => null, 'message' => ['Your account is not active.']]);
                }else if($userdata->is_block == 1){
                    return response::json(['status' => 0, 'transaction' => null, 'message' => ['You have been blocked.']]);
                }else{
                    if($request->amount <= 0){
                        return response::json(['status' => 0, 'transaction' => null, 'message' => ['Amount should be more than 0.']]);
                    }else{
                        if ($this->usercard->CardExists($request->all()) == false) {
                            $this->usercard->AddCard($request->all());
                        }
                        $this->transaction->MakeTransaction($request->all());
                        $total_amount = User::where('id', $request->user_id)->pluck('total_amount');
        //                dd($total_amount[0]);
                        User::where('id', $request->user_id)->update([
                            'total_amount' => $total_amount[0] + $request->amount
                        ]);
                        return response::json(['status' => 1, 'transaction' => null, 'message' => ['Cash added successfully.']]);
                    }
                }
                
            } else {
                return response::json(['status' => 0, 'transaction' => null, 'message' => ['User does not exists.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'transaction' => null, 'message' => [$e->getMessage()]]);
        }
    }

    public function GetTransactionList(Request $request)
    {
        try {
            $chk_valid_user = $this->user->ValidUser($request->user_id);
            if ($chk_valid_user) {
                $get_net_balance = $this->transaction->GetNetBalance($request->user_id);
                $transaction_list = $this->transaction->GetTransactionList($request->user_id);
                if($transaction_list){
                    foreach ($transaction_list as $key => &$value) {
                        if($value->status == null){
                            $value->status = "Pending";
                        }
                    }
                }
                $get_net_balance['transaction_list'] = $transaction_list;
                return response::json(['status' => 1, 'transaction_list' => $get_net_balance, 'message' => ['Get all transaction list.']]);
            } else {
                return response::json(['status' => 0, 'transaction_list' => null, 'message' => ['User not Authenticate.']]);
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'transaction_list' => null, 'message' => [$e->getMessage()]]);
        }
    }
}