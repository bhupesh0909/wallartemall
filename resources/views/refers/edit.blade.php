@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Reffer
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($reffer, ['route' => ['refers', $reffer->id], 'method' => 'patch']) !!}

                        @include('refers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection