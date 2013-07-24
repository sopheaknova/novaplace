jQuery( document ).ready( function($)  {

	var $repeater  = $('.repeater');
				
	// Fix for sortable jumping "bug"
	function adjustContainerHeight() {

		$slider.height('auto').height( $('#slider-slides').height() );

	}
	//adjustContainerHeight();	

	// Add slide
	$('.add-element').click(function( e ) {

		//$slider.height('auto');
		
		var $cloneElem = $('.repeater').last().clone();
		$cloneElem.find('input[type=text]').val('').end()
				.insertAfter( $('.repeater').last() );

		//adjustContainerHeight();

		e.preventDefault();
	});


});