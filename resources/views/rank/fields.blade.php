<!-- Matches Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('level', 'Level:') !!}
    {!! Form::text('level', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Matches Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('matches', 'Matches:') !!}
    {!! Form::text('matches', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('rank.index') }}" class="btn btn-default">Cancel</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>


    jQuery(document).ready(function () {
     
		$('#select2').select2();
	
    });

</script>