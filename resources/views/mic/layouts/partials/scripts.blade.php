<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('la-assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!-- jquery.validate + select2 -->
<script src="{{ asset('la-assets/plugins/jquery-validation/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/select2/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/plugins/exif/exif.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/dropzone/dropzone.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/stickytabs/jquery.stickytabs.js') }}" type="text/javascript"></script>
<script src="{{ asset('la-assets/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('la-assets/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script src="{{ asset('assets/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/jquery-loading-overlay/loading-overlay.js') }}" type="text/javascript"></script>


<script src="{{ asset('assets/js/micapp.js') }}" type="text/javascript"></script>

@if (session('redirect'))
<script>
(function ($) {
  $(document).ready(function() {
    @if (session('redirect') == '_parent')
      MICApp.UI.reloadPage('_parent');
    @endif
  });
}(jQuery));
</script>
@endif

@stack('scripts')
