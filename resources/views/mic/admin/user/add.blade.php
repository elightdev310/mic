@extends('mic.layouts.admin')

@section('htmlheader_title') Add User @endsection
@section('contentheader_title') Add User @endsection

@section('main-content')
<!-- Main content -->
  
  <div class="users-box box box-primary panel infolist">
    {!! Form::open(['route' => ['micadmin.user.add.post'], 
                'method'=>'post', 
                'class' =>'materials-form']) !!}
    <div class="box-header">
      
    </div><!-- /.box-header -->
    <div class="box-body">

      <div class="form-group">
        {!! Form::label('user_type', 'User Type :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! 
            Form::select('user_type', 
                          [ strtolower(config('mic.user_type.patient')) => ucfirst(config('mic.user_type.patient')), 
                            strtolower(config('mic.user_type.partner')) => ucfirst(config('mic.user_type.partner')) ],
                          NULL, 
                          ['class' => 'form-control']); 
          !!}
        </div></div>
      </div>

      <div class="form-group partner-type">
        {!! Form::label('membership_role', 'Membership Role :', ['class' => 'control-label col-md-4 col-lg-2']) !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! 
            Form::select('membership_role', 
                          config('mic.partner_type'),
                          NULL, 
                          ['class' => 'form-control', 'placeholder' => 'Please select membership role']) 
          !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('first_name', 'First Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('first_name', NULL, ['class' => 'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('last_name', 'Last Name :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('last_name', NULL, ['class' => 'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('email', 'Email :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('email', NULL, ['class'=>'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('password', 'Password :', ['class'=>'control-label col-md-4 col-lg-2']); !!}
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
        {!! Form::label('status', 'Status :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! 
            Form::select('status', 
                          [ config('mic.user_status.active') => ucfirst(config('mic.user_status.active')), 
                            config('mic.user_status.pending') => ucfirst(config('mic.user_status.pending')), 
                            config('mic.user_status.cancel') => ucfirst(config('mic.user_status.cancel')) ],
                          NULL, 
                          ['class' => 'form-control']); 
          !!}
        </div></div>
      </div>

      <div class="form-group">
        <div class="col-md-12 pt30 pb30">
          {!! Form::submit('Add new user', ['class'=>'btn btn-primary']) !!}
          <p class="pt20">Please fill additional information after adding new user.</p>
        </div>
      </div>

    </div>
    {!! Form::close() !!}
  </div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
  $(function () {
      $('#user_type').on('change', function() {
        if ($(this).val() == 'partner') {
          $('.partner-type.form-group').removeClass('hidden');
        } else {
          $('.partner-type.form-group').addClass('hidden');
        }
      }).trigger('change');
  });
</script>
@endsection
