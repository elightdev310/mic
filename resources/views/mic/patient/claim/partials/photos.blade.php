<form action="{{ route('patient.claim.upload.photo', [$claim->id]) }}" id="fm_dz_photo" class="dropzone-form" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
  <a id="closePhotoDZ" class="closeDZ"><i class="fa fa-times"></i></a>
  <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop photos here to upload. <br>Photo should be less than 2M.</div>
</form>

<div class="">
  <!--<div class="box-header"></div>-->
  <div class="box-body photos-box">
    <ul class="files_container claim-photo-section">
    @include('mic.patient.claim.partials.photo_list')
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
<script>
var fm_dz_photo = null;
$(function () {
  fm_dz_photo = new Dropzone("#fm_dz_photo", {
      maxFilesize: 2, // MB
      acceptedFiles: "image/*",
      init: function() {
          this.on("complete", function(file) {
              this.removeFile(file);
          });
          this.on("success", function(file) {
              loadClaimPhotos();
          });
      }
  });
  $("#fm_dz_photo").slideUp();
  $("#AddNewPhotos").on("click", function() {
      $("#fm_dz_photo").slideDown();
  });
  $("#closePhotoDZ").on("click", function() {
      $("#fm_dz_photo").slideUp();
  });

  // Delete Link
  $('.claim-photo-section').on('click', 'a.delete-photo-link', function() {
    var delete_url = $(this).data('url');
    var $photo_item = $(this).closest('.claim-photo-item');
    bootbox.confirm({
      message: "<p>Are you sure to delete photo?</p>", 
      callback: function (result) {
        if (result) {
          $('.photos-box').loadingOverlay();
          $.ajax({
              dataType: 'json',
              url: delete_url
            })
          .done(function( json, textStatus, jqXHR ) {
            if (json.status=='success') {
              $photo_item.remove();
            } else if (json.status=='error') {
              //console.log(json.message);
              if (json.action == 'reload') {
                MICApp.UI.reloadPage();
              }
            }
          })
          .fail(function( jqXHR, textStatus, errorThrown ) {})
          .always(function( data, textStatus, errorThrown ) { 
            $('.photos-box').loadingOverlay('remove');
          });
        }
      }
    });
  });

});

function loadClaimPhotos() {
  // load claim photo
  $("ul.files_container").loadingOverlay();
  $.ajax({
      dataType: 'json',
      url: "{{ route('patient.claim.photo_list', [$claim->id]) }}"})
    .done(function( data, textStatus, jqXHR ) {
      $("ul.files_container").empty();
      $("ul.files_container").html(data.photo_html);
    })
    .always(function( data, textStatus, errorThrown ) { 
      $("ul.files_container").loadingOverlay('remove');
    });
}

</script>
@endpush
