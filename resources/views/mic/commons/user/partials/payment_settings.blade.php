@if (session('_action')=='savePaymentSettings')
  @include('mic.commons.success_error')
@endif

{!! Form::open(['route' =>'user.save_settings.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="savePaymentSettings" />

  <div class="form-group">
    {!! Form::label('payment_type', 'Payment Type :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! 
        Form::select('payment_type', 
                      config('mic.payment_type'),
                      $payment_info->payment_type, 
                      ['class' => 'form-control', 'placeholder'=>'Please select payment type']) 
      !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('name_card', 'Name on Card :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('name_card', $payment_info->name_card, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('cc_number', 'Credit Card Number :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('cc_number', NULL, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('exp', 'Exp :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {{-- {!! Form::text('exp', $payment_info->exp, ['class' => 'form-control']) !!} --}}
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
        <div class="form-material col-xs-5 pl0 pr10">
          {!! 
            Form::select('exp_month', 
                          $months,
                          NULL, 
                          ['class' => 'form-control', 'placeholder' => 'Exp month']) 
          !!}
        </div>
        <div class="form-material col-xs-7 p0">
          {!! 
            Form::select('exp_year', 
                          $years,
                          NULL, 
                          ['class' => 'form-control', 'placeholder' => 'Exp year']) 
          !!}
        </div>
      </div>
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('cid', 'CID :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('cid', NULL, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('address', 'Address :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('address', $payment_info->address, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('address2', 'Address 2:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('address2', $payment_info->address2, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('city', 'City:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('city', $payment_info->city, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('state', 'State:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('state', $payment_info->state, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
        {!! Form::label('zip', 'Zip Code:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('zip', $payment_info->zip, ['class'=>'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
      {!! Form::submit('Save Payment Settings', ['class'=>'btn btn-primary']) !!}
    </div>
  </div>

{!! Form::close() !!}
