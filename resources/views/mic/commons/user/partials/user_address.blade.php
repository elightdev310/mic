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
