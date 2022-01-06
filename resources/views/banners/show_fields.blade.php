<!-- Banner Image Field -->

<?php 
			
			if($banner->banner_image){
				$img_name = url('public/banner_image/'.$banner->banner_image);
			}
			else
			{
				$img_name = url('public/images').'/NoImage.png';
			}
			
			?>
		

<div class="form-group">
    {!! Form::label('banner_image', 'Banner Image:') !!}
    <p><img src="{{ $img_name }}" class="img-responsive" width="200px"
            height="200px"></p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $banner->is_active }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $banner->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $banner->updated_at }}</p>
</div>