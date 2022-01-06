<!-- Promo Code Field -->
<div class="form-group">
    {!! Form::label('promo_code', 'Promo Code:') !!}
    <p>{{ $promotion->promo_code }}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $promotion->description }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $promotion->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $promotion->updated_at }}</p>
</div>

