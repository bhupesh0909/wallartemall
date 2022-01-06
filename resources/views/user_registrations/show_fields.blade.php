<div class="col-lg-12">
    <h3>User Details</h3>
</div>
<div class="col-lg-12" style="margin-bottom: 20px;">
    <div class="col-lg-3">
        <h4>Is Block</h4>
        @if($userRegistration->is_block == 1)
            <a href="{{ url('user_action').'/'.$userRegistration->id }}" class="btn btn-success"
               name="is_status">Unblock</a>
        @else
            <a href="{{ url('user_action').'/'.$userRegistration->id }}" class="btn btn-danger"
               name="is_status">Block</a>
        @endif
    </div>
    <div class="col-lg-3">
        <h4>Mobile Verified</h4>
        @if(!empty($userRegistration->mobile_verified_at))
            <div class="btn btn-success" name="mobile_verified">Verified</div>
        @else
            <div class="btn btn-danger" name="mobile_verified">Unverified</div>
        @endif
    </div>
    <div class="col-lg-3">
        <h4>Email Verified</h4>
        @if(!empty($userRegistration->email_verified_at))
            <div class="btn btn-success" name="mobile_verified">Verified</div>
        @else
            <div class="btn btn-danger" name="mobile_verified">Unverified</div>
        @endif
    </div>
    <div class="col-lg-3">
        <h4>KYC Verified</h4>
        @if(!empty($userRegistration->kyc_verification))
            <div class="btn btn-success" name="kyc_verification">Verified</div>
        @else
            <div class="btn btn-danger" name="kyc_verification">Unverified</div>
        @endif
    </div>
</div>
<div class="col-lg-6">
    <table class="table table-active table-responsive-lg table-responsive-sm table-responsive-md table-responsive-xl">
        <tr>
            <td>{!! Form::label('id', 'Player ID:') !!}</td>
            <td><p>{!! $userRegistration->id !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('username', 'Username:') !!}</td>
            <td><p>{!! $userRegistration->username !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('email', 'Email:') !!}</td>
            <td><p>{!! $userRegistration->email !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('dob', 'Dob:') !!}</td>
            <td><p>{!! $userRegistration->dob !!}</p></td>
        </tr>
    </table>
</div>
<div class="col-lg-6">
    <table class="table table-active table-responsive-lg table-responsive-sm table-responsive-md table-responsive-xl">
        <tr>
            <td>{!! Form::label('gender', 'Gender:') !!}</td>
            <td><p>{!! $userRegistration->gender !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('state', 'State:') !!}</td>
            <td><p>{!! $userRegistration->state !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('created_at', 'Created At:') !!}</td>
            <td><p>{!! $userRegistration->created_at !!}</p></td>
        </tr>
        <tr>
            <td>{!! Form::label('updated_at', 'Updated At:') !!}</td>
            <td><p>{!! $userRegistration->updated_at !!}</p></td>
        </tr>
    </table>
</div>
<div class="col-lg-12">
    <h3>Account Details</h3>
</div>
<div class="col-lg-6">
    <table class="table table-active table-responsive-lg table-responsive-sm table-responsive-md table-responsive-xl">
        <tr>
            <td>Total Played Game</td>
            <td><p>{!! $userRegistration->total_played !!}</p></td>
        </tr>
    </table>
</div>
<div class="col-lg-6">
    <table class="table table-active table-responsive-lg table-responsive-sm table-responsive-md table-responsive-xl">
        <tr>
            <td>Total Win Games</td>
            <td><p>{!! $userRegistration->winner !!}</p></td>
        </tr>
    </table>
</div>