<div class="table-responsive">
    <table class="table" id="subscriptions-table">
        <thead>
            <tr>
                <th>Subscription Title</th>
        <th>Description</th>
        <th>Amount</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($subscriptions as $subscription)
            <tr>
                <td>{!! $subscription->subscription_title !!}</td>
            <td>{!! $subscription->description !!}</td>
            <td>{!! $subscription->amount !!}</td>
                <td>
                    {!! Form::open(['route' => ['subscriptions.destroy', $subscription->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!-- <a href="{!! route('subscriptions.show', [$subscription->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> -->
                        <a href="{!! route('subscriptions.edit', [$subscription->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
