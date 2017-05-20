$(function () {
  $(document).ready(function() {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $(window).on('resize', function() {
      var _width  = window.innerWidth;
      var _height = window.innerHeight;
      if (_height < $('.content').height()) {
        _height = $('.content').height();
      }

      minHeight = _width*0.43 + 350;
      if (_height < minHeight) {
        _height = minHeight;
      }

      $('.auth-mic-left-bg').height(_height);
    });

    $(window).trigger('resize');
    
  });
});
