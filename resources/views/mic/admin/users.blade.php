@extends('mic.layouts.admin')

@section('htmlheader_title') User Accounts @endsection
@section('contentheader_title') User Accounts @endsection

@section('main-content')
<!-- Main content -->
  <div class="row">
    <section class="col-md-12">

      <div class="users-box box box-primary">
        <div class="box-header">
          <div class="row">
            <div class="form-group col-sm-6 add-link pt20 pb20">
              <a href="{{ route('micadmin.user.add') }}" class="btn btn-success">+ Add User</a>
            </div>
          </div>

          <div class='row'>
            {!! Form::open(['route' => ['micadmin.users.list'], 
                'method'=>'get', 
                'class' =>'frm-search-user']) !!}

              <div class='form-group col-sm-4'>
                  {!! Form::select('user_type', 
                                  [ snake_case(config('mic.user_type.patient')) => ucfirst(config('mic.user_type.patient')), 
                                    snake_case(config('mic.user_type.partner')) => ucfirst(config('mic.user_type.partner')), 
                                    snake_case(config('mic.user_type.case_manager')) => ucfirst(config('mic.user_type.case_manager')), 
                                    strtolower(config('mic.user_type.employee')) => ucfirst(config('mic.user_type.employee')) ],
                                  Request::get('user_type'), 
                                  ['class' => 'form-control', 'placeholder' => '- All User Type -']); 
                    !!}
              </div>
              <div class='form-group col-sm-4'>
                  {!! Form::select('status', 
                                  [ config('mic.user_status.active') => ucfirst(config('mic.user_status.active')), 
                                    config('mic.user_status.pending') => ucfirst(config('mic.user_status.pending')), 
                                    config('mic.user_status.cancel') => ucfirst(config('mic.user_status.cancel')) ],
                                  Request::get('status'), 
                                  ['class' => 'form-control', 'placeholder' => '- All Status -']); 
                  !!}
              </div>
              <div class='form-group col-sm-4'>
                  {!! Form::submit('Filter', ['class'=>'btn btn-primary']) !!}
              </div>
            {!! Form::close() !!}
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
              <td class="user-type">{{ ucfirst(config('mic.user_type.'.$user->type)) }}</td>
              <td class="user-status">{{ ucfirst($user->status) }}</td>
              <td class="user-from">{{ MICUILayoutHelper::strTime($user->created_at) }}</td>

            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $users->appends(Request::except('page'))->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </section>
  </div>
@endsection
