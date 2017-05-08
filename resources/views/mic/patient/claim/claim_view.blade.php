@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} @endsection

@section('page_id')partner-claim-view-page @endsection
@section('page_classes')claim-page partner-page @endsection

@section('content')
<div id="page-content" class="profile2">
  @include('mic.patient.claim.partials.claim_view_header')

  <div class="row mt20">
    <div class="col-sm-8">
      <div class="content-box white infolist p10">
        @include('mic.patient.claim.partials.activity')
      </div>
    </div>
    <div class="col-sm-4">
      <div class="claim-right-panel claim-docs-panel content-box white">
        <div class="panel-header">
          Docs
        </div>
        <div class="panel-body">

          @if (count($docs))
          <ul>
            @foreach ($docs as $doc)
            <li class="claim-doc-item text-color-primary text-bold">{{ $doc->file->name }}</li>
            @endforeach
          </ul>
          @else
          <div class="text-center p10">
            No Document
          </div>
          @endif

        </div>
      </div>

      <div class="claim-right-panel claim-photos-panel content-box white">
        <div class="panel-header">
          Photos
          @if ($photo_count)
          <span class="pull-right">{{ $photo_count }}</span>
          @endif
        </div>
        <div class="panel-body">
          @if (count($photos))
          @foreach ($photos as $photo)
          <div class="pull-left claim-photo-item">
            <a class="fm_file_sel" href="{{ $photo->file->path() }}" title="{{ $photo->file->name }}" data-gallery 
                data-toggle="tooltip" data-placement="top" title="" upload="" data-original-title="{{ $photo->file->name }}">
              <img src="{{ $photo->file->path() }}?s=90">
            </a>
          </div>
          @endforeach

          <div id="blueimp-gallery" class="blueimp-gallery">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
          </div>

          @else
          <div class="text-center p10">
            No Photo
          </div>
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@endsection

@push('styles')
<link href="{{ asset('assets/plugins/blueimp-gallery/css/blueimp-gallery.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/blueimp-gallery/css/blueimp-gallery-indicator.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-helper.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery-fullscreen.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/blueimp-gallery-indicator.js') }}"></script>
<script src="{{ asset('assets/plugins/blueimp-gallery/js/jquery.blueimp-gallery.js') }}"></script>
@endpush
