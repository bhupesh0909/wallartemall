<!-- Promo Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('promo_code', 'Promo Code:') !!}
    {!! Form::text('promo_code', null, ['class' => 'form-control','maxlength' => 255]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::text('description', null, ['class' => 'form-control','maxlength' => 1000]) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('promotions.index') }}" class="btn btn-default">Cancel</a>
</div>
