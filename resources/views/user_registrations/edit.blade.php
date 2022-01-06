@extends('layouts.app')

@section('content')
<style>
 .closeText:before {
        content: "Close";
    }
</style>
    <section class="content-header">
        <h1>
            User Registration
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userRegistration, ['route' => ['userRegistrations.update', $userRegistration->id], 'method' => 'patch']) !!}

                        @include('user_registrations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection