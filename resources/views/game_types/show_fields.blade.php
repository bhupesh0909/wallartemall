<table class="table table-responsive">
    <thead>
    <tr>
        <th>#</th>
        <th>Game Type</th>
        <th>Game Icon</th>
        <th>Is Active</th>
        <th>Created At</th>
        <th>Updated At</th>
    </tr>
    </thead>
    <tbody>
    <tr>
	<?php 
			$path = url('public/images/game_icons');
			if($gameType->game_icon){
				$img_name = $path.'/'.$gameType->game_icon;
			}
			else
			{
				$img_name = url('public/images').'/NoImage.png';
			}
			
			?>
		<td></td>	
        <td><p>{!! $gameType->game_type !!}</p></td>
        <td><img src="{{ $img_name }}" class="img-responsive" height="150px" width="150px"></td>
        <td><p>{!! $gameType->is_active !!}</p></td>
        <td><p>{!! $gameType->created_at !!}</p></td>
        <td><p>{!! $gameType->updated_at !!}</p></td>
    </tr>
    </tbody>
</table>