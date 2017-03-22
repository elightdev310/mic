@extends('mic.layouts.auth')

@section('htmlheader_title')
  Send Comfirmation Email
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
        Thanks. We sent a confirmation email to:
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

  @include('mic.layouts.partials.scripts_auth')
</body>

@endsection