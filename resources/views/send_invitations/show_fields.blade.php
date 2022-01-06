<!-- Send To Field -->
<div class="form-group">
    {!! Form::label('send_to', 'Send To:') !!}
    <p>{{ $sendInvitation->send_to }}</p>
</div>

<!-- Send By Field -->
<div class="form-group">
    {!! Form::label('send_by', 'Send By:') !!}
    <p>{{ $sendInvitation->send_by }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $sendInvitation->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $sendInvitation->updated_at }}</p>
</div>

