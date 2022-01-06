<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use App\Models\GameWinner;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ReferRepository;
use Illuminate\Http\Request;
use Flash;
use Response;
use DataTables, DB;
use App\User;

class TransactionController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepository = $transactionRepo;
    }

    /**
     * Display a listing of the Transaction.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // $transactions = $this->transactionRepository->paginate(15);
        $transactions = $this->transactionRepository->allQuery()->with('user')->get();
        $referrals = Transaction::where('trans_type','referral')->paginate(15);
        $gameresult = DB::table('game_winner')
						->leftjoin('users', 'users.id', '=', 'game_winner.user_id')
						->paginate(15);
        // dd($transactions->toArray());
        return view('transactions.index', compact('gameresult','referrals'))
            ->with('transactions', $transactions);
    }

    public function depositDatatable(Request $req){
        // dd($req->all());
        $cols = ['username', 'transaction_id', 'trans_type', 'amount', 'transactions.created_at', 'transactions.id'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = Transaction::all()->count();
        $data = Transaction::select($cols)
                ->leftjoin('users', 'users.id','=','transactions.user_id')
                ->where('trans_type', 'deposit');
        for($i = 0; $i < count($cols); $i++){
            if(!empty($search)){
                $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
            }
        }
        // $data = $data->where('users.role', 'user');
        // if(isset($start) && isset($length)){
        //     $data = $data->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('transactions.id', 'DESC');
        }
        // dd($data->toSql(), $data->getBindings());
        $data = $data->get();
        return DataTables::of($data)->make(true);
    }
    public function referDatatable(Request $req){
        // dd($req->all());
        $cols = ['username', 'transaction_id', 'trans_type', 'amount', 'transactions.created_at', 'transactions.id'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = Transaction::all()->count();
        $data = Transaction::select($cols)
                ->leftjoin('users', 'users.id','=','transactions.user_id')
                ->where('trans_type', 'referral');
        for($i = 0; $i < count($cols); $i++){
            if(!empty($search)){
                $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
            }
        }
        // $data = $data->where('users.role', 'user');
        // if(isset($start) && isset($length)){
        //     $data = $data->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('transactions.id', 'DESC');
        }
        // dd($data->toSql(), $data->getBindings());
        $data = $data->get();
        return DataTables::of($data)->make(true);
    }
    public function gameResultsDatatable(Request $req){
        // dd($req->all());
        $cols = ['username', 'game_type', 'game_id', 'win_amount', 'status', 'game_winner.created_at', 'game_winner.id'];
        $input = $req->all();
        $order = (!empty($input['order']))? $input['order'] : null;
        $start = $input['start'];
        $length = $input['length'];
        $search = $input['search']['value'];
        $recordsTotal = GameWinner::all()->count();
        $data = GameWinner::select($cols)
                ->leftjoin('users', 'users.id','=','user_id');
        for($i = 0; $i < count($cols); $i++){
            if(!empty($search)){
                $data = $data->orWhere($cols[$i], 'like', "%{$search}%");
            }
        }
        // $data = $data->where('users.role', 'user');
        // if(isset($start) && isset($length)){
        //     $data = $data->limit($length)->offset($start);
        // }
        if($order){
            $data = $data->orderBy($cols[$order[0]['column']], $order[0]['dir']);
        }else{
            $data = $data->orderBy('game_winner.id', 'DESC');
        }
        // dd($data->toSql(), $data->getBindings());
        $data = $data->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new Transaction.
     *
     * @return Response
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created Transaction in storage.
     *
     * @param CreateTransactionRequest $request
     *
     * @return Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $input = $request->all();

        $transaction = $this->transactionRepository->create($input);

        Flash::success('Transaction saved successfully.');

        return redirect(route('transactions.index'));
    }

    /**
     * Display the specified Transaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        return view('transactions.show')->with('transaction', $transaction);
    }

    /**
     * Show the form for editing the specified Transaction.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        return view('transactions.edit')->with('transaction', $transaction);
    }

    /**
     * Update the specified Transaction in storage.
     *
     * @param int $id
     * @param UpdateTransactionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTransactionRequest $request)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        $transaction = $this->transactionRepository->update($request->all(), $id);

        Flash::success('Transaction updated successfully.');

        return redirect(route('transactions.index'));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $transaction = $this->transactionRepository->find($id);

        if (empty($transaction)) {
            Flash::error('Transaction not found');

            return redirect(route('transactions.index'));
        }

        $this->transactionRepository->delete($id);

        Flash::success('Transaction deleted successfully.');

        return redirect(route('transactions.index'));
    }
}
