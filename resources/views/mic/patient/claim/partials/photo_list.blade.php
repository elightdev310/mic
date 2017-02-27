@if (count($photos))
@foreach ($photos as $photo)
<li>
  <a class="fm_file_sel" href="{{ $photo->file->path() }}" title="{{ $photo->file->name }}" data-gallery="#claim-photo" 
      data-toggle="tooltip" data-placement="top" title="" upload="" data-original-title="{{ $photo->file->name }}">
    <img src="{{ $photo->file->path() }}?s=130">
  </a>
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
