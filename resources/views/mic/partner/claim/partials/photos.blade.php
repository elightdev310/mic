<div class="">
  <!--<div class="box-header"></div>-->
  <div class="box-body">
    <ul class="files_container claim-photo-section">
    @include('mic.partner.claim.partials.photo_list')
    </ul>
  </div>
</div>

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
