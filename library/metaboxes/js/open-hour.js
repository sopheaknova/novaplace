jQuery( document ).ready( function( $ ) {

	$( ':input.rwmb-time' ).each( rwmb_update_time_picker );
	$( '.rwmb-input' ).on( 'clone', ':input.rwmb-time', rwmb_update_time_picker );
	
	function rwmb_update_time_picker()
	{
		$( ':input.rwmb-time' ).timepicker( { 'scrollDefaultNow': true } );
	}
	
	
	var $open_hours = $('#open-hours'),
		$time_line  = $('.time-line');
				
	// Fix for sortable jumping "bug"
	function adjustContainerHeight() {

		$open_hours.height('auto').height( $('#open-hours').height() );

	}
	adjustContainerHeight();	

	// Add slide
	$('#add-time-line').click(function( e ) {

		$open_hours.height('auto');

		var $cloneElem = $('.time-line').last().clone();

		$cloneElem.find('select').val('').end()
				  .find('input[type=text]').val('').end()
				  .insertAfter( $('.time-line').last() );

		adjustContainerHeight();
		rwmb_update_time_picker();

		e.preventDefault();
	});

	// Delete slide
	$open_hours.delegate('.remove-hour', 'click', function( e ) {

		if( $open_hours.children('.time-line').length == 1 ) {

			$time_line.find('input[type=text]').val('').end()
				  .find('input[type=hidden]').val('').end()
				  .find('select').val('').end();

			alert('You need to have at least 1 slide!');

		} else {

			$(this).parents('.time-line').remove();
			adjustContainerHeight();

		}

		e.preventDefault();
	});

});