@if (session('_action')=='saveMembershipSettings')
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
  <input type="hidden" name="_action" value="saveMembershipSettings" />

  <div class="form-group">
    {!! Form::label('membership_role', 'Membership Role :', ['class' => 'control-label col-md-4 col-lg-2']) !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! 
        Form::select('membership_role', 
                      config('mic.partner_type'),
                      $partner->membership_role, 
                      ['class' => 'form-control', 'placeholder' => 'Please select membership role']) 
      !!}
    </div></div>
  </div>
  <div class="form-group">
    {!! Form::label('membership_level', 'Membership Level :', ['class' => 'control-label col-md-4 col-lg-2']) !!}
    <div class="col-md-8 col-lg-4"><div class="form-material">
      {!! 
        Form::select('membership_level', 
                      config('mic.membership_level'),
                      $partner->membership_level, 
                      ['class' => 'form-control', 'placeholder' => 'Please select membership level']) 
      !!}
    </div></div>
  </div>

  <div class="form-group">
    <div class="col-md-12">
      <input class="btn btn-primary" type="submit" value="Save Membership Settings" />
    </div>
  </div>

{!! Form::close() !!}
@endif
