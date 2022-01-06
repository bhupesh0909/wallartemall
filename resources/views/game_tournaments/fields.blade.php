<!-- T Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('t_type', 'Tournament Type:') !!}
    <select class="form-control" name="t_type" required>
        @foreach($tournament_types as $o)
            <option value="{{ $o->id }}" <?=( isset($gameTournament) && $gameTournament->t_type === $o->id)? 'selected':''?>>{{ $o->tournament_type }}</option>
        @endforeach
    </select>
    {{--{!! Form::text('t_type', null, ['class' => 'form-control']) !!}--}}
</div>

<!-- T Format Field -->
<div class="form-group col-sm-6">
    {!! Form::label('t_format', 'Tournament Name:') !!}
    {!! Form::text('t_format', null, ['class' => 'form-control']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    {!! Form::text('start_date', null, ['class' => 'form-control','id'=>'start_date1','autocomplete'=>'off', 'value'=> (isset($gameTournament))? $gameTournament->start_date:'']) !!}
</div>

<!-- Entry Field -->
<div class="form-group col-sm-6">
    {!! Form::label('entry', 'Entry Fee:') !!}
    {!! Form::number('entry', null, ['class' => 'form-control']) !!}
</div>

<!-- Starting Stack Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_stack', 'Total Spot:') !!}
    {!! Form::number('starting_stack', null, ['class' => 'form-control']) !!}
</div>

<!-- Prize Field -->
<div class="form-group col-sm-6">
    {!! Form::label('prize', 'Winning Prize:') !!}
    {!! Form::number('prize', null, ['class' => 'form-control']) !!}
</div>

<!-- Banner Field -->
<div class="form-group col-sm-6">
    {!! Form::label('banner', 'Banner:') !!}
    {!! Form::file('banner', null, ['class' => 'form-control']) !!}
</div>

<!-- No Of Prizes Field -->
{{--<div class="form-group col-sm-6">
    {!! Form::label('no_of_prizes', 'Total Winners:') !!}
    {!! Form::number('no_of_prizes', null, ['class' => 'form-control']) !!}
</div>--}}

{{--<!-- Cash Prize Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cash_prize', 'Cash Prize:') !!}
    {!! Form::text('cash_prize', null, ['class' => 'form-control']) !!}
</div>--}}

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('gameTournaments.index') !!}" class="btn btn-default">Cancel</a>
</div>
