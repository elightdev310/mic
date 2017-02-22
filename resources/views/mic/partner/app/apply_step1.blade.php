@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 1
@endsection

@section('content')
<div class="hold-transition apply-page-1 apply-page">
  <div class="register-box">

  <div id="navigation" class="navbar navbar-default">
    <div class="navbar-collapse">

      <ul class="nav navbar-nav">
        <li><a href="{{ url('/login/partner') }}" class="smoothScroll">Login</a></li>
        <li class="active"><a href="#" class="smoothScroll">Apply</a></li>
      </ul>

    </div><!--/.nav-collapse -->
  </div>

  <div class="progress-container">
    <div class="row bs-wizard" style="border-bottom:0;">
        
        <div class="col-xs-4 bs-wizard-step active">
          <div class="text-center bs-wizard-stepnum">Step 1</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <span class="bs-wizard-dot first-dot"></span>
          <span class="bs-wizard-dot"></span>
         
        </div>
        
        <div class="col-xs-4 bs-wizard-step "><!-- complete -->
          <div class="text-center bs-wizard-stepnum">Step 2</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <span class="bs-wizard-dot"></span>
          
        </div>
        
        <div class="col-xs-4 bs-wizard-step "><!-- complete -->
          <div class="text-center bs-wizard-stepnum">Step 3</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <span class="bs-wizard-dot"></span>
        </div>
         
    </div>
  </div>

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
  <form action="{{ route('apply.step1.post') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_action" value="apply">

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
        <button type="submit" class="btn btn-primary btn-block btn-flat">Next</button>
      </div><!-- /.col -->
    </div>
  </form>
  </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->

  @include('mic.commons.terms_modal')

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
</div>

@endsection
