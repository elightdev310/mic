@extends('mic.layouts.auth')

@section('htmlheader_title')
  Password recovery
@endsection

@section('content')

<body class="login-page">
  <div class="login-box">

    @if (session('status'))
      <div class="alert alert-success">
        {{ session('status') }}
      </div>
    @endif

    @if (count($errors) > 0)
      <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="login-box-body">
      <p class="login-box-msg">
        Forgot your password? No Problem. Enter your email address below and we will send you a link to reset it
      </p>
      <form action="{{ url('/password/email') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}"/>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-2">
          </div><!-- /.col -->
          <div class="col-xs-8">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset My Password</button>
          </div><!-- /.col -->
          <div class="col-xs-2">
          </div><!-- /.col -->
        </div>
      </form>

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
