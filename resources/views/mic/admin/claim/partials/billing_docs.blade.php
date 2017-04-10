<div class="billing-docs-panel box box-success">
  <div class="box-header">
    Billing Documents
  </div>
  <div class="box-body">
    <div class="table-responsive claim-billing-doc-section">
      @include('mic.partner.claim.partials.billing_doc_list')
    </div>
  </div>
</div>

<!-- CLAIM DOC ACCESS PANEL -->
<div class="modal fade doc-file-modal" id="upload_billing_document" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        <h4 class="modal-title"><span>Upload Billing Document</span></h4>
      </div>
      <div class="modal-body p0">
        <div class="row m0">
            <div class="col-xs-12">
              <div class="upload-file-section doc-panel-section">
                <form action="#" id="fm_dz_doc" class="dropzone-form" enctype="multipart/form-data" method="POST">
                  {{ csrf_field() }}
                  <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop document here to upload</div>
                </form>
              </div>
            </div>
        </div><!--.row-->
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
var fm_dz_doc = null;
$(function () {
  function buildUploadForm() {
    if (fm_dz_doc) {
      fm_dz_doc.destroy();
    }
    fm_dz_doc = new Dropzone("#fm_dz_doc", {
        maxFilesize: 1,
        acceptedFiles: ".doc, .docx, .pdf",
        init: function() {
            this.on("complete", function(file) {
                this.removeFile(file);
            });
            this.on("success", function(file) {
                window.location.reload(false); 
            });
        }
    });
  }

  $('.claim-billing-doc-section').on('click', '.reply-doc-link', function() {
    $url = $(this).data('url');
    $("#upload_billing_document form").attr('action', $url);
    buildUploadForm();
    $("#upload_billing_document").modal('show');
  });
});

</script>
@endpush
