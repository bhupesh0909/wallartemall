@extends('layouts.app')

@section('content')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>

    <script>
        $.validator.addMethod('filesize', function (value, element, param) {
            return this.optional(element) || (element.files[0].size <= param)
        }, 'File size must be less than {0}');

        jQuery(function ($) {
            "use strict";
            $('#banner').validate({
                rules: {                
                    banner_image: {
                        required: true,
                        extension: "jpeg,png,jpg,gif,svg",
                        filesize: 1000000,
                    }
                },
                messages: {
                banner_image:{
                    filesize:" file size must be less than 1Mb.",
                    extension:"Please upload .jpg or .png or .gif file only.",
                    required:"Please upload file."
                }
            },
            });
        });
    </script>

    <section class="content-header">
        <h1>
            Banner
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                {!! Form::model($banner, ['route' => ['banners.update', $banner->id], 'method' => 'patch','enctype'=>'multipart/form-data','id'=>'banner']) !!}

                {{--@include('banners.fields')--}}
					
                <!-- Banner Image Field -->
                    <div class="form-group col-sm-6">
                        {!! Form::label('banner_image', 'Banner Image:') !!}
                        <input type="file" class="form-control" name="banner_image" id="banner_image">
                        {{--    {!! Form::file('banner_image', null, ['class' => 'form-control']) !!}--}}
                    </div>
					
					<div class="form-group col-sm-6">
						{!! Form::label('is_active', 'Is Active:') !!}
						<select class="form-control" name="is_active">
							<option value="active" <?= ($banner->is_active == 'active')?'selected':'' ; ?> >Active</option>
							<option value="inactive" <?= ($banner->is_active == 'inactive')?'selected':'' ; ?> >Inactive</option>
						</select>
					</div>
                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('banners.index') }}" class="btn btn-default">Cancel</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection