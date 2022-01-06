<!-- Tournament Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tournament_type', 'Tournament Type:') !!}
    {!! Form::textarea('tournament_type', null, ['class' => 'form-control','rows'=>"3"]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <select class="form-control" name="status">
        <option value="1" <?=(!empty($tournamentType) && $tournamentType->status == 1)? 'selected':''?>>Active</option>
        <option value="0" <?=(!empty($tournamentType) && $tournamentType->status == 0)? 'selected':''?>>Inactive</option>
    </select>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tournamentTypes.index') !!}" class="btn btn-default">Cancel</a>
</div>
