@if (session('_action')=='saveGeneralSettingsPartner')
  @include('mic.commons.success_error')
@endif

{!! Form::open(['route' =>'user.save_settings.post', 
                'method'=>'post', 
                'enctype'=>'multipart/form-data', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="saveGeneralSettingsPartner" />

  <div class="form-group">
    @include('mic.commons.user.partials.user_avatar')
  </div>

  <div class="form-group">
    {!! Form::label('first_name', 'First Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('first_name', $partner->first_name, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('last_name', 'Last Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('last_name', $partner->last_name, ['class'=>'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('company', 'Company :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('company', $partner->company, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('phone', 'Phone :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('phone', $partner->phone, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('address', 'Address :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('address', $partner->address, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('address2', 'Address 2:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('address2', $partner->address2, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('city', 'City:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('city', $partner->city, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('state', 'State:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('state', $partner->state, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
        {!! Form::label('zip', 'Zip Code:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('zip', $partner->zip, ['class'=>'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
      {!! Form::submit('Save General Settings', ['class'=>'btn btn-primary']) !!}
    </div>
  </div>

{!! Form::close() !!}
