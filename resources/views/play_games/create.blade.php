@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Play Game
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'playGames.store']) !!}

                        @include('play_games.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
