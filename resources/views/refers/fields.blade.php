<!-- Reffer By Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reffer_by', 'Refer') !!}
    {!! Form::text('reffer_by', null, ['class' => 'form-control']) !!}
</div>

<!-- Reffer To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reffer_to', 'Reffer To:') !!}
    {!! Form::text('reffer_to', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('refers') }}" class="btn btn-default">Cancel</a>
</div>
