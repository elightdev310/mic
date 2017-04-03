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
        <div class="col-md-3 col-sm-6 video-item">

          @if ($video->va->price && !$video->purchased)
          <a href="{{ route('learning_center.video.purchase', [$video->va->id] )}}" data-lity>
          @else
          <a href="https//www.youtube.com/embed/{{ $video->video->id }}" data-lity>
          @endif

            <div class="video-thumbnail">
              <img src="{{ $video->video->snippet->thumbnails->high->url }}" />
              <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
            </div>
          </a>
          <div class="video-info">
            <div class="video-title">
              @if ($video->va->price && !$video->purchased)
              <a href="{{ route('learning_center.video.purchase', [$video->va->id] )}}" data-lity>
              @else
              <a href="https//www.youtube.com/embed/{{ $video->video->id }}" data-lity>
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
@endsection


@push('styles')
<link href="{{ asset('assets/plugins/lity/lity.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/lity/lity.min.js') }}"></script>
@endpush
