<!-- Tournament Type Field -->
<div class="form-group">
    {!! Form::label('tournament_type', 'Tournament Type:') !!}
    <p>{!! $tournamentType->tournament_type !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>
	 @if(!empty($tournamentType->status))
			Active
	@else
			Inactive
	@endif
	</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $tournamentType->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $tournamentType->updated_at !!}</p>
</div>

