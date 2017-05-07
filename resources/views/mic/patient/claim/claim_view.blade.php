@extends('mic.layouts.partner')

@section('htmlheader_title')Claim #{{$claim->id}} @endsection

@section('page_id')partner-claim-view-page @endsection
@section('page_classes')claim-page partner-page @endsection

@section('content')
<div id="page-content" class="profile2">
  @include('mic.partner.claim.partials.claim_view_header')

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
            <a class="fm_file_sel" href="{{ $photo->file->path() }}" title="{{ $photo->file->name }}" data-gallery="#claim-photo" 
                data-toggle="tooltip" data-placement="top" title="" upload="" data-original-title="{{ $photo->file->name }}">
              <img src="{{ $photo->file->path() }}?s=90">
            </a>
          </div>
          @endforeach
          @endif
        </div>
      </div>

    </div>
  </div>

</div>
@endsection
