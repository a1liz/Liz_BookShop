(function($) {
  'use strict';

  $(function() {
    var $fullText = $('.admin-fullText');
    $('#admin-fullscreen').on('click', function() {
      $.AMUI.fullscreen.toggle();
    });

    $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function() {
      $fullText.text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
    });
  });
})(jQuery);

$("#am-heart-active").click(function(){
  $("#am-heart-active").attr("src","assets/i/heart-small-active.png");
  $("#article-follow-users").html('101');
});

$("#user-follow-icon").click(function(){
  $("#user-follow-icon").attr("src","assets/i/heart-big-active.png");
  $("#user-op-follow").html('已关注');
});
/*查找文章*/
$("#am-search-button").click(function(){
  $.ajax({
    url:'/index.php/api/Archive/find',
    type:'post',
    data:{
      Title:document.getElementById("am-searchbox").value
    },
    success:function(){
    }
  });
});

/*加载文章列表*/
$(function(){
  
});