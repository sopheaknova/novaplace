<?php

/*
*****************************************************
*      ACTIONS AND FILTERS
*****************************************************
*/

	//ACTION & FILTER
		add_action('after_setup_theme', 'sp_theme_setup');//Theme support after activate
		add_action('init', 'sp_register_assets');//Register and print CSS and JS
		add_action('wp_print_styles', 'sp_enqueue_styles'); //print CSS
		add_action('wp_print_scripts', 'sp_enqueue_scripts'); //print JS
		add_action( 'wp_head', 'sp_print_css_js' );//Custom scripts
		add_action('wp_footer', 'google_analytics_script');
		
		add_filter('wp_title', 'sp_filter_wp_title', 10, 2);	
		//TinyMCE customization
		if ( is_admin() ) {
			add_filter( 'mce_buttons', 'sp_add_buttons_row1' );
			add_filter( 'mce_buttons_2', 'sp_add_buttons_row2' );
		}
		
		add_filter( 'the_excerpt_rss', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		add_filter( 'the_content_feed', 'sp_rss_post_thumbnail' );//Display thumbnails in RSS
		
		add_filter('excerpt_length', 'sp_excerpt_length');
		add_filter('excerpt_more', 'sp_auto_excerpt_more');
		
	
	//SECURITY
		//Remove error message login
		add_filter('login_errors', create_function('$a', "return null;"));
		//Remove wordpress version generation
		remove_action( 'wp_head', 'wp_generator' );
		//Rremove Windows Live Writer support
		remove_action( 'wp_head', 'wlwmanifest_link' );	
		
	//BRANDING
		add_action( 'admin_head', 'sp_adminfavicon' );//Set favicons for backend code
		add_action('login_head', 'sp_custom_login_logo');// Custom logo login
		add_action( 'wp_before_admin_bar_render', 'sp_remove_admin_bar_links' );//	Remove logo and other items in Admin menu bar
		add_filter('login_headerurl', 'sp_remove_link_on_admin_login_info');//  Remove wordpress link on admin login logo
		add_filter('login_headertitle', 'sp_change_loging_logo_title');// Change login logo title
		add_filter('admin_footer_text', 'sp_modify_footer_admin'); // Customising footer text	
		

if ( ! isset( $content_width ) ) $content_width = 620; 	// 1160				

/*-----------------------------------------------------------------------------------*/
/*	theme set up
/*-----------------------------------------------------------------------------------*/
function sp_theme_setup() {
	
	// Make theme available for translation
	load_theme_textdomain( 'sptheme', SP_BASE_DIR . 'languages' );
	
	// Editor style
	add_editor_style('css/editor-style.css');
	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'top_nav' => __( 'Top Navigation', 'sptheme_admin' ),
		'primary_nav' => __( 'Primary Navigation', 'sptheme_admin' ),
		'footer_nav'  => __( 'Footer Navigation', 'sptheme_admin' )
	) );

	if ( function_exists( 'add_image_size' ) ){
		add_image_size( 'sp-small', 64, 64, true );
		add_image_size( 'sp-medium', 196, 110, true );
		add_image_size( 'sp-large', 300, 168, true );
		add_image_size( 'slider', 640, 360, true );
	}

	if ( function_exists( 'add_theme_support' ) ){
		add_theme_support( 'post-thumbnails' ); // Add theme support for post thumbnails (featured images).
		add_theme_support( 'post-formats', array( 'audio', 'video' ) ); // aside, gallery, image, link, quote, video, audio
		add_theme_support( 'automatic-feed-links' ); // Add theme support for automatic feed links.
	}
	
}

/* ---------------------------------------------------------------------- */
/*	Register CSS and JS
/* ---------------------------------------------------------------------- */

function sp_register_assets() {
	
	if( !is_admin() ) {
		
		//CSS
		wp_register_style( 'sp-theme-styles', SP_BASE_URL . 'style.css', false, SP_THEME_VERSION );
		wp_register_style( 'sp-magnific-popup', SP_ASSETS_THEME . 'css/magnific-popup.css', false, SP_THEME_VERSION );
			
		//JS
		wp_register_script( 'map-homepage',    SP_ASSETS_THEME . 'js/map.home.js', array('jquery'), SP_THEME_VERSION, true );
		wp_register_script( 'info-box-map',    SP_ASSETS_THEME . 'js/infobox.js', array('jquery'), SP_THEME_VERSION, true );
		wp_register_script( 'map-single-listing',    SP_ASSETS_THEME . 'js/map.single.listing.js', array('jquery'), SP_THEME_VERSION, true );
		wp_register_script( 'magnific-popup',    SP_ASSETS_THEME . 'js/jquery.magnific-popup.min.js', array('jquery'), SP_THEME_VERSION, true );
		wp_register_script( 'custom_scripts',    SP_ASSETS_THEME . 'js/custom.js', array('jquery'), SP_THEME_VERSION, true );
	} 

}


	//Enqueue/print CSS
	function sp_enqueue_styles() {
	
		if( !is_admin() ) {
			wp_enqueue_style('sp-theme-styles');
			wp_enqueue_style('sp-magnific-popup');
		} 
	
	}
	
	
	// Enqueue/print JS
	function sp_enqueue_scripts() {
		
		global $smof_data;	
		
		if( !is_admin() ) {
			wp_enqueue_script( 'googlemap', 'http://maps.google.com/maps/api/js?sensor=false', array(), '', true );
			wp_enqueue_script('jquery');			
			if (is_home()) {
				wp_enqueue_script( 'info-box-map');
				wp_enqueue_script( 'map-homepage');
			}
				
			if ( is_singular() && ( $smof_data['show_listing_map'] == 1 ) ) {
				wp_enqueue_script( 'map-single-listing');
			}
			wp_enqueue_script( 'magnific-popup');
			wp_enqueue_script('custom_scripts');
			
		}
	}
	//custom scripts and styles
	function sp_print_css_js() {
		
		global $smof_data, $post;
		
		if (!is_admin()) {
			wp_register_script( 'scroll_to_top',    SP_ASSETS_THEME . 'js/scroll.to.top.js', array(), SP_THEME_VERSION, false, false );
			wp_enqueue_script('scroll_to_top');
		}
		?>	
		<script type="text/javascript">
		
		
		
			var siteurl = '<?php echo SP_BASE_URL; ?>';
		<?php
		//Drop Latitude & Longitude of single listing
		if ( is_singular() && ( $smof_data['show_listing_map'] == 1 ) ) {
		?>
			var	single_map_coords = '<?php echo get_post_meta( $post->ID, 'location', true ); ?>';
				
		<?php } ?>
		
		<?php
		if ( is_home() ) {
			$args = array( 'post_type' => 'sp_listing', 'posts_per_page' => 10 );
			$listing = new WP_Query( $args );
			$map_order = 1;
			if ($listing->have_posts()) :
		?>
		
		var locations = [
		<?php while ( $listing->have_posts() ) : $listing->the_post(); ?>	
				       ['<?php echo get_the_title(); ?>', <?php echo get_post_meta( $post->ID, 'location', true ); ?>, <?php echo $map_order; ?>, 
				       '<div class="marker-holder"><div class="marker-content with-image">'+
				       '<img src="' + '<?php echo sp_post_image(); ?>' + '" />'+
				       '<div class="map-item-info">'+
							'<div class="title">'+ '<?php echo htmlspecialchars_decode(get_the_title()); ?>' +'</div>'+
							'<address>'+ '<?php echo get_post_meta( $post->ID, 'sp_address', true ); ?>' +'<br></address>'+
							'<a class="more-button" href="'+ '<?php echo get_permalink(); ?>' +'">'+'<?php echo _e('VIEW MORE', 'sptheme'); ?>'+'</a></div>'+
							'<div class="arrow"></div>'+
							'<div class="close"></div>'+
					   '</div></div>'],
		<?php $map_order++; endwhile; ?>
						];
					
		<?php endif; ?>	
		<?php } ?>
		
		</script>
		<?php	
	}

/*-----------------------------------------------------------------------------------*/
/* Embeded script in footer
/*-----------------------------------------------------------------------------------*/

function google_analytics_script() { 
	global $smof_data;
	if ( $smof_data['google_analytics']) echo htmlspecialchars_decode( stripslashes( $smof_data['google_analytics'] )); 
} 


/* ---------------------------------------------------------------------- */
/*	Visual editor improvment
/* ---------------------------------------------------------------------- */
	
/*
* Add buttons to visual editor first row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row1' ) ) {
	function sp_add_buttons_row1( $buttons ) {
		//inserting buttons after "italic" button
		$pos = array_search( 'italic', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'underline';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//inserting buttons after "justifyright" button
		$pos = array_search( 'justifyright', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = 'justifyfull';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}
		
		return $buttons;
	}
} // /sp_add_buttons_row1

/*
* Add buttons to visual editor second row
*
* $buttons = ARRAY [default WordPress visual editor buttons array]
*/
if ( ! function_exists( 'sp_add_buttons_row2' ) ) {
	function sp_add_buttons_row2( $buttons ) {
		//inserting buttons before "underline" button
		$pos = array_search( 'underline', $buttons, true );
		if ( $pos != false ) {
			$add = array_slice( $buttons, 0, $pos );
			$add[] = 'removeformat';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		//remove "justify full" button from second row
		$pos = array_search( 'justifyfull', $buttons, true );
		if ( $pos != false ) {
			unset( $buttons[$pos] );
			$add = array_slice( $buttons, 0, $pos + 1 );
			$add[] = '|';
			$add[] = 'sub';
			$add[] = 'sup';
			$add[] = '|';
			$buttons = array_merge( $add, array_slice( $buttons, $pos + 1 ) );
		}

		return $buttons;
	}
} // sp_add_buttons_row2

//Display thumbnails in RSS
if ( ! function_exists( 'sp_rss_post_thumbnail' ) ) {
	function sp_rss_post_thumbnail( $content ) {
		global $post;

		if ( has_post_thumbnail( $post->ID ) )
			$content = '<p>' . get_the_post_thumbnail( $post->ID ) . '</p>' . get_the_content();

		return $content;
	}
} // /sp_rss_post_thumbnail


/* ---------------------------------------------------------------------- */
/*	Customizable login screen and WordPress admin area
/* ---------------------------------------------------------------------- */
// Custom logo login
function sp_custom_login_logo() {
    echo '<style type="text/css">
		body.login{ background-color:#ffffff; }
        .login h1 a { background-image:url('.SP_ASSETS_THEME.'images/logo.png) !important; height:140px !important; background-size: auto auto !important;}
    </style>';
}

// Remove wordpress link on admin login logo
function sp_remove_link_on_admin_login_info() {
     return  get_bloginfo('url');
}

// Change login logo title
function sp_change_loging_logo_title(){
	return 'Go to '.get_bloginfo('name').' Homepage';
}

//	Remove logo and other items in Admin menu bar
function sp_remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}


// Customising footer text
function sp_modify_footer_admin () {  
  echo 'Created by <a href="http://www.novacambodia.com" target="_blank">novadesign</a>. Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';  
}  

/* ---------------------------------------------------------------------- */
/*	Other hook
/* ---------------------------------------------------------------------- */

// Sets the post excerpt length by word
function sp_excerpt_length( $length ) {
	global $post;
	
	$content = $post->post_content;
	$words = explode(' ', $content, $length + 1);
	if(count($words) > $length) :
		array_pop($words);
		array_push($words, '...');
		$content = implode(' ', $words);
	endif;
  
	$content = strip_tags(strip_shortcodes($content));
  
	return $content;

}

if ( ! function_exists( 'sp_auto_excerpt_more' ) ) {
	function sp_auto_excerpt_more( $more ) {
		return '&hellip;';
	}
} 

// Makes some changes to the <title> tag, by filtering the output of wp_title()
function sp_filter_wp_title( $title, $separator ) {

	if ( is_feed() ) return $title;

	global $paged, $page;

	if ( is_search() ) {
		$title = sprintf(__('Search results for %s', 'sptheme_admin'), '"' . get_search_query() . '"');

		if ( $paged >= 2 )
			$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), $paged);

		$title .= " $separator " . get_bloginfo('name', 'display');

		return $title;
	}

	$title .= get_bloginfo('name', 'display');
	$site_description = get_bloginfo('description', 'display');

	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	if ( $paged >= 2 || $page >= 2)
		$title .= " $separator " . sprintf(__('Page %s', 'sptheme_admin'), max($paged, $page) );

	return $title;

}

//  Set favicons for backend code
function sp_adminfavicon() {
echo '<link rel="icon" type="image/x-icon" href="'.SP_BASE_URL.'favicon.ico" />';
}

