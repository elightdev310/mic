@extends('mic.layouts.admin')

@section('htmlheader_title') User Settings @endsection
@section('contentheader_title')@endsection

@section('main-content')
<!-- Main content -->
<section class="content no-padding">
  <div id="page-content" class="profile2">
    <div class="bg-primary clearfix">
      <div class="col-md-4">
        <div class="row">
          <div class="col-md-3">
            <div class="profile-icon text-primary">
              {!! MICUILayoutHelper::avatarImage($user, 70) !!}
            </div>
          </div>
          <div class="col-md-9">
            <h4 class="name">
              {{ $user->name }}
            </h4>
            <p class="email">{{ $user->email }}</p>
            <p class="status">{{ ucfirst($user->status) }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dats1">
          {{ ucfirst(config('mic.user_type.'.$user->type)) }}
          @if ($user->type == 'partner')
          - {{ ucwords(MICUILayoutHelper::getPartnerTypeTitle($user->id, '')) }}
          @endif
        </div>
        <div class="dats1">
          Member from: {{ MICUILayoutHelper::strTime($user->created_at) }}
        </div>
      </div>

      <div class="col-md-4">
        <div class="dats1">
          &nbsp;
        </div>
        <div class="dats1 text-right">
          @if ($user->status != 'cancel')
          {!! Form::open(['route' => ['micadmin.user.delete_user.post', $user->id], 
                'method'=>'post', 
                'class' =>'frm-delete-user']) !!}
            <a href="#" class="btn btn-sm btn-warning delete-user-action" data-url="">Cancel User</a>
          {!! Form::close() !!}
          @endif
        </div>
      </div>

    </div>

    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
      <li class=""><a href="{{ url(route('micadmin.users.list')) }}" data-toggle="tooltip" data-placement="right" title="" data-original-title="Back to Users"><i class="fa fa-chevron-left"></i></a></li>
      <li class="@if (!session('_action') || strpos(session('_action'), 'saveGeneralSettings')===0) active @endif">
        <a role="tab" data-toggle="tab" class="@if (!session('_action') || strpos(session('_action'), 'saveGeneralSettings')===0) active @endif" 
            href="#tab-general-info" data-target="#tab-info" aria-expanded="true">
          <i class="fa fa-bars"></i> General Settings
        </a>
      </li>
      @if (isset($partner))
      <li class="@if (session('_action')=='saveMembershipSettings') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='saveMembershipSettings') active @endif" 
            href="#tab-membership" data-target="#tab-membership" aria-expanded="false">
          <i class="fa fa-diamond"></i> Membership Settings
        </a>
      </li>
      @endif

      {{-- @if (isset($payment_info))
      <li class="@if (session('_action')=='savePaymentSettings') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='savePaymentSettings') active @endif" 
            href="#tab-payment" data-target="#tab-payment" aria-expanded="false">
          <i class="fa fa-credit-card"></i> Payment Settings
        </a>
      </li>
      @endif --}}

      <li class="@if (session('_action')=='saveAccountSettings') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='saveAccountSettings') active @endif" 
            href="#tab-account" data-target="#tab-account" aria-expanded="false">
          <i class="fa fa-users"></i> Account Settings
        </a>
      </li>

      @if (isset($user_videos) || isset($group_videos))
      <li class="@if (session('_action')=='saveLearningCenter') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='saveLearningCenter') active @endif" 
            href="#tab-learning-center" data-target="#tab-learning-center" aria-expanded="false">
          <i class="fa fa-file-video-o"></i> Learning Center
        </a>
      </li>
      @endif
      
    </ul>

    <div class="tab-content">
      <!-- General Settings -->
      <div role="tabpanel" class="tab-pane fade @if (!session('_action') || strpos(session('_action'), 'saveGeneralSettings')===0) active in @endif" id="tab-info">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>General Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.user.general_settings_'.$user->type)
            </div>
          </div>
        </div>
      </div>

      @if (isset($partner))
      <!-- Membership Settings -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='saveMembershipSettings') active in @endif" id="tab-membership">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Membership Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.user.membership_settings')
            </div>
          </div>
        </div>
      </div>
      @endif

      {{-- @if (isset($payment_info))
      <!-- Payment Settings -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='savePaymentSettings') active in @endif" id="tab-payment">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Payment Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.user.payment_settings')
            </div>
          </div>
        </div>
      </div>
      @endif --}}

      <!-- Account Settings -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='saveAccountSettings') active in @endif" id="tab-account">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Account Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.user.account_settings')
            </div>
          </div>
        </div>
      </div>

      @if (isset($user_videos) || isset($group_videos))
      <!-- Learning Center -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='saveLearningCenter') active in @endif" id="tab-learning-center">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Learning Center</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.user.learning_center')
            </div>
          </div>
        </div>
      </div>
      @endif

    </div>
  </div>
</section><!-- /.content -->
@endsection

@section('scripts')
@parent
<script type="text/javascript">
  $(function () {
      $('.date').datetimepicker({
        format: 'YYYY-MM-DD'
      });
      $('a.delete-user-action').click(function() {
        var $_this = $(this);
        bootbox.confirm({
          message: "<p>Are you sure to cancel this user?</p>", 
          callback: function (result) {
            if (result) {
              $_this.closest('form').submit();
            }
          }
        });
      });
  });
</script>
@endsection
