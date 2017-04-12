@extends('mic.layouts.'.$layout)

@section('htmlheader_title') Learning Center @endsection
@section('contentheader_title')@endsection
@section('page_id')learning-center-page @endsection
@section('page_classes')learning-center @endsection

@section('content')
<!-- Main content -->
  <div class="content-box p30">
    <div class="row pl30 pr30">
      <div class="col-sm-5">
        <h1 class="text-color-primary">Welcome to MIC Learning Center!</h1>
        <p>Lorem ipsum dolor sit amet, sea ipsum officiis ea, mei no fabulas gubergren constituam. Cibo altera at eum, id sit salutandi periculis. Eos cu probo atqui novum, eum te dicant mediocrem. Putant vocibus eos et, vim facer inani sapientem eu.</p>
      </div>
      <div class="col-sm-7">
        <iframe width="100%" height="315" src="https://www.youtube.com/embed/IW22_OnpS5Y" frameborder="0" allowfullscreen></iframe>
      </div>
    </div>

    <div class="row pl30 pr30 pt30">
      <div class="col-sm-12">
        <h3>Recommended</h3>
      </div>
    </div>

    <div class="learning-center-videos video-list">
      <div class="row pl30 pr30 pb30">

        @foreach ($videos as $video)
        <div class="col-md-3 col-sm-6 video-item @if ($video->watched) watched-video @endif">
          @if ($video->va->price && !$video->purchased)
          <a href="{{ route('learning_center.video.purchase', [$video->va->id] )}}" data-lity>
          @else
          <a href="#" data-video ="{{ $video->video->id }}" class="youtube-link">
          @endif
            <div class="video-thumbnail">
              @if ($video->watched)
              <div class="mark-watched-bg"></div>
              <div class="mark-watched"><i class="fa fa-eye" aria-hidden="true"></i></div>
              @endif
              <img src="{{ $video->video->snippet->thumbnails->high->url }}" />
              <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
            </div>
          </a>
          <div class="video-info">
            <div class="video-title">
              @if ($video->va->price && !$video->purchased)
              <a href="{{ route('learning_center.video.purchase', [$video->va->id] )}}" data-lity>
              @else
              <a href="#" data-video ="{{ $video->video->id }}" class="youtube-link">
              @endif
              
              {{ $video->video->snippet->title }}

              @if ($video->va->price && $video->purchased)
              &nbsp;<span class="text-primary purchased-mark">(PURCHASED)</span>
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

            @if ($video->va->price && !$video->purchased)
            <div class="video-purchase">
              <span class="video-price">
                Price: ${{ number_format($video->va->price, 2) }}
              </span>
              &nbsp;
              <a href="{{ route('learning_center.video.purchase', [$video->va->id] )}}" class="btn btn-primary btn-sm" data-lity>
                Purchase
              </a>
            </div>
            @endif

          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>

  <div class="youtube-video-player">
  <div class="lity lity-youtube lity-opened" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1">
    <div class="lity-wrap" data-lity-close role="document">
      <div class="lity-container">
        <div class="lity-content">
          <div class="lity-iframe-container">
            <div id='videoPlayer'></div>
          </div>
        </div>
        <button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button>
      </div>
    </div>
  </div>
  </div>
@endsection


@push('styles')
<link href="{{ asset('assets/plugins/lity/lity.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
{{-- Youtube Video Tracking --}}
<script>
var tag = document.createElement('script');

tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

var videoPlayer;
// function onYouTubeIframeAPIReady() {
function loadYoutubeVideo(videoId) {
  videoPlayer = new YT.Player('videoPlayer', {
    videoId: videoId,
    playerVars: {
      controls: 1, 
      showinfo: 1, 
      rel: 0, 
    }, 
    events: {
      'onStateChange': onPlayerStateChange,
      'onError': onPlayerError
    }
  });
  videoPlayer.video_id = videoId;
  
  $('.youtube-video-player').addClass('opened');
};

function onPlayerStateChange(event) {
  switch (event.data) {
    case YT.PlayerState.PLAYING:
      if (cleanTime() == 0) {
          // console.log('started ' + cleanTime());
          // ga('send', 'event', 'video', 'started', video);
      } else {
          // console.log('playing ' + cleanTime())
          // ga('send', 'event', 'video', 'played', 'v: ' + video + ' | t: ' + cleanTime());
      };
      break;
  case YT.PlayerState.PAUSED:
      if (videoPlayer.getDuration() - videoPlayer.getCurrentTime() != 0) {
          // console.log('paused' + ' @ ' + cleanTime());
          // ga('send', 'event', 'video', 'paused', 'v: ' + video + ' | t: ' + cleanTime());
      };
      break;
  case YT.PlayerState.ENDED:
      // console.log('ended ');
      // ga('send', 'event', 'video', 'ended', video);
      trackVideo(videoPlayer.video_id, 'ended');
      break;
  };
};
//utility
function cleanTime(){
    return Math.round(videoPlayer.getCurrentTime())
};

function onPlayerError (event) {
  switch(event.data) {
      case 2:
          //console.log('' + video.id)
          // ga('send', 'event', 'video', 'invalid id',video);
          break;
      case 100:
          // ga('send', 'event', 'video', 'not found',video);
          break;
      case 101 || 150:
          // ga('send', 'event', 'video', 'not allowed',video);
          break;
      };
};

function trackVideo(vid, state) {
  var trackUrl = '{{ route('learning_center.video.track') }}';
  $.ajax({
      url: trackUrl,
      data: {
        vid: vid, 
        state: state
      }, 
      success: function ( json ) {
        window.location.reload(false); 
      }
  });
}

$(function () {
  $("a.youtube-link").on('click', function() {
    var videoId = $(this).data('video');
    loadYoutubeVideo(videoId);
    return false;
  });
  $('.youtube-video-player .lity-close').on('click', function() {
    $('.youtube-video-player').removeClass('opened');
    $('.youtube-video-player .lity-iframe-container').html("<div id='videoPlayer'></div>");
  });
});
</script>

<script src="{{ asset('assets/plugins/lity/lity.min.js') }}"></script>
@endpush

