
jQuery(document).ready(function ($){

	var infobox = new InfoBox({
			pixelOffset: new google.maps.Size(-50, -65),
        	closeBoxURL: '',
        	enableEventPropagation: true
	});
        
	var mapDiv = $('#map-home-container');
	var pos = new google.maps.LatLng(12.785017871012084,105.6829833984375);
	
	 
	var map = new google.maps.Map(document.getElementById('map-home-container'), {
		center: pos,
		zoom: 7,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		draggable: true,
		scrollwheel: false,
		panControl: true,
		rotateControl: false,
		scaleControl: true,
		zoomControl: true
	});
	
	setMarkers(map, locations);

    var grayscale = [
		{
			featureType: "all",
			elementType: "all",
			stylers: [
				{ saturation: -100 }
			]
		}
	];
	
	var mapType = new google.maps.StyledMapType(grayscale, { name:"Grayscale Map" });    
	map.mapTypes.set('grayscale', mapType);
	map.setMapTypeId('grayscale');
	
	
	google.maps.event.addListener(map, "click", function() { 
		infobox.close() 	
	});
	
	// Resize Event
	jQuery(window).bind('afterresize', function(ev)
	{	
		map.panTo(pos);
	});
	
	google.maps.event.addListener(map, 'click', function( event ){
        map.setOptions({scrollwheel: true});
    });
    
    /*
mapDiv.delegate('.infoBox .close','click',function () {
		infobox.close();
	});
*/
    
	// Marker
	function createMarker(location, map){
		var marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(location[1], location[2]),
                visible: true,
                animation: google.maps.Animation.DROP,
                title: location[0],
		        zIndex: location[3],
		        html: location[4] /* ,
		        icon: "map-pin.png" this icon no longer available */
            });                
 
        google.maps.event.addListener(marker, "click", function (e) {
		     infobox.close();
		     map.panTo(marker.getPosition());
		     infobox.setContent(marker.html);
		     infobox.open(map, this);
		     
		     // if map is small
			 var iWidth = 260;
			 var iHeight = 300;
			 if((mapDiv.width / 2) < iWidth ){
				var offsetX = iWidth - (mapDiv.width / 2);
				map.panBy(offsetX,0);
			 }
			 if((mapDiv.height / 2) < iHeight ){
				var offsetY = -(iHeight - (mapDiv.height / 2));
				map.panBy(0,offsetY);
			 }
		});
		 return marker;       
	}


	function setMarkers(map, markers) {
		
		 for (var i = 0; i < markers.length; i++) {
		   createMarker(markers[i], map);
		 }
	 
	}

});// end jquery document start page

