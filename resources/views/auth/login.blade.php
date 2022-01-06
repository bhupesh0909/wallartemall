@extends('layouts.loginapp')

@section('content')
<div class="d-flex flex-column flex-root">
      <!--begin::Authentication - Sign-in -->
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Aside-->
        <div class="d-flex flex-column flex-lg-row-auto w-xl-700px positon-xl-relative" style="background-image: url(assets/images/art.jpg)" >
          <!--begin::Wrapper-->
          <div class="d-flex flex-column position-xl-fixed top-0 bottom-0 w-xl-700px scroll-y">
            <!--begin::Content-->
            <div class="d-flex flex-row-fluid flex-column text-center p-10 pt-lg-20">
              <!--begin::Logo-->
                   
              <!--end::Logo-->
              <!--begin::Title-->
              <h1 class="fw-bolder fs-2qx pb-5 pb-md-10" style="color: #000000;">Welcome to Wallartemall</h1>
              <!--end::Title-->
              <!--begin::Description-->
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <p class="fw-bold fs-2" style="color: #000000;">Discover Amazing Metronic 
              <br />with great build tools</p>
              <!--end::Description-->
            </div>
            <!--end::Content-->
            <!--begin::Illustration-->
            <div class="d-flex flex-row-auto bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-position-y-bottom min-h-100px min-h-lg-350px" ></div>
            <!--end::Illustration-->
          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Aside-->
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid py-10">
          <!--begin::Content-->
          <div class="d-flex flex-center flex-column flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="w-lg-500px p-10 p-lg-15" style="padding-top: 0px !important;">

              <a href="#" class="py-9 mb-5" style="margin-left: 18%;">
                <img alt="Logo" src="assets/images/logo.png" class="h-250px" />
              </a> 
              <!--begin::Form-->
              <form class="form w-100" novalidate="novalidate"  method="POST" id="kt_sign_in_form" action="{{ route('login') }}">

              {{ csrf_field() }}
               
                <!--begin::Heading-->
                <div class="text-center mb-10">
                  <!--begin::Title-->
                  <h1 class="text-dark mb-3">Sign In to Wallartemall</h1>
                  <!--end::Title-->
                  <!--begin::Link-->
                 
                  <!--end::Link-->
                </div>
                <!--begin::Heading-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                  <!--begin::Label-->
                  <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                  <!--end::Label-->
                  <!--begin::Input-->
                  <input class="form-control form-control-lg form-control-solid" type="text" id="email"  name="email" autocomplete="off" /><br/>
                   @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif

                  @if(Session::has('message'))
                      <span class="error">
                        {{ Session::get('message') }}
                      </span>
                  @endif
                  <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="fv-row mb-10">
                  <!--begin::Wrapper-->
                  <div class="d-flex flex-stack mb-2">
                    <!--begin::Label-->
                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                    <!--end::Label-->
                    <!--begin::Link-->
                    <a href="/metronic8/demo2/../demo2/authentication/layouts/aside/password-reset.html" class="link-primary fs-6 fw-bolder">Forgot Password ?</a>
                    <!--end::Link-->
                  </div>
                  <!--end::Wrapper-->
                  <!--begin::Input-->
                  <input class="form-control form-control-lg form-control-solid" type="password"  id="password" name="password" autocomplete="off" />
                   @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                  <!--end::Input-->
                </div>
                <!--end::Input group-->
                <!--begin::Actions-->
                <div class="text-center">
                  <!--begin::Submit button-->
                  <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                    <span class="indicator-label">Continue</span>
                    <span class="indicator-progress">Please wait... 
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                  </button>
                  <!--end::Submit button-->
                  <!--begin::Separator-->
            
                  <!--end::Separator-->
                  <!--begin::Google link-->
                 
                  <!--end::Google link-->
                  <!--begin::Google link-->
                 
                  <!--end::Google link-->
                </div>
                <!--end::Actions-->
              </form>
              <!--end::Form-->
            </div>
            <!--end::Wrapper-->
          </div>
          <!--end::Content-->
          <!--begin::Footer-->
          
          <!--end::Footer-->
        </div>
        <!--end::Body-->
      </div>
      <!--end::Authentication - Sign-in-->
    </div>

@endsection