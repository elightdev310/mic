@extends('mic.layouts.auth')

@section('htmlheader_title')
  Sign Up
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
<div class="clearfix">
  <div class="pull-right top-auth-section">
    <a href='/login' class="btn btn-primary">Back</a>
  </div>
</div>

<div class="login-box">
<div class="row pt30">
  <div class="col-xs-6 text-center">
    <h3><strong>Patient</strong></h3>
    <div class="pt30">
      <a href="{{ route('register.patient') }}" class="btn btn-primary">Register</a>
    </div>
  </div>
  <div class="col-xs-6 text-center">
    <h3><strong>Partner</strong></h3>
      <div class="pt30">
        <a href="{{ route('apply.step1') }}" class="btn btn-primary">Submit Application</a>
      </div>
  </div>
</div>
</div>
@endsection
