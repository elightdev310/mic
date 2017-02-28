<form action="{{ route('claim.upload.doc', [$claim->id]) }}" id="fm_dz_doc" class="dropzone-form" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
  <a id="closeDocDZ" class="closeDZ"><i class="fa fa-times"></i></a>
  <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop document here to upload</div>
</form>

<div class="box box-success">
  <!--<div class="box-header"></div>-->
  <div class="box-body">
    <div class="table-responsive claim-doc-section">
      @include('mic.patient.claim.partials.doc_list')
    </div>
  </div>
</div>


@if ($user->can(config('mic.permission.micadmin_panel')))
<!-- CLAIM DOC ACCESS PANEL -->
<div class="modal fade doc-file-modal" id="access_doc_modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Name: <span class="doc-file-name">Document</span></h4>
      </div>
      <div class="modal-body p0">
        <div class="row m0">
            <div class="col-xs-12">
              <div class="access-panel-section doc-panel-section panel-loading">
                <!-- Access Panel -->
              </div>
            </div>
        </div><!--.row-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary submit-btn">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endif

<!-- CLAIM DOC VIEW PANEL -->
<div class="modal fade doc-file-modal" id="view_doc_modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title" id="myModalLabel">Name: <span class="doc-file-name">Document</span></h4>
      </div>
      <div class="modal-body p0">
        <div class="view-panel-section doc-panel-section panel-loading">
          <!-- View Panel -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary submit-btn">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




@push('scripts')
<script>
var fm_dz_doc = null;
$(function () {
  fm_dz_doc = new Dropzone("#fm_dz_doc", {
      maxFilesize: 1,
      acceptedFiles: ".doc, .docx, .pdf",
      init: function() {
          this.on("complete", function(file) {
              this.removeFile(file);
          });
          this.on("success", function(file) {
              loadClaimDocs();
          });
      }
  });
  $("#fm_dz_doc").slideUp();
  $("#AddNewDoc").on("click", function() {
      $("#fm_dz_doc").slideDown();
  });
  $("#closeDocDZ").on("click", function() {
      $("#fm_dz_doc").slideUp();
  });

  // View Link
  $('.claim-doc-section').on('click', 'a.view-doc-link', function() {
    var view_url = $(this).data('url');
    var $doc_item = $(this).closest('.claim-doc-item');
    $("#view_doc_modal").find('.doc-file-name').html($doc_item.find('.doc-name').html());
    $("#view_doc_modal").find('.view-panel-section').empty().addClass('panel-loading');
    $("#view_doc_modal").modal('show');
    // $.ajax({
    //     dataType: 'json',
    //     url: access_url,
    //     success: function ( json ) {
    //       $("#access_doc_modal").find('.access-panel-section').removeClass('panel-loading');
    //       if (json.status=='success') {
    //         $("#access_doc_modal").find('.access-panel-section').html(json.panel);
    //       }
    //     }
    // });
  });

  // Access Link
  $('.claim-doc-section').on('click', 'a.access-doc-link', function() {
    var access_url = $(this).data('url');
    var $doc_item = $(this).closest('.claim-doc-item');
    $("#access_doc_modal").find('.doc-file-name').html($doc_item.find('.doc-name').html());
    $("#access_doc_modal").find('.access-panel-section').empty().addClass('panel-loading');
    $("#access_doc_modal").modal('show');
    $.ajax({
        dataType: 'json',
        url: access_url,
        success: function ( json ) {
          $("#access_doc_modal").find('.access-panel-section').removeClass('panel-loading');
          if (json.status=='success') {
            $("#access_doc_modal").find('.access-panel-section').html(json.panel);
          }
        }
    });
  });

  // Delete Link
  $('.claim-doc-section').on('click', 'a.delete-doc-link', function() {
    var delete_url = $(this).data('url');
    var $doc_item = $(this).closest('.claim-doc-item');
    bootbox.confirm({
      message: "<p>Are you sure to delete document?</p>", 
      callback: function (result) {
        if (result) {
          $.ajax({
              dataType: 'json',
              url: delete_url,
              success: function ( json ) {
                if (json.status=='success') {
                  $doc_item.remove();
                }
              }
          });
        }
      }
    });
  });

  // Submit CDA Form
  $('#access_doc_modal').on('click', '.submit-btn', function() {
    var $form = $('#cda_frm');
    var cda_url = $form.attr('action');
    $.ajax({
        dataType: 'json',
        url: cda_url,
        data: $form.serialize(), 
        success: function ( json ) {
          if (json.status=='success') {
            $('#access_doc_modal').modal('hide');
          } else {
            alert(json.error);
          }
        }
    });
  });
  
});

function loadClaimDocs() {
  $.ajax({
      dataType: 'json',
      url: "{{ route('claim.doc_list', [$claim->id]) }}",
      success: function ( json ) {
        $(".claim-doc-section").empty();
        $(".claim-doc-section").html(json.doc_html);
      }
  });
}

</script>
@endpush
