<div class="table-responsive">
    <table class="table" id="chips-table">
        <thead>
        <tr>
            <th>User Name</th>
            <th>Chips Amount</th>
            {{--            <th colspan="3">Action</th>--}}
        </tr>
        </thead>
        <tbody>
        @foreach($chips as $chip)
            <tr>
                @if(count($chip->users) != 0)
                    <td>{{ $chip->users[0]->username }}</td>
                @else
                    <td></td>
                @endif
                <td>{{ $chip->chips_amount }}</td>
            
                {{--<td>
                    {!! Form::open(['route' => ['chips.destroy', $chip->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('chips.show', [$chip->id]) }}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('chips.edit', [$chip->id]) }}" class='btn btn-default btn-xs'><i
                                class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>--}}
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
