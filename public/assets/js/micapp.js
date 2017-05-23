
var MICApp = {};

MICApp.UI = {
  refreshUserNotifyCount: function ($count) {
    $('.notifications-menu a.user-notify-link span.msg-count').html($count);
    if ($count) {
      $('.notifications-menu a.user-notify-link span.msg-count').removeClass('hidden');
    } else {
      $('.notifications-menu a.user-notify-link span.msg-count').addClass('hidden');
    }
  }, 

  doAjaxAction: function(json) {
    if (json.action == 'reload') {
      MICApp.UI.reloadPage();
    }
  }, 
  reloadPage: function(target) {
    if (typeof target == 'undefined') {
      target = '_blank';
    }

    if (target == '_blank') {
      window.location.reload(true); 
    } else if (target == '_parent') {
      parent.location.reload(true);
    }
  }

};

$(function () {
  "use strict";
  
});
