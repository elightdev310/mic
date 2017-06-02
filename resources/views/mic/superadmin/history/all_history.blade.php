@extends('mic.layouts.admin')

@section('htmlheader_title')All History @endsection
@section('contentheader_title')All History @endsection

@section('main-content')
<div class="logs-box box box-primary">
  <div class="box-header">
  </div>

  <div class="box-body table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <th class="user-name">Name</th>
        <th class="log-desc">Description</th>
        <th class="log-type">Content Type</th>
        <th class="log-content-id">Content ID</th>
        <th class="log-action">Action</th>
        <th class="log-time">Time</th>
        <th class="log-ip">IP</th>

      </thead>
      <tbody>
        @if (count($logs))
        @foreach ($logs as $log)
        <tr>
          <td class="user-name">
            {!! MICUILayoutHelper::avatarImage($log->user, 24) !!}
            <span>{{ $log->user->name }}</span>
          </td>
          <td>{{ $log->description }}</td>
          <td class="log-type">{{ $log->content_type }}</td>
          <td class="log-content-id">{{ $log->content_id }}</td>
          <td class="log-action">{{ $log->action }}</td>
          <td class="log-time">{{ MICUILayoutHelper::strTime($log->created_at, "M d, Y H:i") }}</td>
          <td class="log-ip">{{ $log->ip_address }}</td>

        </tr>
        @endforeach
        @else
        <tr">
          <td colspan="4"><p class="text-center p10">No Log</p></td>
        </tr>
        @endif
      </tbody>
    </table>

    </div><!-- /.box-body -->
    <div class="box-footer clearfix no-border">
      <div class="paginator pull-right">
        {{ $logs->appends(Request::except('page'))->links() }}
      </div>
    </div>
  </div><!-- /.box -->
</div>

@endsection


@push('scripts')
<script>
$(function () {

});
</script>
@endpush
