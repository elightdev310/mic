$(function () {
  $(document).ready(function() {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });

    $(window).on('resize', function() {
      var _height = window.innerHeight;
      if (_height < $('.content').height()) {
        _height = $('.content').height();
      }

      $('.auth-mic-left-bg').height(_height);
    });

    $(window).trigger('resize');
    
  });
});
