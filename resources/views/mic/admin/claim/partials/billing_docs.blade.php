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
              //loadClaimBillingDocs();
          });
      }
  });
});

</script>
@endpush
