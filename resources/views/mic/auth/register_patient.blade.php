@extends('mic.layouts.auth')

@section('htmlheader_title')
  Register as Patient
@endsection

@section('content')
<body class="hold-transition login-page">
  <div class="register-box">

  <div id="navigation" class="navbar navbar-default">
    <div class="navbar-collapse">

      <ul class="nav navbar-nav">
        <li ><a href="{{ url('/login/patient') }}" class="smoothScroll">Login</a></li>
        <li class="active"><a href="#" class="smoothScroll">Register</a></li>
      </ul>

    </div><!--/.nav-collapse -->
  </div>
  
  @include('mic.commons.success_error')

  <div class="register-box-body">
  <form action="{{ route('register.patient') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_action" value="register">

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" />
    </div>
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" />
    </div>

    <div class="form-group has-feedback">
      <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" />
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="Password" name="password"/>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" placeholder="Re-Type Password" name="password_confirmation"/>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="row">
      <div class="checkbox icheck">
        <label>
          <input type="checkbox" name="terms">&nbsp;&nbsp;I understand and agree to the&nbsp;
            <a href="#" data-toggle="modal" data-target=".modal-mic-terms">Terms and Conditions</a>
        </label>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
      </div><!-- /.col -->
    </div>
  </form>
  </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->

  @include('mic.commons.terms_modal')

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
