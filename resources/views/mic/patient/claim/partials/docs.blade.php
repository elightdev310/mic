<form action="{{ route('claim.upload.doc', [$claim->id]) }}" id="fm_dz_doc" class="dropzone-form" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
  <a id="closeDocDZ" class="closeDZ"><i class="fa fa-times"></i></a>
  <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop document here to upload</div>
</form>

<div class="">
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
        <h4 class="modal-title" id="myModalLabel"><span class="doc-file-name">Document</span></h4>
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
      <div class="modal-header clearfix">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
            <h4 class="modal-title pull-left" id="myModalLabel"><span class="doc-file-name">Document</span></h4>
            <a class="btn btn-primary m10 mb5 pull-right doc-download-link" href="#">Download</a>
      </div>
      <div class="modal-body p0">
        <div class="view-panel-section doc-panel-section panel-loading">
          <!-- View Panel -->
        </div>
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
          this.on("error", function(file) {
              
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
    var $doc_path = $(this).data('path');

    $("#view_doc_modal").find('.doc-file-name').html($doc_item.find('.doc-name a').html());
    $("#view_doc_modal").find('.view-panel-section').empty().addClass('panel-loading');

    $("#view_doc_modal").find('.doc-download-link').attr("href", $doc_path+"?download");
    
    $("#view_doc_modal").modal('show');
    $.ajax({
        dataType: 'json',
        url: view_url,
        success: function ( json ) {
          $("#view_doc_modal").find('.view-panel-section').removeClass('panel-loading');
          if (json.status=='success') {
            $("#view_doc_modal").find('.view-panel-section').html(json.panel);

            var reload_url = $('#view_doc_modal .doc-comment-section').data('reload-url');
            loadClaimDocComments(reload_url, false);
            resizeViewDocPanel();
          }
        }
    });
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
                } else if (json.status=='error') {
                  console.log(json.message);
                  if (json.action == 'reload') {
                    MICApp.UI.reloadPage();
                  }
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

    $('#access_doc_modal .modal-content').loadingOverlay();
    $.ajax({
        dataType: 'json',
        url: cda_url,
        data: $form.serialize(), 
        success: function ( json ) {
          $('#access_doc_modal .modal-content').loadingOverlay('remove');
          if (json.status=='success') {
            $('#access_doc_modal').modal('hide');
          } else {
            alert(json.error);
          }
        }
    });
  });

  $(window).on('resize', function() {
    resizeViewDocPanel();
  })
  
  // Doc Comment
  // $('#view_doc_modal').on('click', '.placeholder-text', function() {
  //   $(this).siblings('.comment-input-text').focus();
  // });

  // $('#view_doc_modal').on('focus', '.comment-input-text', function() {
  //   $(this).siblings('.placeholder-text').css('display', 'none');
  // });
  // $('#view_doc_modal').on('blur', '.comment-input-text', function() {
  //   $comment = $(this).text().trim();
  //   if ($comment == '') {
  //     $(this).siblings('.placeholder-text').css('display', 'block');
  //   } else {
  //     $(this).siblings('.placeholder-text').css('display', 'none');
  //   }
  // });

  $('#view_doc_modal').on('click', '.threaded-comment-list, threaded-comment-list a.comment-reply', function(e) {
    $(this).addClass('focus-thread');
    $(this).find('.comment-input-text').focus();
    e.preventDefault();
  });

  // Doc Comment
  $('#view_doc_modal').on('click', '.comment-post', function() {
    var $this = $(this);
    var $form = $(this).closest('.comment-form');
    var reload_url = $form.closest('.doc-comment-section').data('reload-url');
    var $comment = $form.find('.comment-input-text');

    var comment = $comment.val();

    comment = comment.trim();
    if (comment == '') {
      $comment.val('');
      return false;
    }    

    var $threaded_list = $this.closest('.threaded-comment-list');
    var thread_id = false;
    if ($threaded_list.length > 0) {
      thread_id = $threaded_list.attr('id');
    }

    $this.attr('disabled', 'disabled');
    var post_url = $form.attr('action');
    $.ajax({
        dataType: 'json',
        url: post_url,
        data: { comment: comment }, 
        success: function ( json ) {
          $this.removeAttr('disabled');
          if (json.status=='success') {
            $comment.val('');
            //$form.find('.placeholder-text').css('display', 'block');
            loadClaimDocComments(reload_url, thread_id);
          } else {
            alert(json.error);
          }
        }
    });

  });
});

function loadClaimDocs() {
  $(".claim-doc-section").loadingOverlay();
  $.ajax({
      dataType: 'json',
      url: "{{ route('claim.doc_list', [$claim->id]) }}",
      success: function ( json ) {
        $(".claim-doc-section").loadingOverlay('remove');
        $(".claim-doc-section").empty();
        $(".claim-doc-section").html(json.doc_html);
      }
  });
}

function loadClaimDocComments(reload_url, thread_id) {
  var $focus_thread = $('#'+thread_id);

  $.ajax({
      dataType: 'json',
      url: reload_url,
      success: function ( json ) {
        $(".doc-comment-section .comment-list-section").empty();
        $(".doc-comment-section .comment-list-section").html(json.comments_html);
        if (thread_id) {
          $focus_thread.addClass('focus-thread');
          $focus_thread.find('.comment-input-text').focus();
        }
      }
  });
}

function resizeViewDocPanel() {
  var w_width = $(window).width();
  var w_height = $(window).height();

  var section_height = w_height;
  if (w_width > 768) {
    section_height -= 120;
    $('#view_doc_modal').find('.doc-comment-section').css('height', section_height);
    
  } else {
    section_height -= 80;
    $('#view_doc_modal').find('.doc-comment-section').css('height', 'auto');
  }
  
  $('#view_doc_modal').find('.doc-view-section').css('height', section_height);
}

// Comment Textarea 
function textAreaAdjust(o) {
  o.style.height = "1px";
  o.style.height = (0+o.scrollHeight)+"px";
}

</script>
@endpush
