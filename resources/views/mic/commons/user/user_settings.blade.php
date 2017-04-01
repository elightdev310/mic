@extends('mic.layouts.'.$layout)

@section('htmlheader_title') User Settings @endsection
@section('contentheader_title')@endsection

@section('content')
<!-- Main content -->

  <div id="page-content" class="profile2">
    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
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
      
      @if (isset($payment_info))
      <li class="@if (session('_action')=='savePaymentSettings') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='savePaymentSettings') active @endif" 
            href="#tab-payment" data-target="#tab-payment" aria-expanded="false">
          <i class="fa fa-credit-card"></i> Payment Settings
        </a>
      </li>
      @endif

      <li class="@if (session('_action')=='saveAccountSettings') active @endif">
        <a role="tab" data-toggle="tab" class="@if (session('_action')=='saveAccountSettings') active @endif" 
            href="#tab-account" data-target="#tab-account" aria-expanded="false">
          <i class="fa fa-users"></i> Account Settings
        </a>
      </li>
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
              @include('mic.commons.user.partials.general_settings_'.$user->type)
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
              @include('mic.commons.user.partials.membership_settings')
            </div>
          </div>
        </div>
      </div>
      @endif

      @if (isset($payment_info))
      <!-- Payment Settings -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='savePaymentSettings') active in @endif" id="tab-payment">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Payment Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.commons.user.partials.payment_settings')
            </div>
          </div>
        </div>
      </div>
      @endif

      <!-- Account Settings -->
      <div role="tabpanel" class="tab-pane fade @if (session('_action')=='saveAccountSettings') active in @endif" id="tab-account">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Account Settings</h4>
            </div>
            <div class="panel-body">
              @include('mic.commons.user.partials.account_settings')
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
<script type="text/javascript">
  $(function () {
      $('.date').datetimepicker({
        format: 'YYYY-MM-DD'
      });
  });
</script>
@endpush
