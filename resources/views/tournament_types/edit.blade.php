@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Tournament Type
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tournamentType, ['route' => ['tournamentTypes.update', $tournamentType->id], 'method' => 'patch']) !!}

                        @include('tournament_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection