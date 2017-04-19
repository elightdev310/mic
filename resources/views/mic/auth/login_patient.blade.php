@extends('mic.layouts.auth')

@section('htmlheader_title')
  Login as Patient
@endsection

@section('content')
<body class="hold-transition login-page">
  <div class="login-box">

  <div id="navigation" class="navbar navbar-default">
    <div class="navbar-collapse">

      <ul class="nav navbar-nav">
        <li class="active"><a href="#home" class="smoothScroll">Login</a></li>
        <li><a href="{{ url('/register/patient') }}" class="smoothScroll">Register</a></li>
      </ul>

    </div><!--/.nav-collapse -->
  </div>
  
  @include('mic.commons.success_error')

  <div class="login-box-body">
  <p class="login-box-msg">Sign in to start your session</p>
  <form action="{{ url('/login') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-group has-feedback">
      <input type="email" class="form-control" placeholder="Email" name="email"/>
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="Password" name="password"/>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-8">
        <div class="checkbox icheck">
          <label>
            <input type="checkbox" name="remember"> Remember Me
          </label>
        </div>
      </div><!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
      </div><!-- /.col -->
    </div>
  </form>

  @include('auth.partials.social_login')

  <a href="{{ url('/password/reset') }}">I forgot my password</a><br>
  <!--<a href="{{ url('/register') }}" class="text-center">Register a new membership</a>-->

</div><!-- /.login-box-body -->

</div><!-- /.login-box -->

  @include('mic.layouts.partials.scripts_auth')

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
