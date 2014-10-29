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

  reach.backgroundFullScreen = function() {
    console.log($('.main-with-image').length);
    if($('.main-with-image').length > 0) {
      console.log($(window).height());
      $('.main-with-image').height($(window).height());
    }
  }

  reach.googleMap = function(){
    var $mapHolder = $('#map-holder');
    if ( $mapHolder.length ==  0) return;
    var zoomLevel = $mapHolder.data('zoom-level');
      zoomLevel = $.trim(zoomLevel) == '' ?  15 : parseInt(zoomLevel);
    var enableZoom = $mapHolder.data('enable-zoom');
      enableZoom = $.trim(enableZoom) == 'false' ? false : true;
    var markerImg = $mapHolder.data('marker-img');
    var centerCoordinate = $mapHolder.data('center-coordinate');
    var positions = $mapHolder.data('positions');
    var positionInfos = $mapHolder.data('position-infos');
    var mapType = $mapHolder.data('map-type');
    var accentColor = $mapHolder.data('accent-color');
    if($.trim(centerCoordinate) == '') return;
    var arrCenterCoordinate = centerCoordinate.split(',');
    var centerLatitude = parseFloat(arrCenterCoordinate[0]);
    var centerLongitude = parseFloat(arrCenterCoordinate[1]);

    var arrPositions = positions.split(';');
    var arrPositionCoordinates = [];
    for(var i = 0; i< arrPositions.length; i++){
      var arrPoint = arrPositions[i].split(',');
      var coordinate = {};
      coordinate.lat = parseFloat(arrPoint[0]);
      coordinate.lng = parseFloat(arrPoint[1]);
      arrPositionCoordinates.push(coordinate);
    }

    var arrPositionInfos= [];
    if($.trim(positionInfos) != ''){
      arrPositionInfos =  positionInfos.split('#;#'); 
    }
    var infoWindows = [];

    var animationDelay = 0;
    var enableAnimation;
    if(  $(window).width() > 690 ) { animationDelay = 180; enableAnimation = google.maps.Animation.BOUNCE } else { enableAnimation = null; }
    var map;
    function initialize() {

      var styles = [
          {
            stylers: [
              { hue: accentColor },
              { saturation: -10 }
            ]
          },{
            featureType: "road",
            elementType: "geometry",
            stylers: [
              { lightness: 100 },
              { visibility: "simplified" }
            ]
          },{
            featureType: "road",
            elementType: "labels",
            stylers: [
              { visibility: "off" }
            ]
          }
        ];

        // Create a new StyledMapType object, passing it the array of styles,
        // as well as the name to be displayed on the map type control.
        var styledMap = new google.maps.StyledMapType(styles,
          {name: "Styled Map"});


        var mapOptions = {
          zoom: zoomLevel,
          scrollwheel: false,
            panControl: false,
            mapTypeControl: false,
          scaleControl: false,
          streetViewControl: false,
          mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
          },
        // mapTypeId: [google.maps.MapTypeId.ROADMAP,'map_style'],
          zoomControl:enableZoom,
          zoomControlOptions: {
              style: google.maps.ZoomControlStyle.LARGE,
              position: google.maps.ControlPosition.LEFT_CENTER
            },
          center: new google.maps.LatLng(centerLatitude, centerLongitude)
      }
        map = new google.maps.Map(document.getElementById('map-holder'),
          mapOptions);

        if(mapType == 'styled'){
          map.mapTypes.set('map_style', styledMap);
        map.setMapTypeId('map_style');
      }

        google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
    
        //don't start the animation until the marker image is loaded if there is one
        if(markerImg.length > 0) {
          var markerImgLoad = new Image();
          markerImgLoad.src = markerImg;
          
          $(markerImgLoad).load(function(){
             setMarkers(map);
          });
        }
        else {
          setMarkers(map);
        }
        });
        // setMarkers(map);
    }

     function setMarkers(map) {
      for (var i = 1; i <= arrPositionCoordinates.length; i++) {  
        
        (function(i) {
          setTimeout(function() {
          
              var marker = new google.maps.Marker({
                position: new google.maps.LatLng(arrPositionCoordinates[i-1].lat, arrPositionCoordinates[i-1].lng),
                map: map,
            infoWindowIndex : i - 1,
            animation: enableAnimation,
            icon: markerImg,
            optimized: false
              });
            
            setTimeout(function(){marker.setAnimation(null);},200);
            if(arrPositionInfos.length != 0 && arrPositionInfos.length <= i){
                //infowindows 
                var infowindow = new google.maps.InfoWindow({
                  content: arrPositionInfos[i-1],
                maxWidth: 300
              });
              
              infoWindows.push(infowindow);
                
                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                  return function() {
                    infoWindows[this.infoWindowIndex].open(map, this);
                  }
                  
                })(marker, i));
            }
            
               }, i * animationDelay);
               
               
           }(i));
           

       }//end for loop
    }//setMarker
    initialize();
    // google.maps.event.addDomListener(window, 'load', initialize);
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
    reach.googleMap();
    reach.backgroundFullScreen();
  });
}( jQuery, window ));