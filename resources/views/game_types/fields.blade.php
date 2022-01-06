<!-- Game Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_type', 'Game Type:') !!}
    {!! Form::text('game_type', null, ['class' => 'form-control','id'=>'game_type']) !!}
</div>

<!-- Game Icon Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_icon', 'Game Icon:') !!}
    <input type="file" class="form-control" name="game_icon" id="game_icon"/>
    {{--{!! Form::file('game_icon', null, ['class' => 'form-control']) !!}--}}
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!}
    <textarea name="description" class="form-control" rows="5">{!! (!empty($gameType))? $gameType->description : '' !!}</textarea>
    {{--{!! Form::text('description', null, ['class' => 'form-control']) !!}--}}
</div>

<!-- Is Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <select name="is_active" id="is_active" class="form-control">
        <option value="0" {{(!empty($gameType) && $gameType->is_active)? 'selected' : ''}}>Inactive</option>
        <option value="1" {{(!empty($gameType) && $gameType->is_active)? 'selected' : ''}}>Active</option>
    </select>
    {{--{!! Form::text('is_active', null, ['class' => 'form-control']) !!}--}}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('gameTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
