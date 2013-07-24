jQuery(document).ready(function($) {
  
	//Magnific Popup for Project Page
	$('#listing-gallery ul').magnificPopup({
	  	delegate: 'li a',
	  	type: 'image',
	  	image: {
	  		 titleSrc: ''
	  	},
	  	gallery: { 
	  		enabled:true
	  	},
		removalDelay: 200,
	  	mainClass: 'pxg-slide-bottom'
	});
  
});  