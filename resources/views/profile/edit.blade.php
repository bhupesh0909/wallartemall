@extends('layouts.app')

@section('content')
<style>
 .closeText:before {
        content: "Close";
    }
</style>
    <section class="content-header">
        <h1>
            Admin Profile
        </h1>
   </section>
   <div class="content">
     <div class="clearfix"></div>
	@include('flash::message')
   
       @include('adminlte-templates::common.errors')
       <div class="">
           <div class="box-body">
               <div class="row">
					<div class="col-md-6">
						  <div class="box box-primary">
						 <div class="box-body">
						  <h4>
							Admin Profile
						</h4>	
					
					   {!! Form::model($userRegistration, ['route' => ['userRegistrations.updateProfile', $userRegistration->id], 'method' => 'patch']) !!}

							@include('profile.fields')

					   {!! Form::close() !!}
					</div>
					</div>
				   </div>
				   
				   <div class="col-md-6 ">
				     <div class="box box-primary">
				    <div class="box-body">
						  <h4>
							Change Password
						</h4>	
						
					   {!! Form::model($userRegistration, ['route' => ['userRegistrations.updatePassword', $userRegistration->id], 'method' => 'patch']) !!}
						
							<!-- Username Field -->
							<div class="form-group col-sm-12">
								{!! Form::label('oldPassword', 'Old Password:') !!}
								{!! Form::password('oldPassword', array('class'=>'form-control' )) !!}
							</div>

							<!-- Email Field -->
							<div class="form-group col-sm-12">
								{!! Form::label('new_password', 'New Password:') !!}
								{!! Form::password('new_password',['class' => 'form-control']) !!}
							</div>

							<!-- Dob Field -->
							<div class="form-group col-sm-12">
								{!! Form::label('cPassword', 'Confirm Password:') !!}
								{!! Form::password('cPassword',['class' => 'form-control']) !!}
							</div>
							<!-- Submit Field -->
							<div class="form-group col-sm-12">
								{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
								<a href="{!! route('dashboard.index') !!}" class="btn btn-default">Cancel</a>
							</div>
					   {!! Form::close() !!}
				   </div>
				   </div>
				   </div>
				   
               </div>
			   
           </div>
       </div>
	   
	  
	   
	   
   </div>
   
  
   
@endsection