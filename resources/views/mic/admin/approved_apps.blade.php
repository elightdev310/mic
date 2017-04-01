@extends('mic.layouts.admin')

@section('htmlheader_title') Approved Applications @endsection
@section('contentheader_title') Approved Applications @endsection

@section('main-content')
<!-- Main content -->
  <div class="row">
    <section class="col-md-12">

      <div class="approved-applications application-box box box-primary">
        <div class="box-header">
          {{ $apps->links() }}
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="app-name">Full Name</th>
            <th class="app-email">Email</th>            
            <th class="app-company">Company</th>
            <th class="app-role">Membership Role</th>
            <th class="app-submit-date">Submit Time</th>
            <th class="app-user">User Account</th>

            <th class="action">Action</th>
          </thead>
          <tbody>
            @foreach ($apps as $app)
            <tr data-app-id="{{ $app->id }}">
              <td class="app-name">
                <a href="{{ url(route('micadmin.app.view', [$app->id])) }}" class="">
                  {{ $app->first_name.' '.$app->last_name }}
                </a>
              </td>
              <td class="app-email">{{ $app->email }}</td>
              <td class="app-company">{{$app->partner->company}}</td>
              <td class="app-role">{{ MICHelper::getPartnerTypeTitle($app->partner) }}</td>
              <td class="app-submit-date">{{ MICUILayoutHelper::strTime($app->created_at) }}</td>
              <td class="app-user">
                <a href="{{ url(route('micadmin.user.settings', [$app->user_id])) }}" >
                  @if ($app->user_id != config('mic.pending_user'))
                  <i class="fa fa-user"></i>
                  {{ $app->user->name.' (#'.$app->user_id.')' }}
                  @endif
                </a>
              </td>
              
              <td class="action"></td>
            </tr>
            @endforeach
          </tbody>
        </table>
        
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $apps->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </section>
  </div>
@endsection
