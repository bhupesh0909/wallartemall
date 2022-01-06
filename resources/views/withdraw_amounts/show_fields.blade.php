<!-- User Id Field -->
<div class="form-group">
    {!! Form::label('user_id', 'User Id:') !!}
    <p>{{ $withdrawAmount->user_id }}</p>
</div>

<!-- Amount Field -->
<div class="form-group">
    {!! Form::label('amount', 'Amount:') !!}
    <p>{{ $withdrawAmount->amount }}</p>
</div>

<!-- Is Released Field -->
<div class="form-group">
    {!! Form::label('is_released', 'Is Released:') !!}
    @if($withdrawAmount->is_released == 'checked')
        <a href="{{ url('payment_release/'.$withdrawAmount->id) }}" class="btn btn-info">
            <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> &nbsp; Under Process</a>
    @elseif($withdrawAmount->is_released == 'pending')
        <a href="{{ url('payment_release/'.$withdrawAmount->id) }}" class="btn btn-danger">
            <i class="fa fa-bell" aria-hidden="true"></i> &nbsp; Pending</a>
    @else
        <button class="btn btn-success">
            <i class="fa fa-money" aria-hidden="true"></i> &nbsp; Released
        </button>
    @endif
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $withdrawAmount->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $withdrawAmount->updated_at }}</p>
</div>

