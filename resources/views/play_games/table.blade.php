<div class="table-responsive">
    <table class="table" id="playGames-table">
        <thead>
        <tr>
            <th>Game Type</th>
            <th>Game Id</th>
            <th>User Id</th>
            <th>Total Players</th>
            <th>Entry Fee</th>
            <th>Game Status</th>
            <th>Date Created</th>
{{--            <th colspan="3">Action</th>--}}
        </tr>
        </thead>
        <!-- <tbody>
        @foreach($playGames as $playGame)
            <tr>
                <td>{!! $playGame->game_type !!}</td>
                <td>{!! $playGame->game_id !!}</td>
                <td>{!! $playGame->username !!}</td>
                <td>{!! $playGame->total_players !!}</td>
                <td>{!! $playGame->entry_fee !!}</td>
                <td>
                    @if($playGame->status == "loss")
						<label class="text-danger text-center text-uppercase" name="mobile_verified"> loss</label>
                    @else
						<label class="text-info text-center text-uppercase" name="mobile_verified"> win</label>
                    @endif
				</td>
                <td>{!! date('d-m-Y H:i:s',strtotime($playGame->created_at)) !!}</td>
                {{--<td>
                    {!! Form::open(['route' => ['playGames.destroy', $playGame->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('playGames.show', [$playGame->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('playGames.edit', [$playGame->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>--}}
            </tr>
        @endforeach
        </tbody> -->
    </table>
</div>
