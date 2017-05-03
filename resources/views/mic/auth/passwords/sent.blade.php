@extends('mic.layouts.auth')

@section('htmlheader_title')
  Password recovery
@endsection

@section('left_siebar')
  @include('mic.auth.partials.login_sidebar')
@endsection

@section('content')
  <div class="clearfix">
    <div class="pull-right top-auth-section">
      <a href='/login' class="btn btn-primary">Back</a>
    </div>
  </div>

  <div class="login-box">

    @include('mic.commons.success_error')

    <div class="login-box-body">
      <p class="login-box-msg">
        Thanks. We sent a link to reset your password to:
      </p>
      <p class="login-box-msg">
        <strong>{{ $email }}</strong>
      </p>
      <p class="login-box-msg">
        Click the reset link to get started with MIC
      </p>

      <!--<a href="{{ url('/login') }}">Log in</a><br>-->
      <!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

    </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->
@endsection
