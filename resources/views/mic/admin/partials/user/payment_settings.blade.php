@if (session('_action')=='savePaymentSettings')
  @include('mic.admin.partials.success_error')
@endif

@if (!$user->partner)
<div class="alert alert-warning">
  <strong>You need to set partner profile in Genearl Settings, first.</strong>
</div>
@else

{!! Form::open(['route' => ['micadmin.user.save_settings.post', $user->id], 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="savePaymentSettings" />

  <div class="form-group">
    {!! Form::label('payment_type', 'Payment Type :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! 
        Form::select('payment_type', 
                      config('mic.payment_type'),
                      $partner->payment_type, 
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
      {!! Form::text('cc_number', $payment_info->cc_number, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('exp', 'Exp :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('exp', $payment_info->exp, ['class' => 'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('cid', 'CID :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('cid', $payment_info->cid, ['class' => 'form-control']) !!}
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

@endif
