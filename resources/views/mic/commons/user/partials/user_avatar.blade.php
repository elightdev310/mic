<div class="user-avatar-settings-wrapper">
  <div class="user-avatar-image">
    {!! MICUILayoutHelper::avatarImage($currentUser) !!}
  </div>
  <div class="user-avatar-update">
    <a class="btn btn-primary" data-toggle="modal" data-target="#user-picture-modal">Change Picture</a>
  </div>
</div>

<!-- Image Modal -->
<div id="user-picture-modal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Picture</h4>
      </div>
      <div class="modal-body">
        <div class="p10">
          <input type="file" name="avatar" id="user-profile-picture">
        </div>
        <div class="upload-picture-wrap">
          <div id="upload-picture">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary crop-user-picture" >Crop and Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


@push('styles')
<link href="{{ asset('assets/plugins/croppie/croppie.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
<script src="{{ asset('assets/plugins/croppie/croppie.js') }}" type="text/javascript"></script>
<script type="text/javascript">
  $(function () {
    var $uploadCrop;
    function readFile(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
          $('#user-picture-modal').addClass('ready');
          $uploadCrop.croppie('bind', {
            url: e.target.result
          });
        }

        reader.readAsDataURL(input.files[0]);
      }
      else {
        swal("Sorry - you're browser doesn't support the FileReader API");
      }
    }
  
    $uploadCrop = $('#upload-picture').croppie({
      viewport: {
        width: 120,
        height: 120, 
        type: 'circle'
      },

      boundary: {
          width: 250,
          height: 250
      }, 
    });

    $('#user-profile-picture').on('change', function() {
      readFile(this);
    })

    $('.crop-user-picture').on('click', function (ev) {
      $uploadCrop.croppie('result', {
        type: 'canvas',
        size: 'viewport', 
        circle: false, 
      }).then(function (resp) {
        // Crop & Save
        $('#user-picture-modal .modal-body').loadingOverlay();
        console.log(resp);
        $.ajax({
            type: "POST", 
            url: "{{ route('user.save_picture.post') }}",
            dataType: 'json',
            data: {
              "_token"   : "{{ csrf_token() }}",
              "user_pic" : resp
            }
        })
        .done(function( json, textStatus, jqXHR ) {
          MICApp.UI.doAjaxAction(json); //Refresh
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
          $('#user-picture-modal .modal-body').loadingOverlay('remove');
        })
        .always(function( data, textStatus, errorThrown ) {
          
        });
      });
    });

  });
</script>
@endpush
