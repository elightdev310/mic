@push('scripts')
  <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
  <script>  
  // The "instanceCreated" event is fired for every editor instance created.
  CKEDITOR.on( 'instanceCreated', function ( event ) {
    var editor = event.editor,
        element = editor.element;

    // Customize editors for headers and tag list.
    // These editors do not need features like smileys, templates, iframes etc.
    if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {
      // Customize the editor configuration on "configLoaded" event,
      // which is fired after the configuration file loading and
      // execution. This makes it possible to change the
      // configuration before the editor initialization takes place.
      editor.on( 'configLoaded', function () {

        // Remove redundant plugins to make the editor simpler.
        editor.config.removePlugins = 'colorbutton,find,flash,font,' +
            'forms,iframe,image,newpage,removeformat,' +
            'smiley,specialchar,stylescombo,templates';

        // Rearrange the toolbar layout.
        editor.config.toolbarGroups = [
          { name: 'editing', groups: [ 'basicstyles', 'links' ] },
          { name: 'undo' },
          { name: 'clipboard', groups: [ 'selection', 'clipboard' ] },
          { name: 'about' }
        ];
      } );
    }
  } );
  </script>

  <script>
    $(function () {
      $('.resource-page-form .save-resource').on('click', function() {
        var title = $('.resource-page-form .page-title').val();
        if (title == '') {
          alert("Please input title field.");
          return false;
        }
        var body  = $('.resource-page-form .resource-body').html();
        $('.resource-page-form .resource-body-html').html(body);
        $('.resource-page-form').submit();
        return false;
      });
    });
  </script>
@endpush
