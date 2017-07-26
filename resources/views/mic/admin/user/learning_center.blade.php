@if (session('_action')=='saveLearningCenter')
  @include('mic.admin.partials.success_error')
@endif


<div class="users-box box box-success">
  {!! Form::open(['route'=>['micadmin.user.learning_video.sort.post', $user->id], 'method'=>'post']) !!}
  <div class="box-header">
    <div class="pull-left">
      <p class="description">Please drag & drop to rearrange videos.</p>
    </div>
    <div class="pull-right">
      <a href="{{ route('micadmin.user.learning_video.add', [$user->id]) }}" class="btn btn-success">Add Video</a>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body table-responsive">

      @if (!empty($user_videos))
        <ul class="user-video-list video-list todo-list">
          @foreach ($user_videos as $video)
          <li id="va-{{$video->va->id}}" class="video-item @if ($video->watched) watched-video @endif">
            <div class="handle video-thumbnail">

              @if ($video->watched)
              <div class="mark-watched-bg"></div>
              <div class="mark-watched"><i class="fa fa-eye" aria-hidden="true"></i></div>
              @endif

              <img src="{{ $video->video->snippet->thumbnails->default->url }}" />
              <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
            </div>
            <div class="video-info">
              <div class="video-title">
                <a href="//www.youtube.com/embed/{{ $video->video->id }}" data-lity>
                {{ $video->video->snippet->title }}
                @if ($video->va->price)
                  @if ($video->purchased)
                  &nbsp;<span class="text-primary purchased-mark">(PURCHASED)</span>
                  @else
                  <span class="video-price">
                    (${{ number_format($video->va->price, 2) }})
                  </span>
                  @endif
                @endif 

                @if ($video->watched) 
                  &nbsp;<span>[Watched {{ MICUILayoutHelper::strTime($video->watched, 'M d, Y H:i') }}]</span>
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
              <a href="#" class="video-delete" data-url="{{ route('micadmin.user.learning_video.delete', [$user->id, $video->va->id]) }}">
                <i class="fa fa-trash-o"></i></a>
            </div>
          </li>
          @endforeach
        </ul>
      @else
      <p class="text-center p10">No User-Specific Videos</p>
      @endif
  </div><!-- /.box-body -->
  <div class="box-footer clearfix no-border">
    @if (!empty($user_videos))
    <div class="paginator pull-right">
      {!! Form::submit('Save Order Changes', ['class'=>'btn btn-success']) !!}
    </div>
    @endif
  </div>

  {!! Form::close() !!}
</div><!-- /.box -->


<div class="users-box box box-primary">
  <div class="box-header">
    <h3>Group Videos</h3>
  </div><!-- /.box-header -->
  <div class="box-body">
    @if (!empty($group_videos))
        <ul class="video-list todo-list">
          @foreach ($group_videos as $video)
          <li id="va-{{$video->va->id}}" class="video-item @if ($video->watched) watched-video @endif">
            <div class="handle video-thumbnail">

              @if ($video->watched)
              <div class="mark-watched-bg"></div>
              <div class="mark-watched"><i class="fa fa-eye" aria-hidden="true"></i></div>
              @endif

              <img src="{{ $video->video->snippet->thumbnails->default->url }}" />
              <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
            </div>
            <div class="video-info">
              <div class="video-title">
                <a href="//www.youtube.com/embed/{{ $video->video->id }}" data-lity>
                {{ $video->video->snippet->title }}
                @if ($video->va->price)
                  @if ($video->purchased)
                  &nbsp;<span class="text-primary purchased-mark">(PURCHASED)</span>
                  @else
                  <span class="video-price">
                    (${{ number_format($video->va->price, 2) }})
                  </span>
                  @endif
                @endif 

                @if ($video->watched) 
                  &nbsp;<span>[Watched {{ MICUILayoutHelper::strTime($video->watched, 'M d, Y H:i') }}]</span>
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
            
          </li>
          @endforeach
        </ul>
      @else
      <p class="text-center p10">No Group Videos</p>
      @endif
  </div>
</div>



@push('scripts')

<script>
(function ($) {
  $(document).ready(function() {
    $('.user-video-list').sortable({
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
