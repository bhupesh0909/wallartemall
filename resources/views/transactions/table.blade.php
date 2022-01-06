<div class="table-responsive">
    <table class="table" id="transactions-table">
        <thead>
        <tr class="bg-info text-center ">
            <th>User Id</th>
            <th>Transaction Id</th>
            <th>Transaction Type</th>
            <th>Amount</th>
            <th>Date Time</th>
           {{-- <th>Status</th>
			 <th>Action</th>--}}
        </tr>
        </thead>
        <!-- <tbody>
        @foreach($transactions as $transaction)
		<?php 
			// $userData = App\User::select('username')->where('id',$transaction->user_id)->first();
			
		?>
            <tr>
                <td>{!! (!empty($transaction->user))? $transaction->user->username:'' !!}</td>
                <td>{!! $transaction->transaction_id !!}</td>
                <td>{!! $transaction->trans_type !!}</td>
                <td>{!! $transaction->amount !!}</td>
                <td>{!! date('d-m-Y H:i:s',strtotime($transaction->date_time)) !!}</td>
              {{--   <td>
                    @if($transaction->status == "success")
						<label class="text-info text-center text-uppercase" name="mobile_verified"> Success</label>
                    @else
						<label class="text-danger text-center text-uppercase" name="mobile_verified"> Failure</label>
                    @endif
                </td>
               <td>
                    {!! Form::open(['route' => ['transactions.destroy', $transaction->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{!! route('transactions.show', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{!! route('transactions.edit', [$transaction->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>--}}
            </tr>
        @endforeach
        </tbody> -->
    </table>
</div>

<script>

</script>	
