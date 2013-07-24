jQuery( document ).ready( function($)  {

	var $contact_infos = $('#contact-infos'),
		$comm_line  = $('.comm-line');
				
	// Fix for sortable jumping "bug"
	function adjustContainerHeight() {

		$contact_infos.height('auto').height( $('#contact_infos').height() );

	}
	adjustContainerHeight();	

	// Add slide
	$('#add-comm-line').click(function( e ) {

		$contact_infos.height('auto');

		var $cloneElem = $('.comm-line').last().clone();

		$cloneElem.find('select').val('').end()
				  .find('input[type=text]').val('').end()
				  .insertAfter( $('.comm-line').last() );

		adjustContainerHeight();

		e.preventDefault();
	});

	// Delete slide
	$contact_infos.delegate('.remove-comm-line', 'click', function( e ) {
		
		if( $contact_infos.children('.comm-line').length == 1 ) {

			$comm_line.find('input[type=text]').val('').end()
				  .find('input[type=hidden]').val('').end()
				  .find('select').val('').end();

			adjustCommTypes( $(this) );
			
			alert('You need to have at least 1 slide!');
			

		} else {

			$(this).parents('.comm-line').remove();
			adjustContainerHeight();

		}

		e.preventDefault();
	});
	
	
	// Button type selector
	function adjustCommTypes( selector ) {

		var $comm_value = selector.parents('tr');

		$comm_value.find('input[type=text]').attr('placeholder', '023 000 000');

		switch ( selector.val() ) {
			case 'mobile': $comm_value.find('input[type=text]').attr('placeholder', 'Mobile phone number'); break;
			case 'fax': $comm_value.find('input[type=text]').attr('placeholder', 'Fax number'); break;
			case 'e-mail': $comm_value.find('input[type=text]').attr('placeholder', 'E-mail address'); break;
			case 'website': $comm_value.find('input[type=text]').attr('placeholder', 'Website address'); break;
			case 'e-mail': $comm_value.find('input[type=text]').attr('placeholder', 'E-mail address'); break;
			case 'swift': $comm_value.find('input[type=text]').attr('placeholder', 'SWIFT Code'); break;
			case 'pobox': $comm_value.find('input[type=text]').attr('placeholder', 'P.O. Box number'); break;
			default : $comm_value.find('input[type=text]').attr('placeholder', 'Telephone number'); break;
		} 

		adjustContainerHeight();

	}
	
	// Setup on change
	$contact_infos.delegate('select[name="comm-type[]"]', 'change', function() {

		var $this = $(this);
		
		adjustCommTypes( $this )

	});
	
	// Setup on page load
	$contact_infos.find('select[name="comm-type[]"]').each(function( i ) {

		$contact_infos.find('select[name="comm-type[]"]').trigger('change');

	});

	// Sortable slides
	$contact_infos.sortable({
		handle      : '.inside',
		placeholder : 'sortable-placeholder',
		sort        : function( event, ui ) {
			$('.sortable-placeholder').height( $(this).find('.ui-sortable-helper').height() );
		},
		tolerance   :'pointer'
	});

});