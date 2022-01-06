<div class="table-responsive">
    <table class="table" id="gameTournaments-table">
        <thead>
        <tr>
            <th>Tournament Type</th>
            <th>Tournament Id</th>
            <th>Tournament Name</th>
            <th>Start Date</th>
            <th>Entry Fee</th>
            <th>Total Spot</th>
            <th>Winning Prize</th>
{{--            <th>Total Winners</th>--}}
            {{--<th>Winning Prize</th>--}}
            <th >Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($gameTournaments as $gameTournament)
            <tr>
                <td>{!! $gameTournament->tournament_type !!}</td>
                <td>{!! $gameTournament->t_id !!}</td>
                <td>{!! $gameTournament->t_format !!}</td>
                <td>{!! date('d-m-Y',strtotime($gameTournament->start_date)) !!}</td>
                <td>{!! $gameTournament->entry !!}</td>
                <td>{!! $gameTournament->starting_stack !!}</td>
                <td>{!! $gameTournament->prize !!}</td>
{{--                <td>{!! $gameTournament->no_of_prizes !!}</td>--}}
                {{--<td>{!! $gameTournament->cash_prize !!}</td>--}}
                <td>
                    {!! Form::open(['route' => ['gameTournaments.destroy', $gameTournament->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!-- <a href="{!! route('gameTournaments.show', [$gameTournament->id]) !!}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                        <a href="{!! route('gameTournaments.edit', [$gameTournament->id]) !!}"
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
