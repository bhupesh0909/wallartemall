@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="col-lg-6">
                {!! $chart_monthly_new_registered_users->html() !!}
            </div>


            <div class="col-lg-6">
                {!! $chart_total_games->html() !!}
            </div>
        </div>
		<div class="container" style="margin-top:20px;">
            <div class="col-lg-12 text-center" style="display: flex;align-items: center;justify-content: center;">
                {!! $income_chart->html() !!}
            </div>
        </div>
    </div>
    {!! Charts::scripts() !!}
    {!! $chart_monthly_new_registered_users->script() !!}
    {!! $chart_total_games->script() !!}
    {!! $income_chart->script() !!}
@endsection