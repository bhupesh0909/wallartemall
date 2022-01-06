@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Game Tournament
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'gameTournaments.store', 'files' => true]) !!}

                        @include('game_tournaments.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script>

var d = new Date();

var dd = d.getDate();
var mm = d.getMonth()+3;
var YY = d.getFullYear();

 $(document).ready(function () {
        $('#start_date1').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss',
			minDate: new Date(),
			maxDate: new Date(''+YY+'-'+mm+'-'+dd+''),
			showClose: true,
		 });
		 

	 
 });
</script>