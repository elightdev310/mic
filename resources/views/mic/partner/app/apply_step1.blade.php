@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 1
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
<div class="apply-page-1 apply-page">

  <div class="clearfix">
    <div class="pull-right top-auth-section">
      <a href='{{ route('login.partner') }}' class="btn btn-primary">Go Back</a>
    </div>
  </div>

  <div class="register-box">

  {{-- <div id="navigation" class="navbar navbar-default">
    <div class="navbar-collapse">

      <ul class="nav navbar-nav">
        <li><a href="{{ url('/login/partner') }}" class="smoothScroll">Login</a></li>
        <li class="active"><a href="#" class="smoothScroll">Apply</a></li>
      </ul>

    </div><!--/.nav-collapse -->
  </div> --}}
  <h2 class="text-color-primary">
    <strong>Apply</strong>
  </h2>  

  <div class="progress-container">
    <div class="row bs-wizard" style="border-bottom:0;">
        <div class="col-xs-4 bs-wizard-step active">
          <div class="text-center bs-wizard-stepnum">Step 1</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>
        </div>
        
        <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
          <div class="text-center bs-wizard-stepnum">Step 2</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>

        </div>
        
        <div class="col-xs-4 bs-wizard-step disabled"><!-- complete -->
          <div class="text-center bs-wizard-stepnum">Step 3</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>
        </div>

    </div>
  </div>

  @include('mic.commons.success_error')

  {!! Form::open(['route' => 'apply.step1.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_action" value="apply">

    <div class="form-group has-feedback">
      {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder'=>'First Name']) !!}
    </div>
    <div class="form-group has-feedback">
      {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder'=>'Last Name']) !!}
    </div>

    <div class="form-group has-feedback">
      {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Email']) !!}
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      {!! Form::password('password', ['class' => 'form-control', 'placeholder' => "Password"]) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder'=>"Re-Type Password"]) !!}
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>

    <div class="">
      <div class="checkbox icheck">
        <label style="margin-left: 0px;">
          <input type="checkbox" name="terms">&nbsp;&nbsp;I understand and agree to the&nbsp;
            <a href="#" data-toggle="modal" data-target=".modal-mic-terms">Terms and Conditions</a>
        </label>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 text-center">
        <button type="submit" class="btn btn-primary btn-lg">Next</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}

  </div><!-- /.login-box -->

  @include('mic.commons.terms_modal')

</div>

@endsection
