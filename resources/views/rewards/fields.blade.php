<!-- Chips Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reward', 'Reward:') !!}
    {!! Form::text('reward', null, ['class' => 'form-control','required'=>'required']) !!}
</div>
<!-- Chips Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chips', 'Chips:') !!}
    {!! Form::text('chips', null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('chips.index') }}" class="btn btn-default">Cancel</a>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>


    jQuery(document).ready(function () {
     
		$('#select2').select2();
	
    });

</script>