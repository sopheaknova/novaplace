<?php 

/* ---------------------------------------------------------------------- */
/*	Basic Theme Settings
/* ---------------------------------------------------------------------- */
$shortname = get_template();

	//WP 3.4+ only
	$themeData     = wp_get_theme( $shortname );
	$themeName     = $themeData->Name;
	$themeVersion  = $themeData->Version;
	$pageTemplates = wp_get_theme()->get_page_templates();

	if( ! $themeVersion )
		$themeVersion = '';

	$shortname = str_replace( '-v' . $themeVersion, '', $shortname );

	//Basic constants	
	define( 'SP_THEME_NAME',      $themeName );
	define( 'SP_THEME_SHORTNAME', $shortname );
	define( 'SP_THEME_VERSION',   $themeVersion );	
	define( 'SP_SCRIPTS_VERSION', 20130605 );
	define( 'SP_ADMIN_LIST_THUMB', '64x64' ); //thumbnail size (width x height) on post/page/custom post listings
	
	define( 'SP_BASE_DIR',   get_template_directory() . '/' );
	define( 'SP_BASE_URL',     get_template_directory_uri() . '/' );
	define( 'SP_ASSETS_THEME', get_template_directory_uri() . '/assets/' );
	define( 'SP_ASSETS_ADMIN', get_template_directory_uri() . '/library/assets/' );


	//Custom post WordPress admin menu position - 30, 33, 39, 42, 45, 48
	if ( ! isset( $cpMenuPosition ) )
		$cpMenuPosition = array(
				'events'		=> 30,
				'listing'		=> 33
			);
			
	//Opening hour attribute 
	if ( ! isset( $openHourAttr ) )
		$openHourAttr = array(
				'0'		=> 'Always open',
				'1'		=> 'Mon - Fri',
				'2'		=> 'Saturday',
				'3'		=> 'Sunday',
			);
			
	//Social network link 
	if ( ! isset( $socialNetwork ) )
		$socialNetwork = array(
				'google+'		=> 'Google+',
				'facebook'		=> 'Facebook',
				'twitter'		=> 'Twitter',
				'linkedin'		=> 'LinkedIn',
			);
			
	//Social network link 
	if ( ! isset( $commLine ) )
		$commLine = array(
				'tel'		=> 'Telephone',
				'mobile'		=> 'Mobile',
				'e-mail'		=> 'E-mail',
				'fax'		=> 'Fax',
				'website'		=> 'Website',
				'swift'		=> 'Swift',
				'pobox'		=> 'P.O. Box',
			);
			
	//Events repeat options 
	if ( ! isset( $eventRepeatOptions ) )
		$eventRepeatOptions = array(
				'day'		=> 'Everyday',
				'week'		=> 'Every Week',
				'month'		=> 'Every Month',
				'year'		=> 'Every Year',
			);								


//Theme settings
require_once( SP_BASE_DIR . 'library/setup-theme.php' );
require_once( SP_BASE_DIR . 'library/theme-functions.php' );
//Theme Admin
require_once( SP_BASE_DIR . 'library/admin-functions.php' );
