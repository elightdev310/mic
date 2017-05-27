<div class="billing-docs-panel">
  <div class="box-header">
    <div class="row">
      <div class="col-sm-8"><h3>Billing Documents</h3></div>
      <div class="col-sm-4">
        <button id="AddNewDoc" class="btn btn-primary pull-right mt15">Add New Document</button>
      </div>
    </div>
  </div>
  <div class="box-body">
    <form action="{{ route('claim.upload.billing_doc', [$claim->id]) }}" id="fm_dz_doc" class="dropzone-form" enctype="multipart/form-data" method="POST">
      {{ csrf_field() }}
      <a id="closeDocDZ" class="closeDZ"><i class="fa fa-times"></i></a>
      <div class="dz-message"><i class="fa fa-cloud-upload"></i><br>Drop Billing document here to upload <br>Document should be less than 10M.</div>
    </form>
    <div class="table-responsive claim-billing-doc-section">
      @include('mic.partner.claim.partials.billing_doc_list')
    </div>
  </div>
</div>

@push('scripts')
<script>
var fm_dz_doc = null;
$(function () {
  fm_dz_doc = new Dropzone("#fm_dz_doc", {
      maxFilesize: 10,  // MB
      acceptedFiles: ".doc, .docx, .pdf",
      init: function() {
          this.on("complete", function(file) {
              this.removeFile(file);
          });
          this.on("success", function(file) {
              loadClaimBillingDocs();
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

});

function loadClaimBillingDocs() {
  $(".claim-billing-doc-section").loadingOverlay();
  $.ajax({
      dataType: 'json',
      url: "{{ route('claim.billing_doc_list', [$claim->id]) }}",
      success: function ( json ) {
        $(".claim-billing-doc-section").loadingOverlay('remove');
        $(".claim-billing-doc-section").empty();
        $(".claim-billing-doc-section").html(json.doc_html);
      }
  });
}
</script>
@endpush
