@extends('mic.layouts.admin')

@section('htmlheader_title') Applications @endsection
@section('contentheader_title') Applications @endsection

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      @include('mic.admin.partials.success_error')

      <div class="pending-applications application-box box box-primary">
        {!! Form::open(['route' => 'micadmin.app.bulk_action.post', 'method'=>'post']) !!}
        <div class="box-header row">
          <div class="col-sm-6">
            <div class="bulk-action-section">
            {!! Form::select('_action', 
                            ['approve' => 'Approve'],
                            null, 
                            ['class' => 'form-control action-name', 'placeholder'=> '- Bulk Action -']); !!}
            {!! Form::submit('Apply', ['class'=>'btn btn-primary']) !!}
            </div>
          </div>
          <div class="col-sm-6 text-right">
            {{ $apps->links() }}
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th class="check-all"><input type="checkbox" class="minimal checkbox checkbox-all"></th>
            <th class="app-name">Full Name</th>
            <th class="app-email">Email</th>
            <th class="app-company">Company</th>
            <th class="app-role">Membership Role</th>
            <th class="app-submit-date">Submit Time</th>

            <th class="row-action">Action</th>
          </thead>
          <tbody>
            @foreach ($apps as $app)
            <tr data-app-id="{{ $app->id }}">
              <td class="check-row"><input type="checkbox" class="checkbox minimal" name="check_row[]" value="{{$app->id}}"></td>
              <td class="app-name">
                <a href="{{ url(route('micadmin.app.view', [$app->id])) }}" class="">
                  {{ $app->first_name.' '.$app->last_name }}
                </a>
              </td>
              <td class="app-email">{{ $app->email }}</td>
              <td class="app-company">{{ $app->partner->company }}</td>
              <td class="app-role">{{ ucwords(config('mic.partner_type.'.$app->partner->membership_role)) }}</td>
              <td class="app-submit-date">{{ MICUILayoutHelper::agoTime($app->created_at) }} ago</td>
              <td class="row-action">
                <a href="#" class="action-link approve-action" data-url="{{ route('micadmin.app.approve', [$app->id]) }}" title="Approve">
                  <i class="fa fa-check-square-o"></i>
                </a>                
              </td>
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
        {!! Form::close() !!}
      </div><!-- /.box -->

    </section>
  </div>
</section><!-- /.content -->
@endsection


@push('scripts')
<script>
(function ($) {
$(document).ready(function() {
  $('a.approve-action').click(function() {
    var approve_url = $(this).data('url');
    var $_row = $(this).closest('tr');
    bootbox.confirm({
      message: "<p>Are you sure to approve "+ $_row.find('.app-name').html() +"'s application?</p>", 
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
