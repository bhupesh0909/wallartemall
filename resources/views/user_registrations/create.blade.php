@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            User Registration
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'userRegistrations.store']) !!}

                        @include('user_registrations.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
