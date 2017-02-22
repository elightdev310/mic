@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 2
@endsection

@section('content')
<div class="hold-transition apply-page-2 apply-page">
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
        
        <div class="col-xs-4 bs-wizard-step passed">
          <div class="text-center bs-wizard-stepnum">Step 1</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <span class="bs-wizard-dot first-dot"></span>
          <span class="bs-wizard-dot"></span>
         
        </div>
        
        <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
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
  <form action="{{ route('apply.step2.post') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_action" value="apply">

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Company Name" name="company" value="{{ old('company') }}" />
    </div>

    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Phone Number" name="phone" value="{{ old('phone') }}" />
      <span class="glyphicon glyphicon-phone form-control-feedback"></span>
    </div>
    
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Address" name="address" value="{{ old('address') }}" />
    </div> 
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Address 2" name="address2" value="{{ old('address2') }}" />
    </div> 
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="City" name="city" value="{{ old('city') }}" />
    </div> 
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="State" name="state" value="{{ old('state') }}" />
    </div> 
    <div class="form-group has-feedback">
      <input type="text" class="form-control" placeholder="Zip Code" name="zip" value="{{ old('zip') }}" />
    </div> 

    
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Next</button>
      </div><!-- /.col -->
    </div>
  </form>
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
</div>

@endsection
