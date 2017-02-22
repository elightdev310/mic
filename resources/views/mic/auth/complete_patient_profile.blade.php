@extends('mic.layouts.auth')

@section('htmlheader_title')
  Complete Profile
@endsection

@section('content')
<body class="hold-transition login-page">
  <div class="register-box">

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

  <div class="register-box-body">
  <p class="login-box-msg">{{ $user->patient->first_name }}, we're almost done. Please complete your profile below</p>
  <form action="{{ route('register.complete_profile.post') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" />
      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="text" class="form-control date" placeholder="Date of birth" name="date_birth" value="{{ old('date_birth') }}" />
      <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
    </div>
      
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">GET STARTED</button>
      </div><!-- /.col -->
    </div>
  </form>
  </div><!-- /.register-box-body -->

  </div><!-- /.register-box -->

  @include('mic.layouts.partials.scripts_auth')

  <script type="text/javascript">
    $(function () {
        $('.date').datetimepicker({
          format: 'YYYY-MM-DD'
        });
    });
  </script>
</body>

@endsection
