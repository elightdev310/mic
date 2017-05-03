@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 2
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
<div class="apply-page-2 apply-page">
  <div class="clearfix">
    <div class="pull-right top-auth-section">
      <a href='{{ route('apply.step1') }}' class="btn btn-primary">Go Back</a>
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
        <div class="col-xs-4 bs-wizard-step complete">
          <div class="text-center bs-wizard-stepnum">Step 1</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>
        </div>
        
        <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
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

  {!! Form::open(['route' => 'apply.step2.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
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
      <div class="col-xs-12 text-center">
        <button type="submit" class="btn btn-primary btn-lg">Next</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}

  </div><!-- /.login-box -->

</div>

@endsection
