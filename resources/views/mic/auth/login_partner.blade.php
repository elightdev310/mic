@extends('mic.layouts.auth')

@section('htmlheader_title')
  Login as Partner
@endsection

{{--*/ $sign_up_url = route('apply.step1') /*--}}

@section('left_siebar')
  @include('mic.auth.partials.login_sidebar')
@endsection

@section('content')
<div class="clearfix">
  <div class="pull-right top-auth-section">
    <span>Don't have an account?</span>&nbsp;
    <a href='{{ $sign_up_url }}' class="btn btn-primary">Sign Up</a>
  </div>
</div>

<div class="login-box">
  <div class="login-box-body">

    <h2 class="text-color-primary">
      <strong>Sign in to MIC</strong>
    </h2>  
    <div class="description">Enter your details below.</div>
    
    @include('mic.commons.success_error')

    <form id="login-form" action="{{ url('/login') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
            <label class="control-label">EMAIL ADDRESS</label>
            <input type="email" class="form-control" placeholder="Enter Email Address" name="email"/>
            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
        </div>
        <div class="form-group has-feedback">
            <label class="control-label">PASSWORD</label>
            <a href="{{ url('/password/reset') }}" class="pull-right">Forgot password?</a>
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
        </div>
        <div class="form-group">
          <div class="checkbox icheck">
              <label style="margin-left: 0px;">
                  <input type="checkbox" name="remember"> Remember Me
              </label>
          </div>
        </div>

        <div class="text-center p20">
          <button type="submit" class="btn btn-primary btn-lg">Sign In</button>
        </div>
    </form>

    @include('auth.partials.social_login')

    <br>
    <!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->

@endsection
