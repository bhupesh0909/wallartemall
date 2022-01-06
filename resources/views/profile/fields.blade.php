<!-- Username Field -->
<div class="form-group col-sm-6">
    {!! Form::label('username', 'Username:') !!}
    {!! Form::text('username', null, ['class' => 'form-control']) !!}
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

<!-- State Field -->
<div class="form-group col-sm-6">
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
    <a href="{!! route('dashboard.index') !!}" class="btn btn-default">Cancel</a>
</div>
