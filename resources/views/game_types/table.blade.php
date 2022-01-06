<div class="table-responsive">
    <table class="table" id="gameTypes-table">
        <thead>
        <tr>
            <th>#</th>
            <th>Game Type</th>
            <th>Game Icon</th>
            <th>Is Active</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($gameTypes as $gameType)
			
			<?php 
			$path = url('images/game_icons');
			if($gameType->game_icon){
				$img_name = $path.'/'.$gameType->game_icon;
			}
			else
			{
				$img_name = asset('images').'/NoImage.png';
			}
			
			?>
		
            <tr>
                <td>{!! $gameType->id !!}</td>
                <td>{!! $gameType->game_type !!}</td>
                <td><img src="{!! $img_name !!}" class="img-thumbnail" height="100px" width="100px"></td>
                <td>
                    @if($gameType->is_active == 1)
                        <a href="{{ url('game_action').'/'.$gameType->id }}" class="btn btn-success" name="is_status">Active</a>
                    @else
                        <a href="{{ url('game_action').'/'.$gameType->id }}" class="btn btn-danger" name="is_status">Inactive</a>
                    @endif
                </td>
                <td>{!! $gameType->description !!}</td>
                <td>
                    {!! Form::open(['route' => ['gameTypes.destroy', $gameType->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!-- <a href="{!! route('gameTypes.show', [$gameType->id]) !!}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a> -->
                        <a href="{!! route('gameTypes.edit', [$gameType->id]) !!}" class='btn btn-default btn-xs'><i
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
