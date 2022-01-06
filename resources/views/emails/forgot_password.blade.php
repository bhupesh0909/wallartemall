@extends('emails.index')

@section('content')
    <p>Hi,</p>
    <p>Please click here for forgot password,</p>
    <a href="{{ url('set_password/'.$forgot_token) }}" class="btn btn-info">Click Here</a>

    <p>Thanks & Regards</p>
    <p>Rummy Boss</p>
@endsection
