<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWithdraw_amountAPIRequest;
use App\Http\Requests\API\CreateWithdrawAmountAPIRequest;
use App\Http\Requests\API\UpdateWithdraw_amountAPIRequest;
use App\Models\Withdraw_amount;
use App\Repositories\Withdraw_amountRepository;
use App\Repositories\WithdrawAmountRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use Razorpay\Api\Api;


/**
 * Class Withdraw_amountController
 * @package App\Http\Controllers\API
 */
class WithdrawAmountAPIController extends AppBaseController
{
    /** @var  Withdraw_amountRepository */
    private $withdrawAmountRepository;

    public function __construct(WithdrawAmountRepository $withdrawAmountRepo)
    {
        $this->withdrawAmountRepository = $withdrawAmountRepo;
    }

    /**
     * Display a listing of the Withdraw_amount.
     * GET|HEAD /withdrawAmounts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $withdrawAmounts = $this->withdrawAmountRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($withdrawAmounts->toArray(), 'Withdraw Amounts retrieved successfully');
    }

    /**
     * Store a newly created Withdraw_amount in storage.
     * POST /withdrawAmounts
     *
     * @param CreateWithdraw_amountAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateWithdrawAmountAPIRequest $request)
    {
        $input = $request->all();

        $withdrawAmount = $this->withdrawAmountRepository->create($input);

        return $this->sendResponse($withdrawAmount->toArray(), 'Withdraw Amount saved successfully');
    }

    /**
     * Display the specified Withdraw_amount.
     * GET|HEAD /withdrawAmounts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Withdraw_amount $withdrawAmount */
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            return $this->sendError('Withdraw Amount not found');
        }

        return $this->sendResponse($withdrawAmount->toArray(), 'Withdraw Amount retrieved successfully');
    }

    /**
     * Update the specified Withdraw_amount in storage.
     * PUT/PATCH /withdrawAmounts/{id}
     *
     * @param int $id
     * @param UpdateWithdraw_amountAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWithdrawAmountAPIRequest $request)
    {
        $input = $request->all();

        /** @var Withdraw_amount $withdrawAmount */
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            return $this->sendError('Withdraw Amount not found');
        }

        $withdrawAmount = $this->withdrawAmountRepository->update($input, $id);

        return $this->sendResponse($withdrawAmount->toArray(), 'Withdraw_amount updated successfully');
    }

    /**
     * Remove the specified Withdraw_amount from storage.
     * DELETE /withdrawAmounts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Withdraw_amount $withdrawAmount */
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            return $this->sendError('Withdraw Amount not found');
        }

        $withdrawAmount->delete();

        return $this->sendSuccess('Withdraw Amount deleted successfully');
    }

    public function WithdrawAmount(Request $request)
    {
        try {			

            $get_user_details = User::where('id', $request['user_id'])->get()->toArray();
				
             if(count($get_user_details)<1){
                return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => ['User dose not exists...']]);
            }
			else if($request->amount < 100){
                return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => ['Amount should be more than 100.']]);
            }else{

                $get_user_details = User::select('total_amount', 'redeem')->where('id', $request['user_id'])->first();

                  
                if ($get_user_details['total_amount'] < 50) {
                    return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => ['You need to win more than 50.']]);
                }else if($request['amount'] > $get_user_details['total_amount'] ){
                    return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => ['You have Rs.'.$get_user_details['total_amount'].' in your account']]);
                } else {

                    $transaction_fees = 5;
                    $convenience_charges = 2;

                    $request['total_deduction'] = ($transaction_fees + $convenience_charges);
                       
                    $request['amount_after_deduction'] = $request['amount'] - ($request['amount'] * ($request['total_deduction'] / 100 )); 
                    $withdraw_amount = $this->withdrawAmountRepository->WithdrawAmountTransaction($request->all());
 
                    $withdraw_amount['net_amount'] = $request['amount_after_deduction'];
                    $withdraw_amount['total_deduction'] = $request['total_deduction'];
                    $withdraw_amount['transaction_fees'] = '5%';
                    $withdraw_amount['convenience_charges'] = '2%';

                    if ($withdraw_amount == false) {
                        return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => ['Please enter the correct amount.']]);
                    } elseif ($withdraw_amount == '0') {
                    } else {
                        unset($withdraw_amount['updated_at'],$withdraw_amount['created_at'],$withdraw_amount['id'],$withdraw_amount['total_deduction']); 

                        return response::json(['status' => 1, 'withdraw_amount' => [$withdraw_amount], 'message' => ['Amount will reflect in your account in 3-5 business day.']]);
                    }
                }
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'withdraw_amount' => null, 'message' => [$e->getMessage()]]);
        }
    }
    
    public function RazorPay(Request $request)
    {
        try {
//            dd($request->all());
            $api = new Api('rzp_test_IWq7EGQEzUEzQB', 'OmzXrboFEdRCnGBHbwZQGRz1');
            $order = $api->order->create(['receipt' => '123', 'amount' => 100, 'currency' => 'INR']); // Creates order
            dd($order);
            $orderId = $order['id']; // Get the created Order ID
            $order  = $api->order->fetch($orderId);
            dd($order);
            $orders = $api->order->all($order); // Returns array of order objects
            $payments = $api->order->fetch($orderId)->payments(); // Returns array of payment objects against an order

// Payments

            //dd($payments);

        } catch (\Exception $e) {
            return response::json(['status' => 0, 'razorpay' => null, 'message' => [$e->getMessage()]]);
        }
    }
}