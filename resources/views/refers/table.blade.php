<div class="table-responsive">
    <table class="table" id="refers-table">
        <thead>
        <tr>
            <th>Refer By</th>
            <th>Refer To</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($refers as $refer)
            <tr>
                <td>{{ $refer->refer_by }}</td>
                <td>{{ $refer->refer_to }}</td>
                <td>{{ $refer->status }}</td>
                <td>
                    {!! Form::open(['route' => ['refers.destroy', $refer->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('refers.show', [$refer->id]) }}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('refers.edit', [$refer->id]) }}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
