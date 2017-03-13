@if (session('_action')=='saveAccountSettings')
  @include('mic.commons.success_error')
@endif

{!! Form::open(['route' =>'user.save_settings.post', 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
  <input type="hidden" name="_action" value="saveAccountSettings" />

  <div class="form-group">
    {!! Form::label('email', 'Email :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::text('email', $user->email, ['class'=>'form-control', 'readonly'=>'readonly']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('old_password', 'Old Password :', ['class'=>'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::password('old_password', ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('password', 'New Password :', ['class'=>'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::password('password', ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    {!! Form::label('password', 'Retype Password :', ['class'=>'control-label col-md-4 col-lg-2']); !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
    </div></div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
      {!! Form::submit('Save Account Settings', ['class'=>'btn btn-primary']) !!}
    </div>
  </div>
{!! Form::close() !!}
