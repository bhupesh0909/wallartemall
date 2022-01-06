<div class="table-responsive">
    <table class="table" id="withdrawAmounts-table">
        <thead>
        <tr class="bg-info text-center">
            <th>User Id</th>
            <th>User Name</th>
            <th>Amount</th>
            <th>Is Released</th>
            <th>Updated</th>
            <th>Action</th>
        </tr>
        </thead>
        <!-- <tbody>
		<?php
		
		//$old = $withdrawAmounts;
		
			if(isset($_GET["report_type"]))
			{
				$reporttype = $_GET["report_type"];
				
				if($reporttype == "pending" )
				{
					$withdrawAmounts = $withdrawAmounts->filter(function ($value, $key) {
						return $value->is_released == 'pending';
							});
				}
				elseif($reporttype == "checked" )
				{
					$withdrawAmounts = $withdrawAmounts->filter(function ($value, $key) {
						return $value->is_released == 'checked';
						});
				}
				else
				{
					$withdrawAmounts = $withdrawAmounts->filter(function ($value, $key) {
						return $value->is_released == 'released';
							});
				}
			}
		
		//dd($dds);
		?>
        @foreach($withdrawAmounts as $withdrawAmount)
            <tr>
                <td>{{ $withdrawAmount->user_id }}</td>
                 <td>
					@if(count($withdrawAmount->user) != 0)
							{{ $withdrawAmount->user[0]->username }}
						@else
					   
					@endif
				</td>
                <td>{{ $withdrawAmount->amount }}</td>
                <td>
                    @if($withdrawAmount->is_released == 'checked')
                        <label class="text-info text-center text-uppercase">
                            <i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i> &nbsp; Checked
                        </label>
                    @elseif($withdrawAmount->is_released == 'pending')
                        <a href="{{ url('payment_release/'.$withdrawAmount->id) }}" class="btn btn-danger text-center text-uppercase">
                            <i class="fa fa-bell" aria-hidden="true"></i> &nbsp; Pending</a>
                    @else
                        <label class="text-success text-center text-uppercase">
                            <i class="fa fa-money" aria-hidden="true"></i> &nbsp; Released
                        </label>
                    @endif
                </td>
                <td>{!! date('d-m-Y H:i:s',strtotime($withdrawAmount->updated_at)) !!}</td>

                <td>
                    {!! Form::open(['route' => ['withdrawAmounts.destroy', $withdrawAmount->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('withdrawAmounts.show', [$withdrawAmount->id]) }}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        {{--<a href="{{ route('withdrawAmounts.edit', [$withdrawAmount->id]) }}"
                           class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}--}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody> -->
    </table>
</div>
