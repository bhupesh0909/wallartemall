<!-- Reffer By Field -->
<div class="form-group">
    {!! Form::label('reffer_by', 'Refer') !!}
    <p>{{ $reffer->reffer_by }}</p>
</div>

<!-- Reffer To Field -->
<div class="form-group">
    {!! Form::label('reffer_to', 'Reffer To:') !!}
    <p>{{ $reffer->reffer_to }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $reffer->status }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $reffer->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $reffer->updated_at }}</p>
</div>

