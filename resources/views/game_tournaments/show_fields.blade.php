<!-- T Type Field -->
<div class="form-group">
    {!! Form::label('t_type', 'Tournament Type:') !!}
    <p>{!! $gameTournament->t_type !!}</p>
</div>

<!-- T Id Field -->
<div class="form-group">
    {!! Form::label('t_id', 'Tournament Id:') !!}
    <p>{!! $gameTournament->t_id !!}</p>
</div>

<!-- T Formate Field -->
<div class="form-group">
    {!! Form::label('t_format', 'Tournament Name:') !!}
    <p>{!! $gameTournament->t_format !!}</p>
</div>

<!-- Start Date Field -->
<div class="form-group">
    {!! Form::label('start_date', 'Start Date:') !!}
    <p>{!! $gameTournament->start_date !!}</p>
</div>

<!-- Entry Field -->
<div class="form-group">
    {!! Form::label('entry', 'Entry Fee:') !!}
    <p>{!! $gameTournament->entry !!}</p>
</div>

<!-- Starting Stack Field -->
<div class="form-group">
    {!! Form::label('starting_stack', 'Total Spot:') !!}
    <p>{!! $gameTournament->starting_stack !!}</p>
</div>

<!-- Prize Field -->
<div class="form-group">
    {!! Form::label('prize', 'Winning Prize:') !!}
    <p>{!! $gameTournament->prize !!}</p>
</div>

<!-- No Of Prizes Field -->
<div class="form-group">
    {!! Form::label('no_of_prizes', 'No Of Winner:') !!}
    <p>{!! $gameTournament->no_of_prizes !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $gameTournament->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $gameTournament->updated_at !!}</p>
</div>

