
jQuery(document).ready(function ($){
	
	var directionsDisplay = new google.maps.DirectionsRenderer();
	var directionsService = new google.maps.DirectionsService();
	
	var _single_map_coords = single_map_coords.split(',');
	
	var pos = new google.maps.LatLng(_single_map_coords[0], _single_map_coords[1]);
	
	var map = new google.maps.Map(document.getElementById('single-map'), {
		center: pos,
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false,
		mapTypeControl: false,
		scaleControl: false,
		zoomControl: true,
		panControl: true,
		overviewMapControl: false
	});
	
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
	
	
	// Marker
	//var marker = new google.maps.Marker({map: map, position: pos, icon: siteurl + 'assets/images/map_pin.png'});
	var marker = new google.maps.Marker({map: map, position: pos});
	
	
	
	// Resize Event
	jQuery(window).bind('afterresize', function(ev)
	{	
		map.panTo(pos);
	});
	
	// bind direction to map.
	directionsDisplay = new google.maps.DirectionsRenderer({
	    map: map
    });
    
    google.maps.event.addListener(map, 'click', function( event ){
        
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        map.setOptions({scrollwheel: true});
        calldirecion( lat, lng );
        
    });
            
    //  get this function when click on map
    function calldirecion(lat,lng){

        var request = {
                origin: new google.maps.LatLng(lat,lng),
                destination: pos, //endDir,
                travelMode: google.maps.TravelMode.DRIVING,
                unitSystem: google.maps.UnitSystem.METRIC,
                provideRouteAlternatives: true
        };
        directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                	//directionsDisplay.setMap(map);
                	directionsDisplay.setPanel(document.getElementById('dir-container'));
	                directionsDisplay.setDirections(response);
                } else {
	                 alert('Directions failed: ' + status);
	                 return;
                }
        });
    }
    // end this function        

});// end jquery document start page