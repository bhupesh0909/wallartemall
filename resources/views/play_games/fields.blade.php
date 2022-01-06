<!-- Game Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_type', 'Game Type:') !!}
    <select name="game_type" class="form-control">
        @foreach($gameType as $o)
            <option value="{{ $o->id }}">{{ $o->game_type }}</option>
        @endforeach
    </select>
</div>

<!-- Game Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('game_id', 'Game Id:') !!}
    {!! Form::text('game_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Total Players Field -->
<div class="form-group col-sm-6">
    {!! Form::label('total_players', 'Total Players:') !!}
    {!! Form::text('total_players', null, ['class' => 'form-control']) !!}
</div>

<!-- Entry Fee Field -->
<div class="form-group col-sm-6">
    {!! Form::label('entry_fee', 'Entry Fee:') !!}
    {!! Form::text('entry_fee', null, ['class' => 'form-control']) !!}
</div>

<!-- Game Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('is_active', 'Is Active:') !!}
    <select class="form-control" name="is_active">
        <option value="active" selected>Active</option>
        <option value="inactive">Inactive</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('playGames.index') !!}" class="btn btn-default">Cancel</a>
</div>
