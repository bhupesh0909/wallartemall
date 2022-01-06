<div class="table-responsive">
    <table class="table" id="gameresult-table">
        <thead>
        <tr class="text-center bg-info">
            <th class="text-center">User Id</th>
            <th class="text-center">Game Type</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Status</th>
            <th class="text-center">Date Time</th>
        </tr>
        </thead>
        <!-- <tbody>
		{{$gameresult->links()}}
        @foreach($gameresult as $gs)
		<?php 
			// $userData = App\User::select('username')->where('id',$gs->user_id)->first();
			
		?>
            <tr class="text-center">
                <td>{!! (!empty($userData['username']))? $userData['username']:''!!}</td>
                <td>{!! $gs->game_type !!}</td>
                <td>{!! $gs->win_amount !!}</td>
                <td>
						@if($gs->status == "loss")
							<label class="text-danger text-center text-uppercase"> {!! $gs->status !!}</label>
						@else
							<label class="text-info text-center text-uppercase"> {!! $gs->status !!}</label>
						@endif
					
				</td>
                <td>{!! $gs->created_at !!}</td>
            </tr>
        @endforeach
        </tbody> -->
    </table>
</div>

<script>

</script>	
