@extends('layouts.app')

@section('content')
    <section class="content-header">
	
<?php
if(isset($_GET["report_type"]))
{
	$reporttype = $_GET["report_type"];
	
	if($reporttype == "deposit" )
		$t = "Deposit Transactions";
	elseif($reporttype == "refer")
	$t = "Referral Transactions";	
	elseif(in_array($_GET['report_type'], ['', 'gameresult']))
	$t = "Game Result";
}
else
	$t = "Deposit Transactions";
?>	
        <h1 class="pull-left">{{$t}}</h1>
        <h4 class="pull-right">
           {{--<a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('transactions.create') !!}">Add New</a>--}}
		   <form name='reports'>
			   <select name='report_type' onchange="reports.submit()">
					<option value=''>Select Report</option>
					<option value='deposit' <?=(isset($_GET['report_type']) && $_GET['report_type'] === 'deposit')? 'selected':''?>>Deposit</option>
					<option value='refer' <?=(isset($_GET['report_type']) && $_GET['report_type'] === 'refer')? 'selected':''?>>Referral</option>
					<option value='gameresult' <?=(isset($_GET['report_type']) && in_array($_GET['report_type'], ['', 'gameresult']))? 'selected':''?>>Game Result</option>
			   </select>
		   </form>
        </h4>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
		
        <div class="box box-primary">

            <div class="box-body">

			@if(isset($_GET["report_type"]))				
				@if($reporttype == "deposit" )
					@include('transactions.table')
				@elseif($reporttype == "refer" )
					@include('transactions.rtable')
				@else
					@include('transactions.gtable')
				@endif

			@else
                    @include('transactions.table')
			@endif
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')

@endsection
