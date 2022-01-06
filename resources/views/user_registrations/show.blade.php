@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Registration
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    @include('user_registrations.show_fields')
                    <div class="col-lg-12">
                        <a href="{!! route('userRegistrations.index') !!}" class="btn btn-default">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
