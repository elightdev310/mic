@extends('mic.layouts.admin')

@section('htmlheader_title')Learning Videos @endsection
@section('contentheader_title')Learning Videos @endsection

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      @include('mic.admin.partials.success_error')

      <div class="users-box box box-success">
        {!! Form::open(['route'=>'micadmin.learning_video.sort.post', 'method'=>'post']) !!}
        <div class="box-header">
          <div class="pull-left">
            <p class="description">Please drag & drop to rearrange videos in group.</p>
          </div>
          <div class="pull-right">
            <a href="{{ route('micadmin.learning_video.add') }}" class="btn btn-success">Add Video</a>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

          <div class="group-videos">
            @foreach ($group_videos as $group=>$g_videos)
            <div class="group-video-section">
              <div class="group-title">For {{ $groups[$group] }}</div>
              @if (!empty($g_videos))
                <ul class="video-list todo-list">
                  @foreach ($g_videos as $video)
                  <li id="va-{{$video->va->id}}">
                    <div class="handle video-thumbnail">
                      <img src="{{ $video->video->snippet->thumbnails->default->url }}" />
                      <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
                    </div>
                    <div class="video-info">
                      <div class="video-title">
                        <a href="//www.youtube.com/embed/{{ $video->video->id }}" data-lity>
                        {{ $video->video->snippet->title }}
                        @if ($video->va->price)
                        <span class="video-price">
                          (${{ number_format($video->va->price, 2) }})
                        </span>
                        @endif 
                        </a>
                      </div>
                      <div class="video-channel">
                        {{ $video->video->snippet->channelTitle }}
                      </div>
                      <div class="video-review">
                        <span>{{ $video->video->statistics->viewCount }} views</span> - 
                        <span>{{ MICUILayoutHelper::agoTime($video->video->snippet->publishedAt, ' ago') }}</span>
                      </div>
                    </div>

                    {!! Form::input("hidden", "va_weight[{$video->va->id}]", $video->va->weight, 
                                    ['class'=>'va-weight']) !!}
                    
                    <div class="tools">
                      <a href="#" class="video-delete" data-url="{{ route('micadmin.learning_video.delete', [$video->va->id]) }}">
                        <i class="fa fa-trash-o"></i></a>
                    </div>
                  </li>
                  @endforeach
                </ul>
              @else
              <p class="text-center p10">No Videos</p>
              @endif
            </div>
            @endforeach
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {!! Form::submit('Save Order Changes', ['class'=>'btn btn-success']) !!}
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
    $('.video-list').sortable({
      placeholder: "sort-highlight",
      handle: ".handle",
      forcePlaceholderSize: true,
      zIndex: 99999, 
      update: function(event, ui) {
        $sort = $(this).sortable('toArray');
        for ($i in $sort) {
          var $li = $('#'+$sort[$i]);
          $li.find('.va-weight').val($i);
        }
      }
    });

    $('.video-delete').on('click', function() {
      var url = $(this).data('url');
      bootbox.confirm({
        title: "Delete Video", 
        message: "<p>Are you sure to delete video?</p>", 
        callback: function (result) {
          if (result) {
            window.location.href = url;
          }
        }
      });
    });
  });
})(jQuery);
</script>
@endpush


@push('styles')
<link href="{{ asset('assets/plugins/lity/lity.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/lity/lity.min.js') }}"></script>
@endpush
