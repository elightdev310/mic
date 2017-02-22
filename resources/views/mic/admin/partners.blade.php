@extends('mic.layouts.admin')

@section('htmlheader_title') Partners @endsection
@section('contentheader_title') Partners @endsection

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      <div class="partners-box box box-primary">
        <div class="box-header">
          <div class="paginator pull-right">
            {{ $partners->links() }}
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

        <table class="table table-striped table-hover">
          <thead>
            <th class="partner-name">Full Name</th>
            <th class="partner-email">Email</th>
            <th class="partner-company">Company</th>
            <th class="partner-phone">Phone</th>
            <th class="partner-user">User Account</th>
            <th class="partner-status">Status</th>
            <th class="action">Action</th>
          </thead>
          <tbody>
            @foreach ($partners as $partner)
            <tr data-partner-id="{{ $partner->id }}">
              <td class="partner-name">
                {{ $partner->first_name.' '.$partner->last_name }}
              </td>
              <td class="partner-email">{{ $partner->user->email }}</td>
              <td class="partner-company">{{ $partner->company }}</td>
              <td class="partner-phone">{{ $partner->phone}}</td>
              <td class="partner-user">
                <a href="{{ url(route('micadmin.user.settings', [$partner->user_id])) }}">
                  <i class="fa fa-user"></i>
                  {{ $partner->user->name.' ('.$partner->user_id.')' }}
                </a>
              </td>
              <td class="partner-status">{{ ucfirst($partner->user->status) }}</td>
              <td class="action"></td>
            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $partners->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </section>
  </div>
</section><!-- /.content -->
@endsection
