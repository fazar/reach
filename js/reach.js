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
  }

  $(document).ready(function(){
  	reach.offSidebar();
     $(".off-sidebar").niceScroll();
  });
}( jQuery, window ));