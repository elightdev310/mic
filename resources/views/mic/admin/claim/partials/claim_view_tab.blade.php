<div class="bg-primary clearfix">
  <div class="row m0">
    <div class="col-md-4">
      <h2>Claim #{{ $claim->id }}</h2>
    </div>
    <div class="col-md-4">
      <div class="mt30">
        created at {{MICUILayoutHelper::strTime($claim->created_at) }}
      </div>
    </div>
  </div>
  <div class="row m0">
  <div class="col-md-4">
    <div class="row">
      <div class="col-md-3">
        <div class="patient-avatar">
          {!! MICUILayoutHelper::avatarImage($claim->patientUser, 80) !!}
        </div>
      </div>
      <div class="col-md-9">
        <h4 class="user-name"><strong>{{ $claim->patientUser->name }}</strong></h4>
        <p class="email">{{ $claim->patientUser->email}}</p>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
  </div>
</div>

<ul class="nav nav-tabs profile" role="tablist">
  <li class=""><a href="{{ url(route('micadmin.claim.list')) }}" data-toggle="tooltip" data-placement="right" title="" data-original-title="Back to My Claims"><i class="fa fa-chevron-left"></i></a></li>
  <li class="@if ($tab =='ioi') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.ioi', [$claim->id]) }}">
      <i class="fa fa-bars"></i> IOI</a></li>
  <li class="@if ($tab =='activity') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.activity', [$claim->id]) }}">
      <i class="fa fa-clock-o"></i> Activity</a></li>
  <li class="@if ($tab =='docs') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.docs', [$claim->id]) }}">
      <i class="fa fa-file-word-o"></i> Docs</a></li>
  <li class="@if ($tab =='photos') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.photos', [$claim->id]) }}">
      <i class="fa fa-file-photo-o"></i> Photos</a></li>
  <li class="@if ($tab =='action') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.action', [$claim->id]) }}">
      <i class="fa fa-cube"></i> Action</a></li>
  <li class="@if ($tab =='partners') active @endif">
    <a class="active" href="{{ route('micadmin.claim.view.partners', [$claim->id]) }}">
      <i class="fa fa-users"></i> Partners</a></li>
</ul>
