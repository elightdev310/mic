@extends('mic.layouts.auth')

@section('htmlheader_title')
  Password recovery
@endsection

@section('content')

<body class="login-page">
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
