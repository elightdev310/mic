@extends('mic.layouts.auth')

@push('styles')
  <link href="{{ asset('assets/css/apply_step_progress.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('htmlheader_title')
  Apply - Step 3
@endsection

@section('left_siebar')
  @include('mic.auth.partials.signup_sidebar')
@endsection

@section('content')
<div class="apply-page-3 apply-page">
  <div class="clearfix">
    <div class="pull-right top-auth-section">
      <a href='{{ route('apply.step2') }}' class="btn btn-primary">Go Back</a>
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
        
        <div class="col-xs-4 bs-wizard-step complete">
          <div class="text-center bs-wizard-stepnum">Step 2</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>

        </div>
        
        <div class="col-xs-4 bs-wizard-step active">
          <div class="text-center bs-wizard-stepnum">Step 3</div>
          <div class="progress"><div class="progress-bar"></div></div>
          <a href="#" class="bs-wizard-dot"></a>
        </div>

    </div>
  </div>

  @include('mic.commons.success_error')

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
              {{-- <input type="text" class="form-control" placeholder="Exp" name="exp" value="{{ old('exp') }}" /> --}}

              {{--*/ 
                $months= [];
                $years = [];
                $_year=date('Y');
                for ($index = 1; $index<=12; $index++) {
                  $_month = ($index<10)? '0'.$index : $index;
                  $months[$_month] = $_month;
                }
                $index = 0;
                while($index<5) { $years[$_year] = $_year; $index++; $_year++; } 
               /*--}}
              <div class="row m0">
                <div class="col-xs-5 pl0 pr10">
                  {!! 
                    Form::select('exp_month', 
                                  $months,
                                  NULL, 
                                  ['class' => 'form-control', 'placeholder'=>'Exp Month']) 
                  !!}
                </div>
                <div class="col-xs-7 p0">
                  {!! 
                    Form::select('exp_year', 
                                  $years,
                                  NULL, 
                                  ['class' => 'form-control', 'placeholder'=>'Exp Year']) 
                  !!}
                </div>
              </div>

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
        <button type="submit" class="btn btn-primary btn-lg">Next</button>
      </div><!-- /.col -->
    </div>
  {!! Form::close() !!}

  </div><!-- /.login-box -->

  @include('mic.layouts.partials.scripts_auth')

</div>

@endsection
