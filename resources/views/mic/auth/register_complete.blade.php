@extends('mic.layouts.auth')

@section('htmlheader_title')
  Send Comfirmation Email
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
  <div class="login-box register-complete">

    @include('mic.commons.success_error')

    <div class="login-box-body">
      <p class="login-box-msg">
        Thanks. We sent a confirmation email to:
      </p>
      <p class="login-box-msg text-color-primary">
        <strong>{{ $email }}</strong>
      </p>
      <p class="login-box-msg">
        Click the reset link to get started with MIC
      </p>

    </div><!-- /.login-box-body -->
</body>

@endsection
