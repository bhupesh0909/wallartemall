@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Awards
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($awards, ['route' => ['awards.update', $awards->id], 'method' => 'patch']) !!}

                        @include('awards.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection