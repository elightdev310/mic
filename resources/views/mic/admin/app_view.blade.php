@extends('mic.layouts.admin')

@section('htmlheader_title') Application #{{ $app->id }} @endsection
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
            @if ($app->status == 'pending')
              <i class="fa fa-file-pdf-o"></i>
            @elseif ($app->status == 'approved')
              <i class="fa fa-file-archive-o"></i>
            @else
              <i class="fa fa-file-code-o"></i>
            @endif
            </div>
          </div>
          <div class="col-md-9">
            <h4 class="name">Application (#{{$app->id}})
              <span>[{{ ucfirst($app->status) }}]</span>
            </h4>
            <p class="user-name">{{ $app->first_name.' '.$app->last_name }}</p>
            <p class="email">{{ $app->email }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        @if ($app->user)
        <div class="dats1">
          <a href="{{ route('micadmin.user.settings', [$app->user_id]) }}" class="color-inherited">
          <i class="fa fa-user"></i>
          {{ $app->user->name.' (#'.$app->user_id.')' }}
          </a>
        </div>
        @else
          <div class="dats1">&nbsp;</div>
        @endif
        <div class="dats1">
          submitted {{ MICUILayoutHelper::strTime($app->created_at) }}
           ({{ MICUILayoutHelper::agoTime($app->created_at) }} ago)
        </div>
        @if ($app->status != 'pending')
        <div class="dats1">
          {{ $app->status }}&nbsp;
          {{ MICUILayoutHelper::strTime($app->updated_at) }}
        </div>
        @endif
      </div>
      <div class="col-md-4">
        <div class="dats1">&nbsp;</div>
        @if ($app->status == 'pending')
        <div class="dats1">
          <a class="btn btn-success btn-sm" href="#" data-url="{{ route('micadmin.app.approve', [$app->id]) }}" id="approve-app-link">
            <i class="fa fa-user"></i>
            Approve Application
          </a>
        </div>
        @endif
      </div>
    </div>

    <ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
      <li class=""><a href="{{ url(route('micadmin.apps.list', [$app->status])) }}" data-toggle="tooltip" data-placement="right" title="" data-original-title="Back to Applications"><i class="fa fa-chevron-left"></i></a></li>
      <li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info" aria-expanded="true"><i class="fa fa-bars"></i> General Info</a></li>
      <li class=""><a role="tab" data-toggle="tab" href="#tab-membership" data-target="#tab-membership" aria-expanded="false"><i class="fa fa-diamond"></i> Membership Info</a></li>
      <li class=""><a role="tab" data-toggle="tab" href="#tab-payment" data-target="#tab-payment" aria-expanded="false"><i class="fa fa-credit-card"></i> Payment Info</a></li>
    </ul>

    <div class="tab-content">
      <!-- General Info -->
      <div role="tabpanel" class="tab-pane fade active in" id="tab-info">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>General Info</h4>
            </div>
            <div class="panel-body">
              @include('mic.admin.partials.success_error')
              <div class="form-group">
                <label for="first_name" class="col-md-2">First Name :</label>
                <div class="col-md-10 fvalue">{{ $app->first_name }}</div>
              </div>
              <div class="form-group">
                <label for="last_name" class="col-md-2">Last Name :</label>
                <div class="col-md-10 fvalue">{{ $app->last_name }}</div>
              </div>
              <div class="form-group">
                <label for="email" class="col-md-2">Email :</label>
                <div class="col-md-10 fvalue">{{ $app->email }}</div>
              </div>
              <div class="form-group">
                <label for="pwd" class="col-md-2">Password :</label>
                <div class="col-md-10 fvalue">{{ $app->pwd }}</div>
              </div>

              <div class="form-group">
                <label for="company" class="col-md-2">Company :</label>
                <div class="col-md-10 fvalue">{{ $partner->company }}</div>
              </div>
              <div class="form-group">
                <label for="phone" class="col-md-2">Phone :</label>
                <div class="col-md-10 fvalue">{{ $partner->phone }}</div>
              </div>
              <div class="form-group">
                <label for="address" class="col-md-2">Address :</label>
                <div class="col-md-10 fvalue">{{ $partner->address }}</div>
              </div>
              <div class="form-group">
                <label for="address2" class="col-md-2">Address 2 :</label>
                <div class="col-md-10 fvalue">{{ $partner->address2 }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">City :</label>
                <div class="col-md-10 fvalue">{{ $partner->city }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">State :</label>
                <div class="col-md-10 fvalue">{{ $partner->state }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">Zip Code :</label>
                <div class="col-md-10 fvalue">{{ $partner->zip }}</div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Membership Info -->
      <div role="tabpanel" class="tab-pane fade" id="tab-membership">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Membership Info</h4>
            </div>
            <div class="panel-body">

              <div class="form-group">
                <label for="membership_role" class="col-md-2">Membership Role :</label>
                <div class="col-md-10 fvalue">{{ MICHelper::getPartnerTypeTitle($partner) }}</div>
              </div>
              <div class="form-group">
                <label for="membership_level" class="col-md-2">Membership Level :</label>
                <div class="col-md-10 fvalue">{{ config('mic.membership_level.'.$partner->membership_level) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Info -->
      <div role="tabpanel" class="tab-pane fade" id="tab-payment">
        <div class="tab-content">
          <div class="panel infolist">
            <div class="panel-default panel-heading">
              <h4>Payment Info</h4>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="payment_type" class="col-md-2">Payment Type :</label>
                <div class="col-md-10 fvalue">{{ config('mic.payment_type.'.$partner->payment_type) }}</div>
              </div>

              <div class="form-group">
                <label for="payment_type" class="col-md-2">Name on Card:</label>
                <div class="col-md-10 fvalue">{{ $payment_info->name_card }}</div>
              </div>
              <div class="form-group">
                <label for="payment_type" class="col-md-2">Credit Card Number:</label>
                <div class="col-md-10 fvalue">{{ $payment_info->cc_number }}</div>
              </div>
              <div class="form-group">
                <label for="payment_type" class="col-md-2">Exp:</label>
                <div class="col-md-10 fvalue">{{ $payment_info->exp }}</div>
              </div>
              <div class="form-group">
                <label for="payment_type" class="col-md-2">CID:</label>
                <div class="col-md-10 fvalue">{{ $payment_info->cid }}</div>
              </div>
              <div class="form-group">
                <label for="address" class="col-md-2">Address :</label>
                <div class="col-md-10 fvalue">{{ $payment_info->address }}</div>
              </div>
              <div class="form-group">
                <label for="address2" class="col-md-2">Address 2 :</label>
                <div class="col-md-10 fvalue">{{ $payment_info->address2 }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">City :</label>
                <div class="col-md-10 fvalue">{{ $payment_info->city }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">State :</label>
                <div class="col-md-10 fvalue">{{ $payment_info->state }}</div>
              </div>
              <div class="form-group">
                <label for="city" class="col-md-2">Zip Code :</label>
                <div class="col-md-10 fvalue">{{ $payment_info->zip }}</div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /.content -->
@endsection

@push('scripts')
<script>
(function ($) {
$(document).ready(function() {
  $('a#approve-app-link').click(function() {
    var approve_url = $(this).data('url');
    bootbox.confirm({
      message: "<p>Did you review application?</p>" + 
               "<p>If so, it would create partner user using this application.",
      callback: function (result) {
        if (result) {
          window.location.href = approve_url;
        }
      }
    });
  });
});
}(jQuery));
</script>
@endpush
