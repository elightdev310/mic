@extends('mic.layouts.auth')

@section('htmlheader_title')
  Send Application
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
        Thanks. Your application has been submitted. MIC will review your application within 48hrs. A response to your application will be sent to: 
      </p>
      <p class="login-box-msg">
        <strong>{{ $email }}</strong>
      </p>
      
    </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->

  @include('mic.layouts.partials.scripts_auth')
</body>

@endsection
