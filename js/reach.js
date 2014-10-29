(function($, window, undefined){
  $(document).foundation();
  var reach = {};
  window.reach = reach;

  reach.offSidebar = function(){
  	/*** Off sidebar control ***/
  	$('.off-sidebar-control').click(function(e){
  	  e.preventDefault();
  	  var direction = $(this).hasClass('right-off-sidebar') ? 'left' : 'right';
  	  var classAnimation = 'off-move-' + direction;
  	  if($(this).hasClass('sidebar-moved')){
  	  setTimeout(function(){
  	      $('.off-sidebar,.main-container,.sticky-nav').removeClass(classAnimation);
  	    });
  	    $('.off-sidebar-control').removeClass('sidebar-moved'); 
  	  }else{
  	    setTimeout(function(){
  	      $('.off-sidebar,.main-container,.sticky-nav').addClass(classAnimation);
  	    });
  	    $('.off-sidebar-control').addClass('sidebar-moved');
  	  }
  	});
     $(".off-sidebar").niceScroll();
  }

  reach.media = function(){
    $('video, audio').each(function(){
      $(this).mediaelementplayer({
      });
    });

    var gallery = $('.dc-gallery');
    if(gallery.length == 0) return;
    // if(typeof manualInvoked == 'undefined' && $('video').length > 0) return;
    gallery.imagesLoaded(function(){
      gallery.flexslider({
        animation : "slide",
        controlNav: false,
      });
    });
  }

  $(document).ready(function(){
  	reach.offSidebar();
    reach.media();
    $('.search-button').click(function(){
      if($('.main-search-form').css('display') == 'none'){
        $('.main-search-form').slideDown();
        $('.main-search-form input').focus();
      }else{
        $('.main-search-form').slideUp();
      }
    });
  });
}( jQuery, window ));