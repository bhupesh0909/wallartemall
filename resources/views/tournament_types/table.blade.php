<div class="table-responsive">
    <table class="table" id="tournamentTypes-table">
        <thead>
        <tr>
            <th>Tournament Type</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tournamentTypes as $tournamentType)
            <tr>
                <td width="70%">{!! $tournamentType->tournament_type !!}</td>
                <td>
                    @if(!empty($tournamentType->status))
						<label class="text-info text-center text-uppercase" name="mobile_verified"> Active</label>
                    @else
						<label class="text-danger text-center text-uppercase" name="mobile_verified"> Inactive</label>
                    @endif
					
                </td>
                <td>
                    {!! Form::open(['route' => ['tournamentTypes.destroy', $tournamentType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!-- <a href="{!! route('tournamentTypes.show', [$tournamentType->id]) !!}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                        <a href="{!! route('tournamentTypes.edit', [$tournamentType->id]) !!}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
