@extends('mic.layouts.auth')

@section('htmlheader_title')
  Send Application
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
  <div class="login-box register-complete">

    @include('mic.commons.success_error')

    <div class="login-box-body">
      <p class="login-box-msg">
        Thanks. Your application has been submitted. MIC will review your application within 48hrs. A response to your application will be sent to: 
      </p>
      <p class="login-box-msg text-color-primary">
        <strong>{{ $email }}</strong>
      </p>
      
    </div><!-- /.login-box-body -->

</body>

@endsection
