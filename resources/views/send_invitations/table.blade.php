<div class="table-responsive">
    <table class="table" id="sendInvitations-table">
        <thead>
            <tr>
                <th>Send To</th>
        <th>Send By</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sendInvitations as $sendInvitation)
            <tr>
                <td>{{ $sendInvitation->send_to }}</td>
            <td>{{ $sendInvitation->send_by }}</td>
                <td>
                    {!! Form::open(['route' => ['sendInvitations.destroy', $sendInvitation->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('sendInvitations.show', [$sendInvitation->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('sendInvitations.edit', [$sendInvitation->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
