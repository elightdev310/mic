@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 3
@endsection

@section('content')
<div class="hold-transition apply-page-3 apply-page">
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
        
        <div class="col-xs-4 bs-wizard-step passed"><!-- complete -->
          <div class="text-center bs-wizard-stepnum">Step 2</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <span class="bs-wizard-dot"></span>
          
        </div>
        
        <div class="col-xs-4 bs-wizard-step active"><!-- complete -->
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
  {!! Form::open(['route' => 'apply.step3.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
    <input type="hidden" name="_action" value="apply">

    <div class="form-group has-feedback">
      {!! Form::label('membership_role', 'Membership Role :') !!}
      {!! 
        Form::select('membership_role', 
                      config('mic.partner_type'),
                      old('membership_role'), 
                      ['class' => 'form-control', 'placeholder' => '- Please Select -']) 
      !!}
    </div>

    {{-- <div class="form-group has-feedback">
      {!! Form::label('membership_level', 'Membership Level :') !!}
      {!! 
        Form::select('membership_level', 
                      config('mic.membership_level'),
                      old('membership_level'), 
                      ['class' => 'form-control', 'placeholder' => '- Please Select -']) 
      !!}
    </div> --}}

    <div class="form-group has-feedback">
      {!! Form::label('payment_type', 'Payment Type :') !!}
      {!! 
        Form::select('payment_type', 
                      config('mic.payment_type'),
                      old('payment_type'), 
                      ['class' => 'form-control', 'placeholder' => '- Please Select -']) 
      !!}
    </div>

    <div class="form-group has-feedback">
      
    </div>

    <div class="panel-group app-panel" id="step3" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default payment-info-section">
        <div class="panel-heading" role="tab" id="s3_payment_info_label">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#step3" href="#s3_payment_info" aria-expanded="false" aria-controls="s3_payment_info">
              <label>Payment Information</label>
            </a>
          </h4>
        </div>
        <div id="s3_payment_info" class="panel-collapse collapse" role="tabpanel" aria-labelledby="s3_payment_info_label">
          <div class="panel-body">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Name on Card" name="name_card" value="{{ old('name_card') }}" />
            </div>

            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Credit Card Number" name="cc_number" value="{{ old('cc_number') }}" />
            </div>
            
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Exp" name="exp" value="{{ old('exp') }}" />
            </div> 
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="CID" name="cid" value="{{ old('cid') }}" />
            </div> 

            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Address" name="pi_address" value="{{ old('pi_address') }}" />
            </div> 
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Address 2" name="pi_address2" value="{{ old('pi_address2') }}" />
            </div> 
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="City" name="pi_city" value="{{ old('pi_city') }}" />
            </div> 
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="State" name="pi_state" value="{{ old('pi_state') }}" />
            </div> 
            <div class="form-group has-feedback">
              <input type="text" class="form-control" placeholder="Zip Code" name="pi_zip" value="{{ old('pi_zip') }}" />
            </div> 
          </div>
        </div>
      </div> <!-- /.payment-info-section -->
      
    </div>
    
    <div class="row">
      <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Next</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}
  </div><!-- /.login-box-body -->

  </div><!-- /.login-box -->

  @include('mic.layouts.partials.scripts_auth')

</div>

@endsection
