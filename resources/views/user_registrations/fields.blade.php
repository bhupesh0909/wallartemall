<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control','readonly'=>'readonly']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Dob Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dob', 'Dob:') !!}
    {!! Form::text('dob', null, ['class' => 'form-control','id'=>'dob']) !!}
</div>

<!-- @section('scripts')
// do not remove - this is working code

    <script type="text/javascript">
       
		
		$(document).ready(function () {
			var dob = $('#dob').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
				viewMode: 'days',
				showClose: true,
			})
			
		$('#dob').on('changeDate', function(){
				$('.datetimepicker').hide();
			});			
		});

		
    </script>
@endsection -->

<!-- Gender Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    {!! Form::text('gender', null, ['class' => 'form-control']) !!}
</div> -->

<div class="form-group col-sm-6">
    {!! Form::label('gender', 'Gender:') !!}
    <select name="gender" class="form-control">
        <option value="Male" <?= $userRegistration->gender=="Male"?'selected':'' ?> >Male</option>
        <option value="Female" <?= $userRegistration->gender=="Female"?'selected':'' ?>>Female</option>
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('mobile_number', 'Mobile Number:') !!}
    {!! Form::text('mobile_number', null, ['class' => 'form-control','id'=>'mobile_number']) !!}
</div>

 <div class="form-group col-sm-6">
    {!! Form::label('user_type', 'User Mode:') !!}
    {!! Form::text('user_type', null, ['class' => 'form-control','id'=>'user_type']) !!}
</div>



<div class="form-group col-sm-6">
    {!! Form::label('total_amount', 'Winning Amount:') !!}
    {!! Form::text('total_amount', null, ['class' => 'form-control','id'=>'user_mode']) !!}
</div>

<!-- State Field -->
<div class="form-group col-sm-6" style="display: none;">
    {!! Form::label('state', 'State:') !!}
    {!! Form::text('state', null, ['class' => 'form-control']) !!}
</div>

<!-- Social Media Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('social_media', 'Social Media:') !!}
    {!! Form::text('social_media', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userRegistrations.index') !!}" class="btn btn-default">Cancel</a>
</div>
