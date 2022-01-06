<?php

namespace App\Http\Controllers;

use App\Models\Rewards;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use DataTables;

class RewardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rewards.index');
    }
    /**
     * datatable.
     *
     * @return \Illuminate\Http\Response
     */
    public function datatable(Request $req)
    {
        $rewards = Rewards::orderBy('created_at', 'DESC')->get();
        return DataTables::of($rewards)->make(true);
        // return DataTables::of($rewards)->addColumn('action', function ($query) {
        //     return '<a href="' . route("rewards.edit", $query->id) .
        //         '" class="btn btn-xs btn-primary" style="margin-right:10px;"><i class="glyphicon glyphicon-edit"></i></a>
        //         <a href="' . route("rewards.destroy", $query->id) .
        //         '" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i></a>';
        // })->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward' => 'required|string',
            'chips' => 'required|integer|between:1,500',
        ], [
            'chips.integer' => 'Chips must be in numeric'
        ]);
        $input = $request->all();
        // dd($input);
        Rewards::create($input);
        Flash::success('Reward Created.');
        return redirect('rewards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reward = Rewards::findOrFail($id);
        return view('rewards.edit', compact('reward'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reward = Rewards::findOrFail($id);
        $request->validate([
            'reward' => 'required|string',
            'chips' => 'required|integer|between:1,500',
        ], [
            'chips.integer' => 'Chips must be in numeric'
        ]);
        $input = $request->all();
        // dd($input);
        $reward->update($input);
        Flash::success('Reward Updated.');
        return redirect('rewards');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reward = Rewards::findOrFail($id);
        $reward->delete($id);
        Flash::success('Reward Deleted.');
        return redirect('rewards');
    }
}
