@extends('layouts.app')
@section('content')
<section class="content-header">
    <h1 class="pull-left">User Activity</h1>
    <h1 class="pull-right"></h1>
</section>
<div class="content">
    <!-- <div class="pull-right" style="margin-bottom:10px;">
        <form name='reports'>
            <select name='report_type' class="form-control" onchange="reports.submit()">
                <option value=''>Select Report</option>
                <option value='game' <?= (isset($_GET['report_type']) && $_GET['report_type'] === 'game') ? 'selected' : '' ?>>Game</option>
                <option value='chips' <?= (isset($_GET['report_type']) && $_GET['report_type'] === 'chips') ? 'selected' : '' ?>>Chips</option>
            </select>
        </form>
    </div> -->
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="table-responsive">
        @if(isset($_GET['report_type']) && $_GET['report_type'] === 'chips')
        <table class="table" id="userActivity-chips-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Game</th>
                    <th>Game Type</th>
                    <th>Tournament</th>
                    <th>Status</th>
                    <th>Entry Fee</th>
                    <th>Win Amount</th>
                    <th>Played On</th>
                    <th>Result Date</th>
                </tr>
            </thead>
        </table>        
        @else
        <table class="table" id="userActivity-game-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Game</th>
                    <th>Game Type</th>
                    <th>Tournament</th>
                    <th>Status</th>
                    <th>Entry Fee</th>
                    <th>Win Amount</th>
                    <th>Played On</th>
                    <th>Result Date</th>
                </tr>
            </thead>
        </table>
        @endif
    </div>
    <div class="text-center"></div>
</div>
@endsection