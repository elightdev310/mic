@extends('mic.layouts.admin')

@section('htmlheader_title')Claims @endsection
@section('contentheader_title')Claims @endsection

@section('main-content')
  <div class="row">
    <section class="col-md-12">
      <div class="claims-list box box-primary">
        <div class="box-header row">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6 text-right">
            {{ $claims->links() }}
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="claim-id">#</th>
            <th class="patient-user">Patient User</th>
            <th class="claim-submit-date">Submit Time</th>
            <th class="row-action">Action</th>
          </thead>
          <tbody>
            @foreach ($claims as $claim)
            <tr data-claim-id="{{ $claim->id }}">
              <td class="claim-id">
                <a href="{{ route('micadmin.claim.page', [$claim->id]) }}" class="">
                  Claim #{{ $claim->id }}
                </a>
              </td>
              <td class="patient-user">
                {!! MICUILayoutHelper::avatarImage($claim->patientUser, 24) !!}
                {{ $claim->patientUser->name }}
              </td>
              <td class="claim-submit-date">{{ MICUILayoutHelper::strTime($claim->created_at, "M d, Y H:i") }}</td>
              <td class="row-action">
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {{ $claims->links() }}
          </div>
        </div>

      </div><!-- /.box -->
    </section>
  </div>
@endsection
