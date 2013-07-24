jQuery( document ).ready( function( $ ) {

	var $social_network = $('#social-network'),
		$social_link  = $('.social-link');
				
	// Fix for sortable jumping "bug"
	function adjustContainerHeight() {

		$social_network.height('auto').height( $('#social-network').height() );

	}
	adjustContainerHeight();	

	// Add slide
	$('#add-social-link').click(function( e ) {

		$social_network.height('auto');

		var $cloneElem = $('.social-link').last().clone();

		$cloneElem.find('select').val('').end()
				  .find('input[type=text]').val('').end()
				  .insertAfter( $('.social-link').last() );

		adjustContainerHeight();

		e.preventDefault();
	});

	// Delete slide
	$social_network.delegate('.remove-social-link', 'click', function( e ) {

		if( $social_network.children('.social-link').length == 1 ) {

			$social_link.find('input[type=text]').val('').end()
				  .find('input[type=hidden]').val('').end()
				  .find('select').val('').end();
			
			adjustSocialTypes( $(this) );
				  
			alert('You need to have at least 1 slide!');

		} else {

			$(this).parents('.social-link').remove();
			adjustContainerHeight();

		}

		e.preventDefault();
	});
	
	// Button Social selector
	function adjustSocialTypes( selector ) {

		var $social_value = selector.parents('tr');

		$social_value.find('input[type=text]').attr('placeholder', 'Google+ page url');

		switch ( selector.val() ) {
			case 'twitter': $social_value.find('input[type=text]').attr('placeholder', 'Twitter page url'); break;
			case 'facebook': $social_value.find('input[type=text]').attr('placeholder', 'Facebook page url'); break;
			case 'linkedin': $social_value.find('input[type=text]').attr('placeholder', 'LinkedIn page url'); break;
			default : $social_value.find('input[type=text]').attr('placeholder', 'Google+ page url'); break;
		} 

		adjustContainerHeight();

	}
	
	// Setup on change
	$social_network.delegate('select[name="social-select[]"]', 'change', function() {

		var $this = $(this);
		
		adjustSocialTypes( $this )

	});
	
	// Setup on page load
	$social_network.find('select[name="social-select[]"]').each(function( i ) {

		$social_network.find('select[name="social-select[]"]').trigger('change');

	});

});