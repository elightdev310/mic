@extends('mic.layouts.'.$layout)

@section('htmlheader_title')Notifications @endsection
@section('contentheader_title')Notifications @endsection

@section('content')
<div class="row">
  <section class="col-md-12">
    <div class="notification-section box box-primary">
      <div class="box-header row">
        <div class="col-sm-6">

        </div>
        <div class="col-sm-6 text-right">
          {{ $notifications->links() }}
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="notification-list">
          @foreach ($notifications as $notification) 
          <div class="noti-item" data-noti-id="{{ $notification->id }}">
            {{-- <div class="noti-remove-icon">
              <a href="#" class="noti-remove" data-url="{{ route('notification.delete', [$notification->id]) }}">
                <span class="fa fa-remove"></span> 
              </a>
            </div> --}}
            <div class="noti-message">
              {{ $notification->message }}
            </div>
            <div class="noti-time">
              {{ MICUILayoutHelper::strDTime($notification->created_at) }}
            </div>
          </div>
          @endforeach
        </div>
      </div><!-- /.box-body -->
      <div class="box-footer clearfix no-border">
        <div class="paginator pull-right">
          {{ $notifications->links() }}
        </div>
      </div>

    </div><!-- /.box -->

  </section>
</div>
@endsection

@push('scripts')

<script>
(function ($) {
  $(document).ready(function() {
    // $('.noti-remove').on('click', function() {
    //   var url = $(this).data('url');
    //   var $noti = $(this).closest('.noti-item');

    //   $.ajax({
    //     dataType: 'json',
    //     url: url,
    //     success: function ( json ) {
    //       $noti.fadeOut('fast', function(){ $noti.remove(); });
    //     }
    //   });

    //   return false;
    // });
  });
})(jQuery);
</script>
@endpush
