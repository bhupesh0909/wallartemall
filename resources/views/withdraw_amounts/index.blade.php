@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Withdraw Amounts</h1>
        <h1 class="pull-right">
            {{--<a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('withdrawAmounts.create') }}">Add New</a>--}}
        </h1>
        <h4 class="pull-right">
		   <form name='reports'>
			   <select name='report_type'>
					<option value=''>Select Status</option>
					<option value='all' <?=(!isset($_GET['report_type']))? 'selected':''?>>All</option>
					<option value='pending' <?=(isset($_GET['report_type']) && in_array($_GET['report_type'], ['', 'pending']))? 'selected':''?>>Pending</option>
					<option value='checked' <?=(!empty($_GET['report_type']) && $_GET['report_type'] === 'checked')? 'selected':''?>>Checked</option>
					<option value='released' <?=(!empty($_GET['report_type']) && $_GET['report_type'] === 'released')? 'selected':''?>>Released</option>
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
                {{ $withdrawAmounts->links() }}
                @include('withdraw_amounts.table')
                {{ $withdrawAmounts->links() }}
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection


