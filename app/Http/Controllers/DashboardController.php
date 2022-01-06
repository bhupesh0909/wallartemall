<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChipRequest;
use App\Http\Requests\UpdateChipRequest;
use App\Models\GameType;
use App\Models\Transaction;
use App\Models\WithdrawAmount;
use App\Repositories\ChipRepository;
use App\Http\Controllers\AppBaseController;
use App\User;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\DB;
use Response;

class DashboardController extends AppBaseController
{
    /** @var  ChipRepository */
    private $chipRepository;
    private $user;

    public function __construct(ChipRepository $chipRepo, User $user)
    {
        $this->chipRepository = $chipRepo;
        $this->user = $user;
    }

    /**
     * Display a listing of the Chip.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {

        /*$get_user_join_monthly = User::whereYear('created_at', Carbon::now()->year('2019'))
            ->whereMonth('created_at', Carbon::now()->month())
            ->count();*/

        $monthly_new_registered_users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"), date('Y'))
            ->where('role', 'user')->get();

        $chart_monthly_new_registered_users = Charts::database($monthly_new_registered_users, 'pie', 'highcharts')
            ->title("Monthly new Register Users")
            ->elementLabel("Total Users")
            ->dimensions(500, 250)
            ->responsive(false)
            ->groupByMonth(date('Y'), true);

        $total_games = GameType::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"), date('Y'))
            ->where('is_active', '1')
            ->get();

        $chart_total_games = Charts::database($total_games, 'pie', 'highcharts')
            ->title("Game List")
            ->elementLabel("Total Games")
            ->dimensions(500, 250)
            ->responsive(false)
            ->groupByMonth(date('Y'), true);

        $get_winner = Transaction::sum('amount');
        $get_withdraw = WithdrawAmount::where('is_released', 'released')->sum('amount');

        $income_chart = Charts::create('donut', 'highcharts')
            ->title('Account Management')
            ->labels(['Income', 'Loss'])
            ->values([$get_winner, $get_withdraw])
            ->dimensions(900, 450)
            ->responsive(false);

        return view('dashboard', compact('chart_monthly_new_registered_users', 'chart_total_games', 'income_chart'));
    }

    /**
     * Show the form for creating a new Chip.
     *
     * @return Response
     */
    public function create()
    {
        $users = $this->user->GetPlayers();
        return view('chips.create', compact('users'));
    }

    /**
     * Store a newly created Chip in storage.
     *
     * @param CreateChipRequest $request
     *
     * @return Response
     */
    public function store(CreateChipRequest $request)
    {
        $input = $request->all();

        $chip = $this->chipRepository->create($input);
        $update_user_chip = $this->chipRepository->UpdateChipsInUser($input);

        Flash::success('Chip saved successfully.');

        return redirect(route('chips.index'));
    }

    /**
     * Display the specified Chip.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        return view('chips.show')->with('chip', $chip);
    }

    /**
     * Show the form for editing the specified Chip.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        return view('chips.edit')->with('chip', $chip);
    }

    /**
     * Update the specified Chip in storage.
     *
     * @param int $id
     * @param UpdateChipRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateChipRequest $request)
    {
        $chip = $this->chipRepository->find($id);

        if (empty($chip)) {
            Flash::error('Chip not found');

            return redirect(route('chips.index'));
        }

        $chip = $this->chipRepository->update($request->all(), $id);

        Flash::success('Chip updated successfully.');

        return redirect(route('chips.index'));
    }

    /**
     * Remove the specified Chip from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $chip = $this->chipRepository->find($id);
        if (empty($chip)) {
            Flash::error('Chip not found');
            return redirect(route('chips.index'));
        }

        $this->chipRepository->decreaseUserChip($chip['user_id'], $chip['chips_amount']);
        $this->chipRepository->delete($id);

        Flash::success('Chip deleted successfully.');

        return redirect(route('chips.index'));
    }
}
