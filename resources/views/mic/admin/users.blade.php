@extends('mic.layouts.admin')

@section('htmlheader_title') User Accounts @endsection
@section('contentheader_title') User Accounts @endsection

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      <div class="users-box box box-primary">
        <div class="box-header">
          <div class="paginator pull-right">
            {{ $users->links() }}
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

        <table class="table table-striped table-hover">
          <thead>
            <th class="user-id">User ID</th>
            <th class="user-name">Name</th>
            <th class="user-email">Email</th>
            <th class="user-type">Type</th>
            <th class="user-status">Status</th>
            <th class="user-from">Member Since</th>

          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr data-user-id="{{ $user->id }}">
              <td class="user-id">{{ $user->id }}</td>
              <td class="user-name">
                {!! MICUILayoutHelper::avatarImage($user, 24) !!}
                <a href="{{ url(route('micadmin.user.settings', [$user->id])) }}">
                  {{ $user->name }}
                </a>
              </td>
              <td class="user-email">{{ $user->email}}</td>
              <td class="user-type">{{ ucfirst($user->type) }}</td>
              <td class="user-status">{{ ucfirst($user->status) }}</td>
              <td class="user-from">{{ MICUILayoutHelper::strTime($user->created_at) }}</td>

            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $users->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </section>
  </div>
</section><!-- /.content -->
@endsection
