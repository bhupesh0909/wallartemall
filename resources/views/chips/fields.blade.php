<!-- User Id Field -->


<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {{--{!! Form::text('user_id', null, ['class' => 'form-control']) !!}--}}
    <select class="form-control" id="select2" name="user_id" required>
        <option value="">-- Select User --</option>
        @foreach($users as $o)
            @if($chip != null)
                @if($o->id == $chip->user_id)
                    <option value="{{ $o->id }}" selected>{{ $o->username }}</option>
                @else
                    <option value="{{ $o->id }}">{{ $o->username }}</option>
                @endif
            @else
                <option value="{{ $o->id }}">{{ $o->username }}</option>
            @endif

        @endforeach
    </select>
</div>

<!-- Chips Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('chips_amount', 'Chips Amount:') !!}
    {!! Form::text('chips_amount', null, ['class' => 'form-control','required'=>'required']) !!}
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