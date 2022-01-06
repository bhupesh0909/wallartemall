@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Chip
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($chip, ['route' => ['chips.update', $chip->id], 'method' => 'patch']) !!}

                        @include('chips.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection