<!-- Send To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('send_to', 'Send To:') !!}
    {!! Form::text('send_to', null, ['class' => 'form-control']) !!}
</div>

<!-- Send By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('send_by', 'Send By:') !!}
    {!! Form::text('send_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('sendInvitations.index') }}" class="btn btn-default">Cancel</a>
</div>
