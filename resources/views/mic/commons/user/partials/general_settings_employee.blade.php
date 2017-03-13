@if (session('_action')=='saveGeneralSettingsEmployee')
  @include('mic.commons.success_error')
@endif

{!! Form::open(['route' =>'user.save_settings.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="saveGeneralSettingsEmployee" />

  <div class="form-group">
    {!! Form::label('name', 'Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('name', $employee->name, ['class'=>'form-control']) !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('gender', 'Gender :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! 
        Form::select('gender', 
                      [ 'male' => 'Male', 
                        'female' => 'Female'],
                      $employee->gender, 
                      ['class' => 'form-control']) 
      !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('mobile', 'Mobile :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('mobile', $employee->mobile, ['class'=>'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
      {!! Form::submit('Save General Settings', ['class'=>'btn btn-primary']) !!}
    </div>
  </div>
  
{!! Form::close() !!}
