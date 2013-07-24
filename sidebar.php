<?php global $smof_data , $post; ?>

<aside id="sidebar">
	<?php if ( $smof_data['show_gallery'] ) : ?>
	<div id="listing-gallery">
	<h3><?php echo _e( 'Photo Gallery', 'spthemem' ); ?></h3>
	<ul>
	<?php 
	$lst_galleries = rwmb_meta ( 'sp_listing_gallery', 'type=image&size=sp-large' );
	foreach ( $lst_galleries as $image ) { 
		echo "<li><a href='{$image['full_url']}'><img src='{$image['url']}' alt='{$image['alt']}' /></a></li>";	
	}
	?>	
	</ul>
	</div><!-- end #listing-gallery -->
	<?php endif; ?>
</aside>