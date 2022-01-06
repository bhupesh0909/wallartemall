<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayerRankings;
use Laracasts\Flash\Flash;
use DataTables;
class PlayerrankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rank.index');
    }

    public function datatable(Request $req)
    {
        $rewards = PlayerRankings::orderBy('created_at', 'DESC')->get();
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
        return view('rank.create');
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
            'level' => 'required|string',
            'matches' => 'required|integer',
        ], [
            'matches.integer' => 'Matches must be in numeric'
        ]);
        $input = $request->all();
        // dd($input);
        PlayerRankings::create($input);
        Flash::success('Rank Created.');
        return redirect('rank');
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
        $rank = PlayerRankings::findOrFail($id);
        return view('rank.edit', compact('rank'));
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
        $rank = PlayerRankings::findOrFail($id);
        $request->validate([
            'level' => 'required|string',
            'matches' => 'required|integer',
        ], [
            'matches.integer' => 'Matches must be in numeric'
        ]);
        $input = $request->all();
        // dd($input);
        $rank->update($input);
        Flash::success('Rank Updated.');
        return redirect('rank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rank = PlayerRankings::findOrFail($id);
        $rank->delete($id);
        Flash::success('Rank Deleted.');
        return redirect('rank');
    }
}
