@if (isset($photos) && count($photos))
@foreach ($photos as $photo)
<li class="claim-photo-item">
  <div class="hovereffect">
    <img src="{{ $photo->file->path() }}?s=130">
    <div class="overlay-pane">
      <a class="fm_file_sel info" href="{{ $photo->file->path() }}" title="{{ $photo->file->name }}" data-gallery="#claim-photo" 
        data-toggle="tooltip" data-placement="top" title="" upload="" data-original-title="{{ $photo->file->name }}">
        <i class="fa fa-eye"></i>
        <img src="{{ $photo->file->path() }}?s=130" class="hidden">
      </a>
      <a class="delete-photo-link info" href="#tab-photos", 
          data-url="{{ route('patient.claim.delete.photo', [$claim->id, $photo->id]) }}" title="Delete">
        <i class="fa fa-trash"></i>
      </a>
    </div>
  </div>
</li>
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
<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>
@endif

