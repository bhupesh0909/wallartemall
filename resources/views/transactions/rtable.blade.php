<div class="table-responsive">
    <table class="table" id="referrals-table">
        <thead>
        <tr class="bg-info text-center ">
            <th>User Id</th>
            <th>Transaction Id</th>
            <th>Amount</th>
            <th>Date Time</th>
        </tr>
        </thead>
        <!-- <tbody>
		{{$referrals->links()}}
        @foreach($referrals as $ref)
		<?php 
			// $userData = App\User::select('username')->where('id',$ref->user_id)->first();
			
		?>
            <tr>
                <td>{!! (!empty($userData['username']))? $userData['username']:''!!}</td>
                <td>{!! $ref->transaction_id !!}</td>
                <td>{!! $ref->amount !!}</td>
                <td>{!! $ref->date_time !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table> -->
</div>

<script>

</script>	
