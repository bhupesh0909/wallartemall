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
            $('#game_type').validate({
                rules: {                
                    game_icon: {
                        required: true,
                        extension: "jpeg,png,jpg,gif,svg",
                        filesize: 1000000,
                    },
                    game_type:{
                        required: true
                    }
                },
                messages: {
                game_icon:{
                    filesize:" file size must be less than 1Mb.",
                    extension:"Please upload .jpg or .png or .gif file only.",
                    required:"Please upload file."
                }
            },
            });
        });
    </script>


    <section class="content-header">
        <h1>Game Types</h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'gameTypes.store','enctype'=>'multipart/form-data','id'=>'game_type']) !!}

                    @include('game_types.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
