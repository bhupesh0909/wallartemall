<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $chip->user_id }}</p>
</div>

<!-- Chips Amount Field -->
<div class="form-group">
    {!! Form::label('chips_amount', 'Chips Amount:') !!}
    <p>{{ $chip->chips_amount }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $chip->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $chip->updated_at }}</p>
</div>

