@if (session('_action')=='saveGeneralSettingsPatient')
  @include('mic.commons.success_error')
@endif

{!! Form::open(['route' =>'user.save_settings.post', 
                'method'=>'post', 
                'enctype'=>'multipart/form-data', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="saveGeneralSettingsPatient" />

  <div class="form-group">
    @include('mic.commons.user.partials.user_avatar')
  </div>

  <div class="form-group">
    {!! Form::label('first_name', 'First Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('first_name', $patient->first_name, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('last_name', 'Last Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('last_name', $patient->last_name, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('phone', 'Phone :', ['class' => 'control-label col-md-4 col-lg-2']) !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('phone', $patient->phone, ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('date_birth', 'Birthday :', ['class' => 'control-label col-md-4 col-lg-2']) !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('date_birth', MICUILayoutHelper::strTime($patient->date_birth, "Y-m-d"), ['class' => 'form-control date']) !!}
    </div></div>
  </div>

  @include('mic.commons.user.partials.user_address')
  
  <div class="form-group">
    <div class="col-md-12">
      {!! Form::submit('Save General Settings', ['class'=>'btn btn-primary']) !!}
    </div>
  </div>
  
{!! Form::close() !!}

