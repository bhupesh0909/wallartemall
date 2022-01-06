<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWithdraw_amountRequest;
use App\Http\Requests\CreateWithdrawAmountRequest;
use App\Http\Requests\UpdateWithdraw_amountRequest;
use App\Http\Requests\UpdateWithdrawAmountRequest;
use App\Repositories\Withdraw_amountRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\WithdrawAmountRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\WithdrawAmount;
use DataTables;
class WithdrawAmountController extends AppBaseController
{
    /** @var  Withdraw_amountRepository */
    private $withdrawAmountRepository;

    public function __construct(WithdrawAmountRepository $withdrawAmountRepo)
    {
        $this->withdrawAmountRepository = $withdrawAmountRepo;
    }

    /**
     * Display a listing of the Withdraw_amount.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $withdrawAmounts = $this->withdrawAmountRepository->GetWithdrawAmountList();

        return view('withdraw_amounts.index')
            ->with('withdrawAmounts', $withdrawAmounts);
    }

    public function datatable(Request $req){
        // dd($req->all());
        $cols = ['user_id', 'username', 'amount', 'is_released', 'withdraw_amounts.updated_at', 'withdraw_amounts.id'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = WithdrawAmount::all()->count();
        $data = WithdrawAmount::select($cols)
                ->leftjoin('users', 'users.id','=','user_id');
        for($i = 0; $i < count($cols); $i++){
            if(!empty($search)){
                $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
            }
        }
        if($req->type !== 'all'){
            $data = $data->where('withdraw_amounts.is_released', $req->type);
        }
        // if(isset($start) && isset($length)){
        //     $data = $data->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('withdraw_amounts.id', 'DESC');
        }
        $data = $data->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new Withdraw_amount.
     *
     * @return Response
     */
    public function create()
    {
        return view('withdraw_amounts.create');
    }

    /**
     * Store a newly created Withdraw_amount in storage.
     *
     * @param CreateWithdraw_amountRequest $request
     *
     * @return Response
     */
    public function store(CreateWithdrawAmountRequest $request)
    {
        $input = $request->all();

        $withdrawAmount = $this->withdrawAmountRepository->create($input);

        Flash::success('Withdraw Amount saved successfully.');

        return redirect(route('withdrawAmounts.index'));
    }

    /**
     * Display the specified Withdraw_amount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            Flash::error('Withdraw Amount not found');

            return redirect(route('withdrawAmounts.index'));
        }

        return view('withdraw_amounts.show')->with('withdrawAmount', $withdrawAmount);
    }

    /**
     * Show the form for editing the specified Withdraw_amount.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            Flash::error('Withdraw Amount not found');

            return redirect(route('withdrawAmounts.index'));
        }

        return view('withdraw_amounts.edit')->with('withdrawAmount', $withdrawAmount);
    }

    /**
     * Update the specified Withdraw_amount in storage.
     *
     * @param int $id
     * @param UpdateWithdraw_amountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWithdrawAmountRequest $request)
    {
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            Flash::error('Withdraw Amount not found');

            return redirect(route('withdrawAmounts.index'));
        }

        $withdrawAmount = $this->withdrawAmountRepository->update($request->all(), $id);

        Flash::success('Withdraw Amount updated successfully.');

        return redirect(route('withdrawAmounts.index'));
    }

    /**
     * Remove the specified Withdraw_amount from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $withdrawAmount = $this->withdrawAmountRepository->find($id);

        if (empty($withdrawAmount)) {
            Flash::error('Withdraw Amount not found');

            return redirect(route('withdrawAmounts.index'));
        }

        $this->withdrawAmountRepository->delete($id);

        Flash::success('Withdraw Amount deleted successfully.');

        return redirect(route('withdrawAmounts.index'));
    }

    public function UnderProcess($w_id)
    {
        try {
            $released_amount = $this->withdrawAmountRepository->UpdateUnderProcess($w_id);
            if ($released_amount == 1) {
                Flash::success('Payment released successfully.');
                return redirect(route('withdrawAmounts.index'));
            } elseif ($released_amount == 2) {
                Flash::success('Under process.');
                return redirect(route('withdrawAmounts.index'));
            } else {
                Flash::success('Payment not release.');
                return redirect(route('withdrawAmounts.index'));
            }
        } catch (\Exception $e) {
            return response::json(['status' => 0, 'payment_release' => [], 'message' => $e->getMessage()]);
        }
    }

    public function PaymentRelease($w_id)
    {
        try {
            $released_amount = $this->withdrawAmountRepository->UpdateReleaseStatus($w_id);
            if ($released_amount == 1) {
                Flash::success('Payment released successfully.');
                return redirect(route('withdrawAmounts.index'));
            } elseif ($released_amount == 2) {
                Flash::success('Under process.');
                return redirect(route('withdrawAmounts.index'));
            } else {
                Flash::success('Payment not release.');
                return redirect(route('withdrawAmounts.index'));
            }
        } catch (\Exception $e) {
            dd($e);
            return response::json(['status' => 0, 'payment_release' => [], 'message' => $e->getMessage()]);
        }
    }
}