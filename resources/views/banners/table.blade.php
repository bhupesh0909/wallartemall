<div class="table-responsive">
    <table class="table" id="banners-table">
        <thead>
        <tr>
            <th>Banner Image</th>
            <th>Status</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($banners as $banner)
		
		<?php 
			
			if($banner->banner_image){
				$img_name = asset('public/banner_image/'.$banner->banner_image);
			}
			else
			{
				$img_name = asset('public/images').'/NoImage.png';
			}
			
			?>
		
		
            <tr>
                <td><img src="{{ $img_name }}" class="img-responsive"
                         style="height: 100px; width: 100px;"></td>
                {{--<td>{{ $banner->is_active }}</td>--}}
                <td>
                    @if($banner->is_active == 'active')
                        <a href="{{ url('banner_is_active').'/'.$banner->id }}" class="btn btn-success"
                           name="is_active">Active</a>
                    @else
                        <a href="{{ url('banner_is_active').'/'.$banner->id }}" class="btn btn-danger"
                           name="is_active">Inactive</a>
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['banners.destroy', $banner->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <!-- <a href="{{ route('banners.show', [$banner->id]) }}" class='btn btn-default btn-xs'><i
                                    class="glyphicon glyphicon-eye-open"></i></a> -->
                        <a href="{{ route('banners.edit', [$banner->id]) }}" class='btn btn-default btn-xs'><i
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
