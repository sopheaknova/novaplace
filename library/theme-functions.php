<?php

/* ---------------------------------------------------------------------- */
/*	Show main and footer navigation
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_top_navigation')) {

	function sp_top_navigation() {
		
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container_class'	 => 'top-menu',
				'theme_location' => 'top_nav',
				'fallback_cb' => 'sp_top_nav_fallback'
				) );
		else
			sp_top_nav_fallback();	
	}
}

if (!function_exists('sp_top_nav_fallback')) {
	
	function sp_top_nav_fallback() {
    	
		$menu_html .= '<ul class="top-menu">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

if( !function_exists('sp_main_navigation')) {

	function sp_main_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'main-menu',
				'theme_location' => 'primary_nav',
				'fallback_cb' => 'sp_main_nav_fallback'
				) );
		else
			sp_main_nav_fallback();	
	}
}

if (!function_exists('sp_main_nav_fallback')) {
	
	function sp_main_nav_fallback() {
    	
		$menu_html .= '<ul class="main-menu">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Main menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}

if (!function_exists('sp_footer_navigation')){
	
	function sp_footer_navigation() {
		
		// set default main menu if wp_nav_menu not active
		if ( function_exists ( 'wp_nav_menu' ) )
			wp_nav_menu( array(
				'container'      => false,
				'menu_class'	 => 'footer-nav',
				'after'		 	 => ' &nbsp;',
				'theme_location' => 'footer_nav',
				'fallback_cb'	 => 'sp_footer_nav_fallback'
				));	
		else
			sp_footer_nav_fallback();	
	}
}

if (!function_exists('sp_footer_nav_fallback')) {
	
	function sp_footer_nav_fallback() {
    	
		$menu_html .= '<ul class="footer-nav">';
		$menu_html .= '<li><a href="'.admin_url('nav-menus.php').'">'.esc_html__('Add Footer menu', 'sptheme').'</a></li>';
		$menu_html .= '</ul>';
		echo $menu_html;
		
	}
	
}


/* ---------------------------------------------------------------------- */
/*	Show the post content
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_content')) {

	function sp_post_content() {

		global $smof_data, $post, $user_ID;

		get_currentuserinfo();
		
		$output = '';
		
		if ( is_singular() ) {

			$content = get_the_content();
			//$content = preg_replace('/(<)([img])(\w+)([^>]*>)/', '', $content);
			$content = apply_filters( 'the_content', $content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			$output .= $content;

			$output .= wp_link_pages( array( 'echo' => false ) );

		} else {
			
			if ( $smof_data[ 'blog_display' ] !== 'none' ) {
				//$output .= '<article class="item-list">';
				if ( $smof_data[ 'blog_display' ] == 'thumbnail' ) {
						if ( function_exists("has_post_thumbnail") && has_post_thumbnail() ) :	
						$output .= '<div class="post-thumbnail">';
						$output .= '<a href="'.get_permalink().'" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark">';
						$output .= '<img src="' . sp_post_image('sp-medium') . '" width="200" height="150" /></a>';
						//$output .= sp_get_score( true ); // show rate ui
						$output .= '</div>';
					endif;
				}
				$output .= sp_excerpt_string_length($smof_data[ 'archive_char_length' ]);
				if (get_post_format($post->ID) !== 'video')
					$output .= '<a href="'.get_permalink().'" class="learn-more">' . __( 'Learn more', 'sptheme' ) . '</a>';
				
				//$output .= '</article>';
			}
		}
		
		return $output;

	}

}

/* ---------------------------------------------------------------------- */
/*	Show the post meta (permalink, date, tags, categories & comments)
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_meta')) {

	function sp_post_meta() {

		global $smof_data, $post, $user_ID;
		
		if ($smof_data[ 'post_meta' ]) :
		if( $smof_data[ 'posted_by' ] )
			$output = '<span>' . __('Posted by:', 'sptheme') . '</span><span class="title"><a href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . sprintf( esc_attr__( 'View all posts by %s', 'sptheme' ), get_the_author() . '">' . get_the_author()) . '</a></span><span>&mdash;</span>';
			
		if( $smof_data[ 'post_date' ] )
			$output .=  sp_posted_on() . '<span>&mdash;</span>';
		
		if( $smof_data[ 'post_categories' ] )	
			$output .= '<span class="post-categories">' . __(' in: ', 'sptheme') . ' ' . get_the_category_list(', ') . '</span><span>&mdash;</span>';
		
		if ( comments_open() || ( '0' != get_comments_number() && !comments_open() ) ) :
		if( $smof_data[ 'post_comments' ] )	
			$output .= '<span class="post-comments">' . get_comments_popup_link( __( 'Leave a comment', 'sptheme' ), __( '1 Comment', 'sptheme' ), __( '% Comments', 'sptheme' ) ) . '</span><span>&mdash;</span>';
		endif; // end show/hide comments	
			
			
		if( $smof_data[ 'post_views' ] )	
			$output .= sp_post_read();
			
		if( user_can( $user_ID, 'edit_posts' ) )
			$output .= '<span>&mdash;</span><span class="edit-link"><a title="' . __('Edit Post', 'sptheme') . '" href="' . get_edit_post_link( $post->ID ) . '">' . __('Edit', 'sptheme') . '</a></span>';	
		
		return $output;
		
		else: 
		
		return false;
		
		endif;
	}

}

/* ---------------------------------------------------------------------- */
/*	Get Post image
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_post_image')) {

	function sp_post_image($size = 'thumbnail'){
		global $post;
		$image = '';
		
		//get the post thumbnail;
		$image_id = get_post_thumbnail_id($post->ID);
		$image = wp_get_attachment_image_src($image_id, $size);
		$image = $image[0];
		if ($image) return $image;
		
		//if the post is video post and haven't a feutre image
		$post_type = get_post_format($post->ID);
		$vtype = sp_get_custom_field( 'sp_video_type', $post->ID );
		$vId = get_post_meta($post->ID, 'sp_video_id', true);

		if($post_type == 'video') {
						if($vtype == 'youtube') {
						  $image = 'http://img.youtube.com/vi/'.$vId.'/0.jpg';
						} elseif ($vtype == 'vimeo') {
						$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$vId.php"));
						  $image = $hash[0]['thumbnail_large'];
						} elseif ($vtype == 'daily') {
						  $image = 'http://www.dailymotion.com/thumbnail/video/'.$vId;
						}
				}
		if($post_type == 'audio') {
			$image = SP_BASE_URL . 'images/placeholder/sound-post-thumb.gif'; // use placeholder image or sound icon
		}		
						
		if ($image) return $image;
		//If there is still no image, get the first image from the post
		return sp_get_first_image();
	}
		

}

/* ---------------------------------------------------------------------- */
/*	Get first image in post
/* ---------------------------------------------------------------------- */
if( !function_exists('sp_get_first_image')) {
	
	function sp_get_first_image() {
		global $post, $posts;
		$first_img = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches[1][0];
		
		return $first_img;
	}
}


/* ---------------------------------------------------------------------- */
/*	Strip string by words count
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_string_length' ) ) {
	function sp_string_length( $str, $words = 20, $more = '' ) {
		if ( ! $str )
			return;

		$str = preg_replace( '/\s\s+/', ' ', $str );
		$str = explode( ' ', $str, ( $words + 1 ) );

		if ( count( $str ) > $words ) {
			array_pop( $str );
			$out = implode( ' ', $str ) . $more;
		} else {
			$out = implode( ' ', $str );
		}

		return $out;
	}
} // sp_string_length


/* ---------------------------------------------------------------------- */
/*	Sets the post excerpt length by string length
/* ---------------------------------------------------------------------- */
function sp_excerpt_string_length( $str_length = 130 ) {
	global $post;
		//$excerpt = ( $str_decode ) ? utf8_decode($post->post_excerpt) : $post->post_excerpt;
		$excerpt = $post->post_excerpt;
		if($excerpt==''){
		$excerpt = get_the_content();
		}
		
		echo '<p>' . wp_html_excerpt($excerpt,$str_length) . '...</p>';
}

/* ---------------------------------------------------------------------- */
/*	Get Og type for facebook, twitter & Google+ share
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_cp_listing' ) ) {

	function sp_og_image() {
		global $post ;
			
		$description = stripslashes(strip_tags($post->post_content));
		$description = str_replace(array('\'', '"'), '', $description);
		
		
		if (is_home() || is_front_page()) {
			$post_thumb = SP_ASSETS_THEME . 'images/logo.png';
	        echo '<meta property="og:image" content="'. $post_thumb . '"/>'."\n";
	        echo '<meta property="og:type" content="website"/> '."\n";
	        echo '<meta property="og:url" content="'. get_site_url() .'"/>'."\n";
	    }
	    if (is_singular()) {  
	    	$post_thumb = sp_post_image('medium') ;
	        echo '<meta property="og:title" content="'. get_the_title(). '"/>'."\n";
	        echo '<meta property="og:description" content="'. sp_string_length($description, 50) .'"/>'."\n";
	        echo '<meta property="og:type" content="article"/>'."\n";
	    	echo '<meta property="og:image" content="'. $post_thumb .'" />'."\n";     
	        echo '<meta property="og:site_name" content="'. get_bloginfo('name').'"/>'."\n";
	        echo '<meta property="og:url" content="'. get_permalink().'"/>'."\n";
	    }
	}

}

/* ---------------------------------------------------------------------- */
/*	Show each post type
/* ---------------------------------------------------------------------- */

if ( ! function_exists( 'sp_show_cp_posttype' ) ) {

	function sp_show_cp_posttype($post_type = null, $post_num = '5') {
		
		$args = array( 'post_type' => $post_type, 'posts_per_page' => $post_num );
		$listing = new WP_Query( $args );
		
		$output = '<div class="listings">';
		if ($listing->have_posts()) :
			while ( $listing->have_posts() ) : $listing->the_post();
			
				$post_meta_keys = get_post_meta( get_the_ID() );
				
				if ($post_type == 'sp_listing')
					$output .= sp_render_listing( $post_meta_keys, 'sp-medium' );
				if($post_type == 'sp_events')
					$output .= sp_render_event( $post_meta_keys, 'sp-medium' );	
				
			endwhile;	
		
		else:
			$output .= '<article id="post-0" class="post no-results not-found">';
			$output .= '<h3>' . __( 'It seems we can&rsquo;t find what you&rsquo;re looking for...', 'sptheme' ) . '</h3>';
			$output .= '</article><!-- end .hentry -->';
		
		endif;
		$output .= '</div><!-- end .listings -->';
		wp_reset_postdata();
		
		
		
		return $output;
	}
		
}

/* ---------------------------------------------------------------------- */
/*	Render post type html 
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_render_listing' ) ) {

	function sp_render_listing( $post_meta_keys, $thum_size = 'sp-medium') {
		
		global $post;
	
		if ( is_singular('sp_listing') ) {
		
			$output = sp_listing_detail( $post_meta_keys, $thum_size );
			
		} else {
		
			$output = sp_listing_summary( $post_meta_keys, $thum_size );
			
		}
		
		return $output;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Render Events
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_render_event' ) ) {

	function sp_render_event( $post_meta_keys, $thum_size = 'sp-medium') {
		
		global $post;
	
		if ( is_singular('sp_events') ) {
		
			$output = sp_event_detail( $post_meta_keys, $thum_size );
			
		} else {
		
			$output = sp_event_summary( $post_meta_keys, $thum_size );
			
		}
		
		return $output;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Render Listing summary
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_listing_summary' ) ) {

	function sp_listing_summary( $post_meta_keys, $thum_size ) {
	
		global $post;
		
		$tel_arr = array();
		$contact_infos = maybe_unserialize($post_meta_keys['sp_comm_line'][0]);
		
		$output = '<article class="listing-' . get_the_ID() . '">';
		$output .= '<div class="one_third"><a href="' . get_permalink() . '" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark"><img src="' . sp_post_image($thum_size) . '" /></a></div>'; 
		$output .= '<div class="two_third last">';
		$output .= '<h3><a href="' . get_permalink() . '" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
		$output .= sp_address_listing($post_meta_keys);
		$output .= '<span class="post-categories">' . get_the_term_list( $post->ID, 'listing-type', 'In: ', ', ', '') . '</span>';
		$output .= '<ul class="comm"><li>';
		$output .= '<span class="attr">' . get_the_term_list( $post->ID, 'listing-location', '', ', ', '') . '</span>';
		foreach ($contact_infos as $line) :
			if ( $line['comm-type'] == 'tel') {
				array_push( $tel_arr, $line['comm-value'] );	
			}
		endforeach;
		$output .= '<span class="value">' . implode('/', $tel_arr) . '</span>';
		$output .= '</li></ul>';
		$output .= '</div><!-- end .two_third .last -->';
		$output .= '</article>';
			
		return $output;	
	}
	
}	

/* ---------------------------------------------------------------------- */
/*	Render Listing Detail
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_listing_detail' ) ) {

	function sp_listing_detail( $post_meta_keys, $thum_size ) {
	
		global $post, $smof_data;
	
		$output = '<article class="listing-' . get_the_ID() . '">';
		$output .= '<div class="one_third">'; 
		
		if ( sp_post_image($thum_size) ) :
		$output .= '<img src="' . sp_post_image($thum_size) . '" />'; 
		endif;
		
		$output .= '<div class="social-links"><span>' . __( 'Join us on:', 'sptheme' ) . '</span>' . sp_get_social_networking( 'yes', '16', $post_meta_keys ) . '</div><!-- end .social-links -->';
		
		$output .= '<div class="categories">';
		$output .= get_the_term_list( $post->ID, 'listing-type', '<span>', '</span><span>', '</span>');
		$output .= '</div><!-- end .categories -->';
				
		$output .= '</div><!-- end .one_third -->';
		
		$output .= '<div class="two_third last">';
		
		$output .= '<div id="listing-info">';
		$output .= '<h2 class="listing-name">' . get_the_title() . '</h2>';
		$output .= sp_address_listing($post_meta_keys);
		$output .= sp_get_comm_line($post_meta_keys);
		
		if ( $smof_data['show_open_hour'] ) :
		$output .= '<h5>' . __( 'Opening hours', 'sptheme' ) . '</h5>';
		$output .= sp_get_opening_attr($post_meta_keys);
		endif;
		
		$output .= '</div><!-- end #listing-info -->';
		
		if( $smof_data[ 'share_post' ] ) :
		$output .= '<span class="social-share">' . __( 'Share on: ', 'spthemem' ) . '</span>';
		$output .= sp_social_share();
		endif;
		
		$output .= '</div><!-- end .two_third .last -->';
		
		$output .= '<div class="clear"></div>';
		
		if ( $smof_data['show_listing_map'] ) :
		$output .= sp_single_map('listing-location');
		endif;
		$output .= sp_single_description();
		
		$output .= '</article>';
			
		return $output;	
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Render Listing summary
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_event_summary' ) ) {

	function sp_event_summary( $post_meta_keys, $thum_size ) {
	
		global $post;
		
		$tel_arr = array();
		$contact_infos = maybe_unserialize($post_meta_keys['sp_comm_line'][0]);
		
		$event_start = explode(' ', $post_meta_keys['sp_evt_start'][0]);
		$event_end = explode(' ', $post_meta_keys['sp_evt_end'][0]);
		
		$output = '<article class="listing-' . get_the_ID() . '">';
		$output .= '<div class="one_third"><a href="' . get_permalink() . '" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark"><img src="' . sp_post_image($thum_size) . '" /></a></div>'; 
		$output .= '<div class="two_third last">';
		$output .= '<h3><a href="' . get_permalink() . '" title="' . __( 'Permalink to ', 'sptheme' ) . get_the_title() . '" rel="bookmark">' . get_the_title() . '</a></h3>';
		$output .= sp_address_listing($post_meta_keys);
		
		$output .= '<div class="post-categories">' . get_the_term_list( $post->ID, 'event-type', 'In: ', ', ', '') . '</div>';
		
		$output .= '<ul class="comm">';
		$output .= '<li><span class="attr">' . __('Date: ', 'sptheme') . '</span><span class="value">' . date('F j, Y', strtotime($event_start[0])) . __(' to ', 'sptheme') . date('F j, Y', strtotime($event_end[0])) . '</span></li>';
		//$output .= '<li><span class="attr">' . __('Time: ', 'sptheme') . '</span><span class="value">' . $event_start[1] . ' to ' . $event_end[1] . '</span></li>';
		$output .= '<li>';
		$output .= '<span class="attr">' . get_the_term_list( $post->ID, 'event-location', '', ', ', '') . '</span>';
		foreach ($contact_infos as $line) :
			if ( $line['comm-type'] == 'tel') {
				array_push( $tel_arr, $line['comm-value'] );	
			}
		endforeach;
		$output .= '<span class="value">' . implode('/', $tel_arr) . '</span>';
		$output .= '</li></ul>';
		$output .= '</div><!-- end .two_third .last -->';
		$output .= '</article>';
			
		return $output;	
	}
	
}	

/* ---------------------------------------------------------------------- */
/*	Render Listing Detail
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_event_detail' ) ) {

	function sp_event_detail( $post_meta_keys, $thum_size ) {
	
		global $post, $smof_data;
			
		$output = '<article class="listing-' . get_the_ID() . '">';
		
		$output .= '<div id="listing-info">';
		
		$output .= '<div class="two_third">';
		$output .= '<h2 class="listing-name">' . get_the_title() . '</h2>';
		$output .= sp_address_listing($post_meta_keys);
		$output .= '</div><!-- end .two_third -->';
		
		$output .= '<div class="one_third last">';
		$output .= '<p class="organisor"><span>' . __('Organisor', 'sptheme') . '</span><a href="' . get_permalink($post_meta_keys['sp_organized_by'][0]) . '">' . get_the_title($post_meta_keys['sp_organized_by'][0]) . '</a></p>';
		$output .= '</div><!-- end .one_third .last-->';	
		$output .= '<div class="clear"></div>';
		
		$output .= '<div class="one_third">';
		
		if ( sp_post_image($thum_size) ) :
		$output .= '<img src="' . sp_post_image($thum_size) . '" />'; 
		endif;
		
		$output .= '<div class="social-links"><span>' . __( 'Join this event on:', 'sptheme' ) . '</span>' . sp_get_social_networking( 'yes', '16', $post_meta_keys ) . '</div><!-- end .social-links -->';
		
		$output .= '<div class="categories">';
		$output .= get_the_term_list( $post->ID, 'event-type', '<span>', '</span><span>', '</span>');
		$output .= '</div><!-- end .categories -->';
		
		$output .= '</div><!-- end .one_third -->';
		
		$output .= '<div class="two_third last">';
		$output .= '<h5>' . __( 'Contact Infomation', 'sptheme' ) . '</h5>';
		$output .= sp_get_comm_line($post_meta_keys);
		
		$output .= '<h5>' . __( 'Event Date', 'sptheme' ) . '</h5>';
		$output .= sp_get_event_info($post_meta_keys);
		
		if( $smof_data[ 'share_post' ] ) :
		$output .= '<span class="social-share">' . __( 'Share on: ', 'spthemem' ) . '</span>';
		$output .= sp_social_share();
		endif;
		
		$output .= '</div><!-- end .two_third .last -->';
		$output .= '<div class="clear"></div>';
		
		$output .= '</div><!-- end #listing-info -->';
		
		if ( $smof_data['show_listing_map'] ) :
		$output .= sp_single_map('event-location');
		endif;
		
		$output .= sp_single_description();
		
		$output .= '</article>';
			
		return $output;	
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Address listing
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_address_listing' ) ) {

	function sp_address_listing($post_meta_keys) {
		
		global $post;
		
		$output = '<address>' . $post_meta_keys['sp_address'][0] . '</address>';
		
		return $output;
	}

}

/* ---------------------------------------------------------------------- */
/*	Map Homepage
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_map_homepage' ) ) {

	function sp_map_homepage() {
		
		global $post;
		
		$output = '<div id="map-home">';
		$output .= '<div id="map-home-container"></div>';
		$output .= '<div id="dir-container"></div>';
		$output .= '</div><!-- end #map-home -->';	
		
		return  $output;
	}

}

/* ---------------------------------------------------------------------- */
/*	Map listing
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_single_map' ) ) {

	function sp_single_map($tax_id = null) {
		
		global $post;
		
		$output = '<div id="listing-map">';
		$output .= '<h3>' . __( 'Location ', 'sptheme' ) . '<small>' . get_the_term_list( $post->ID, $tax_id, 'in ', ', ', '') . '</small></h3>';
		$output .= '<div id="single-map"></div>';
		$output .= '<div id="dir-container"></div>';
		$output .= '</div><!-- end .listing-map -->';	
		
		return  $output;
	}

}		

/* ---------------------------------------------------------------------- */
/*	Description listing
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_single_description' ) ) {

	function sp_single_description() {
		
		global $post;
		
		$output = '<div id="listing-profile">';
		$output .= '<h3>' . __( 'Description', 'sptheme' ) . '</h3>';
		$output .= '<p>' . preg_replace('#<a.*?>(.*?)</a>#i', '\1', get_the_content()) . '</p>'; 
		$output .= '</div><!-- end .listing-profile -->';
		
		return $output;
	
	}

}		

/* ---------------------------------------------------------------------- */
/*	Show Communication Line
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_get_comm_line')) {

	function sp_get_comm_line($post_meta_keys) {
		
		global $commLine;
		
		$contact_infos = maybe_unserialize($post_meta_keys['sp_comm_line'][0]);
		$output = '<ul class="comm">';
		
		foreach ( $contact_infos as $line ) :
		
			$comm_type = $line['comm-type'];
			$comm_value = $line['comm-value'];
		
			if ($line['comm-type'] == 'website') {
				$output .= '<li><span class="attr">' . ucfirst($comm_type) . '</span><span class="value"><a href="' . $comm_value . '">' . substr($comm_value, 7) . '</a></span></li>';
			} elseif ($line['comm-type'] == 'e-mail') {
				$output .= '<li><span class="attr">' . ucfirst($comm_type) . '</span><span class="value"><a href="mailto:' . antispambot($comm_value) . '">' . antispambot($comm_value) . '</a></span></li>';
			} elseif ($line['comm-type'] == 'pobox') {
				$output .= '<li><span class="attr">P.O. Box</span><span class="value">' . $comm_value . '</span></li>';
			} else {
			$output .= '<li><span class="attr">' . ucfirst($comm_type) . '</span><span class="value">' . $comm_value . '</span></li>';
			}
		endforeach;
		
		$output .= '</ul>';
		
		return $output;
	}
}	

/* ---------------------------------------------------------------------- */
/*	Show opening attribute
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_get_opening_attr')) {

	function sp_get_opening_attr($post_meta_keys) {
		
		global $openHourAttr;
		
		$hours = maybe_unserialize($post_meta_keys['sp_open_hour'][0]);
		$output = '<ul class="open-hour">';
		
		foreach ( $hours as $hour ) :
			
			switch($hour['day-select']){
				case 0:
					$day_attr = $openHourAttr['0'];
					break;
				
				case 1:
					$day_attr = $openHourAttr['1'];	
					break;
					
				case 2:
					$day_attr = $openHourAttr['2'];
					break;
					
				case 3:
					$day_attr = $openHourAttr['3'];
					break;
					
				default:
					break;	
			}
		
			$output .= '<li>' . $day_attr . ': ' . $hour['start-hour'] . ' - ' . $hour['end-hour'] . '</li>';
		endforeach;
		
		$output .= '</ul>';
		
		return $output;
	}
}

/* ---------------------------------------------------------------------- */
/*	Show event date and time
/* ---------------------------------------------------------------------- */

if( !function_exists('sp_get_event_info')) {

	function sp_get_event_info($post_meta_keys) {
		
		global $eventRepeatOptions;
		
		$is_repeat = $post_meta_keys['sp_is_repeat'][0];
		$repeat_every = $post_meta_keys['sp_repeat_options'][0];
		
		$event_start = explode(' ', $post_meta_keys['sp_evt_start'][0]);
		$event_end = explode(' ', $post_meta_keys['sp_evt_end'][0]);
								
		$output = '<ul class="event-date clearfix">';
		$output .= '<li><span class="icons date"></span><span>' . __('Start Date: ', 'sptheme') . '</span>' . date('F j, Y', strtotime($event_start[0])) . '</li>';
		$output .= '<li><span class="icons date"></span><span>' . __('End Date: ', 'sptheme') . '</span>' . date('F j, Y', strtotime($event_end[0])) . '</li>';
		$output .= '<li><span class="icons time"></span><span>' . __('Time: ', 'sptheme') . '</span>' . $event_start[1] . ' to ' . $event_end[1] . '</li>';
		if ( ($is_repeat == 1) && !empty($repeat_every))
			$output .= '<li><span class="icons repeat"></span><span>' . __('Will do: ', 'sptheme') . '</span>' . $eventRepeatOptions[$repeat_every] . '</li>';
		$output .= '</ul>';
		
		return $output;
	}
}


/* ---------------------------------------------------------------------- */
/*	Social link networking
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_get_social_networking' ) ) {

	function sp_get_social_networking($newtab='yes', $icon_size='32', $post_meta_keys) {
		
		if ($newtab == 'yes') $newtab = "target=\"_blank\"";
		else $newtab = '';
			
		$icons_path =  SP_ASSETS_THEME . 'images/socialicons';
		
		$output = '<div class="social-icons icon_' . $icon_size .'">';
		$output .= '<a class="google-tieicon" title="Google+" href="#"' . $newtab . '><img src="' . $icons_path .'/google_plus.png" alt="Google+"  /></a>';
		$output .= '<a class="facebook-tieicon" title="Facebook" href="#"' . $newtab . '><img src="' . $icons_path .'/facebook.png" alt="Facebook"  /></a>';
		$output .= '<a class="twitter-tieicon" title="Twitter" href="#"' . $newtab . '><img src="' . $icons_path .'/twitter.png" alt="Twitter"  /></a>';
		$output .= '<a class="linkedin-tieicon" title="Linkedin" href="#"' . $newtab . '><img src="' . $icons_path .'/linkedin.png" alt="Linkedin"  /></a>';		
		$output .= '</div>';
		
		return $output;
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Social share
/* ---------------------------------------------------------------------- */
if ( ! function_exists( 'sp_social_share' ) ) {

	function sp_social_share() {
		
		global $smof_data, $post;
		
		$output = '<div class="share-post">';
		$output .= '<ul>';
		//$output .= '<li>' . __( 'Share on: ', 'spthemem' ) . '</li>';
		
		if( $smof_data[ 'share_tweet' ] ):
		$output .= '<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink() . '" data-text="' . get_the_title() . '" data-via="' . $smof_data[ 'share_twitter_username' ] . '" data-lang="en">tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></li>';
		endif;
		
		if( $smof_data[ 'share_facebook' ] ):
		$output .= '<li><iframe src="http://www.facebook.com/plugins/like.php?href=' . get_permalink() . '&amp;layout=button_count&amp;show_faces=false&amp;width=105&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:105px; height:21px;" allowTransparency="true"></iframe></li>';
		endif;
		
		if( $smof_data[ 'share_google' ] ):
		$output .= '<li style="width:80px;"><div class="g-plusone" data-size="medium" data-href="' . get_permalink() . '"></div>';
		$output .= '<script type="text/javascript">
					  (function() {
						var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
					  })();
					</script>';
		$output .= '</li>';
		endif;
		
		if( $smof_data[ 'share_linkdin' ] ):
		$output .= '<li><script src="http://platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="' . get_permalink() . '" data-counter="right"></script></li>';
		endif;
		
		if( $smof_data[ 'share_pinterest' ] ):
		$output .= '<li style="width:80px;"><script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script><a href="http://pinterest.com/pin/create/button/?url=' . get_permalink() . '&amp;media=' . sp_post_image('medium') . '" class="pin-it-button" count-layout="horizontal"><img border="0" src="http://assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></li>';
		endif;
		
		$output .= '</ul><div class="clear"></div>';
		$output .= '</div><!-- .share-post -->';
		
		return $output;
	}
}		

/* ---------------------------------------------------------------------- */
/*	Taxonomy list
/* ---------------------------------------------------------------------- */
/*
	* Taxonomy list - returns array [slug => name]
	*
	* $args = ARRAY [see below for options]
	*/
	if ( ! function_exists( 'sp_tax_array' ) ) {
		function sp_tax_array( $args = array() ) {
			$args = wp_parse_args( $args, array(
					'all'          => true, //whether to display "all" option
					'allCountPost' => 'post', //post type to count posts for "all" option, if left empty, the posts count will not be displayed
					'allText'      => __( 'All posts', 'sptheme_admin' ), //"all" option text
					'hierarchical' => '1', //whether taxonomy is hierarchical
					'orderBy'      => 'name', //in which order the taxonomy titles should appear
					'parentsOnly'  => false, //will return only parent (highest level) categories
					'return'       => 'slug', //what to return as a value (slug, or term_id?)
					'tax'          => 'category', //taxonomy name
				) );

			$outArray = array();
			$terms    = get_terms( $args['tax'], 'orderby=' . $args['orderBy'] . '&hide_empty=0&hierarchical=' . $args['hierarchical'] );

			if ( $args['all'] ) {
				if ( ! $args['allCountPost'] ) {
					$allCount = '';
				} else {
					$allCount = wp_count_posts( $args['allCountPost'], 'readable' );
					$allCount = ' (' . absint( $allCount->publish ) . ')';
				}
				$outArray[''] = '- ' . $args['allText'] . $allCount . ' -';
			}

			if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
				foreach ( $terms as $term ) {
					if ( ! $args['parentsOnly'] ) {
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					} elseif ( $args['parentsOnly'] && ! $term->parent ) { //get only parent categories, no children
						$outArray[$term->$args['return']] = $term->name;
						$outArray[$term->$args['return']] .= ( ! $args['allCountPost'] ) ? ( '' ) : ( ' (' . $term->count . ')' );
					}
				}
			}

			return $outArray;
		}
	} // /sp_tax_array
	
/* ---------------------------------------------------------------------- */
/*	Pages list
/* ---------------------------------------------------------------------- */	
	/*
	* Pages list - returns array [post_name (slug) => name]
	*
	* $return  = 'post_name' OR 'ID'
	*/
	if ( ! function_exists( 'sp_pages' ) ) {
		function sp_pages( $return = 'post_name' ) {
			$pages       = get_pages();
			$outArray    = array();
			$outArray[0] = __( '- Select page -', 'sptheme_admin' );

			foreach ( $pages as $page ) {
				$indents = $pagePath = '';
				$ancestors = get_post_ancestors( $page->ID );

				if ( ! empty( $ancestors ) ) {
					$indent = ( $page->post_parent ) ? ( '&ndash; ' ) : ( '' );
					foreach ( $ancestors as $ancestor ) {
						if ( 'post_name' == $return ) {
							$parent = get_page( $ancestor );
							$pagePath .= $parent->post_name . '/';
						}
						$indents .= $indent;
					}
				}

				$pagePath .= $page->post_name;
				$returnParam = ( 'post_name' == $return ) ? ( $pagePath ) : ( $page->ID );

				$outArray[$returnParam] = $indents . strip_tags( $page->post_title );
			}

			return $outArray;
		}
	} // /sp_pages

/* ---------------------------------------------------------------------- */
/*	Blog navigation
/* ---------------------------------------------------------------------- */

if ( !function_exists('sp_pagination') ) {

	function sp_pagination( $pages = '', $range = 2 ) {

		$showitems = ( $range * 2 ) + 1;

		global $paged, $wp_query;

		if( empty( $paged ) )
			$paged = 1;

		if( $pages == '' ) {

			$pages = $wp_query->max_num_pages;

			if( !$pages )
				$pages = 1;

		}

		if( 1 != $pages ) {

			$output = '<nav class="pagination">';

			// if( $paged > 2 && $paged >= $range + 1 /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( 1 ) . '" class="next">&laquo; ' . __('First', 'sptheme') . '</a>';

			if( $paged > 1 /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged - 1 ) . '" class="next">&larr; ' . __('Previous', 'sptheme') . '</a>';

			for ( $i = 1; $i <= $pages; $i++ )  {

				if ( 1 != $pages && ( !( $i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems ) )
					$output .= ( $paged == $i ) ? '<span class="current">' . $i . '</span>' : '<a href="' . get_pagenum_link( $i ) . '">' . $i . '</a>';

			}

			if ( $paged < $pages /*&& $showitems < $pages*/ )
				$output .= '<a href="' . get_pagenum_link( $paged + 1 ) . '" class="prev">' . __('Next', 'sptheme') . ' &rarr;</a>';

			// if ( $paged < $pages - 1 && $paged + $range - 1 <= $pages /*&& $showitems < $pages*/ )
				// $output .= '<a href="' . get_pagenum_link( $pages ) . '" class="prev">' . __('Last', 'sptheme') . ' &raquo;</a>';

			$output .= '</nav>';

			return $output;

		}

	}

}

	


