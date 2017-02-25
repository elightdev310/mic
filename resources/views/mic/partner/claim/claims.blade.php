@extends('mic.layouts.partner')

@section('htmlheader_title')My Claims @endsection
@section('contentheader_title')My Claims @endsection

@section('page_id')my_claims @endsection

@section('page_classes')my-claims @endsection

@section('content')
  <div class="row">
    <section class="col-md-12">
      <div class="my-claims-list box box-primary">
        <div class="box-header row">
          <div class="col-sm-6">

          </div>
          <div class="col-sm-6 text-right">
            
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="claim-id">#</th>
            <th class="patient-name">Patient Name</th>
            <th class="claim-submit-date">Created At</th>
            <th class="row-action">Action</th>
          </thead>
          <tbody>
            @foreach ($claims as $claim)
            <tr data-claim-id="{{ $claim->id }}">
              <td class="claim-id">
                <a href="{{ route('partner.claim.page', [$claim->id]) }}" class="">
                  Claim #{{ $claim->id }}
                </a>
              </td>
              <td>{{ $claim->patientUser->name }}</td>
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
            
          </div>
        </div>

      </div><!-- /.box -->

    </section>
  </div>
@endsection
