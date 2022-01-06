<div class="table-responsive">
    <table class="table" id="promotions-table">
        <thead>
        <tr>
            <th>Promo Code</th>
            <th>Description</th>
            <th>Is Active</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->promo_code }}</td>
                <td>{{ $promotion->description }}</td>
                <td>
                    @if($promotion->is_active == 1)
                        <a href="{{ url('is_active_promotion').'/'.$promotion->id }}" class="btn btn-success"
                           name="is_status">Active</a>
                    @else
                        <a href="{{ url('is_active_promotion').'/'.$promotion->id }}" class="btn btn-danger"
                           name="is_status">Inactive</a>
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['promotions.destroy', $promotion->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('promotions.show', [$promotion->id]) }}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('promotions.edit', [$promotion->id]) }}" class='btn btn-default btn-xs'><i
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
