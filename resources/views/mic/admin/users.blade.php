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

          {!! Form::open(['route' => ['micadmin.users.list'], 
                'method'=>'get', 
                'class' =>'frm-search-user']) !!}
          <div class="row">
              <div class="col-sm-9">
                  <div id="imaginary_container"> 
                      <div class="input-group stylish-input-group">
                          {!! Form::text('search_txt', Request::get('search_txt'), ['class' => 'form-control', 'placeholder'=>'Search']) !!}
                          <span class="input-group-addon">
                              <button type="submit">
                                  <span class="glyphicon glyphicon-search"></span>
                              </button>  
                          </span>
                      </div>
                  </div>
              </div>
          </div>

          <div class='row pt10'>
              <div class='form-group col-sm-3 user-type-section'>
                  {!! Form::select('user_type', 
                                  [ snake_case(config('mic.user_type.patient')) => ucfirst(config('mic.user_type.patient')), 
                                    snake_case(config('mic.user_type.partner')) => ucfirst(config('mic.user_type.partner')), 
                                    snake_case(config('mic.user_type.case_manager')) => ucfirst(config('mic.user_type.case_manager')), 
                                    strtolower(config('mic.user_type.employee')) => ucfirst(config('mic.user_type.employee')) ],
                                  Request::get('user_type'), 
                                  ['class' => 'form-control', 'placeholder' => '- All User Type -']); 
                    !!}
              </div>
              <div class='form-group col-sm-3 partner-type-section'>
                  {!! 
                    Form::select('partner_type', 
                                  config('mic.partner_type'),
                                  Request::get('partner_type'), 
                                  ['class' => 'form-control', 'placeholder' => '- All Partners -']) 
                  !!}
              </div>
              <div class='form-group col-sm-3'>
                  {!! Form::select('status', 
                                  [ config('mic.user_status.active') => ucfirst(config('mic.user_status.active')), 
                                    config('mic.user_status.pending') => ucfirst(config('mic.user_status.pending')), 
                                    config('mic.user_status.cancel') => ucfirst(config('mic.user_status.cancel')) ],
                                  Request::get('status'), 
                                  ['class' => 'form-control', 'placeholder' => '- All Status -']); 
                  !!}
              </div>
              <div class='form-group col-sm-3'>
                  {!! Form::submit('Filter', ['class'=>'btn btn-primary']) !!}
              </div>
          </div>
          {!! Form::close() !!}

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
            @if (count($users))
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
              <td class="user-type">
                {{ ucfirst(config('mic.user_type.'.$user->type)) }}
                @if ($user->type == 'partner' && $user->partner) 
                  - {{ ucfirst(config('mic.partner_type.'.$user->partner->membership_role)) }}
                @endif 
              </td>
              <td class="user-status">{{ ucfirst($user->status) }}</td>
              <td class="user-from">{{ MICUILayoutHelper::strTime($user->created_at) }}</td>

            </tr>
            @endforeach
            @else
            <tr">
              <td colspan="6"><p class="text-center p10">No User</p></td>
            </tr>
            @endif
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $paginate->appends(Request::except('page'))->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </section>
  </div>
@endsection


@push('scripts')
<script>

$(function () {
  function partnerFilterVisible() {
    if ($('.user-type-section select').val() == 'partner') {
      $('.partner-type-section').removeClass('hidden');
    } else {
      $('.partner-type-section').addClass('hidden');
    }
  }

  $('.user-type-section select').on('change', function() {
    partnerFilterVisible();
  });

  partnerFilterVisible();

});
</script>
@endpush
