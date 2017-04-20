@extends('mic.layouts.admin')

@section('htmlheader_title') Patients @endsection
@section('contentheader_title') Patients @endsection

@section('main-content')
<!-- Main content -->
  <div class="row">
    <div class="col-md-12">

      <div class="patients-box box box-primary ">
        <div class="box-header">
          <div class='row'>
            {!! Form::open(['route' => ['micadmin.patients.list'], 
                'method'=>'get', 
                'class' =>'frm-search-user']) !!}
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
              <th class="patient-name">Full Name</th>
              <th class="patient-email">Email</th>
              <th class="patient-phone">Phone</th>
              <th class="patient-birth">Birthday</th>
              <th class="patient-user">User Account</th>
              <th class="patient-status">Status</th>
              <th class="action">Action</th>
            </thead>
            <tbody>
              @foreach ($patients as $patient)
              <tr data-patient-id="{{ $patient->id }}">
                <td class="patient-name">
                  {{ $patient->first_name.' '.$patient->last_name }}
                </td>
                <td class="patient-email">{{ $patient->user->email }}</td>
                <td class="patient-phone">{{ $patient->phone}}</td>
                <td class="patient-birth">{{ MICUILayoutHelper::strTime($patient->date_birth) }}</td>
                <td class="patient-user">
                  <a href="{{ url(route('micadmin.user.settings', [$patient->user_id])) }}">
                    {!! MICUILayoutHelper::avatarImage($patient->user, 24) !!}
                    {{ $patient->user->name.' (#'.$patient->user_id.')' }}
                  </a>
                </td>
                <td class="patient-status">{{ ucfirst($patient->user->status) }}</td>
                <td class="action"></td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $paginate->links() }}
          </div>
        </div>
      </div><!-- /.box -->

    </div>
  </div>
@endsection
