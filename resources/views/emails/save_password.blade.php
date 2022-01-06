@extends('emails.index')

@section('content')
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <h2>Rummy Game</h2>
            <h4>Forgot Password</h4>
            <form method="post" action="{{ url('update_password') }}">
                {{ csrf_field() }}

                <input type="hidden" name="forgot_token" value="{{ $forgot_token }}">
                <div class=" form-group">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="c_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary col-lg-12">Save</button>
            </form>
        </div>
    </div>
@endsection