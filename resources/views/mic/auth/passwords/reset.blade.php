@extends('mic.layouts.auth')

@section('htmlheader_title')
  Password reset
@endsection

@section('content')

  <body class="login-page">
  <div class="login-box">
    @include('mic.commons.success_error')

    <div class="login-box-body">
      <p class="login-box-msg">Reset Password</p>
      <form action="{{ url('/password/reset') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password"/>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Password" name="password_confirmation"/>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-2">
          </div><!-- /.col -->
          <div class="col-xs-8">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset password</button>
          </div><!-- /.col -->
          <div class="col-xs-2">
          </div><!-- /.col -->
        </div>
      </form>

      <a href="{{ url('/login') }}">Log in</a><br>
      <!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

    </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->

  @include('la.layouts.partials.scripts_auth')

  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
  </body>

@endsection
