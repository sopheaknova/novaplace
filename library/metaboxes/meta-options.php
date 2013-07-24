<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit: 
 * @link http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 */

/********************* META BOX DEFINITIONS ***********************/

$prefix = 'sp_';

global $meta_boxes, $eventRepeatOptions;

$meta_boxes = array();
		
/* ---------------------------------------------------------------------- */
/*	Listing meta box
/* ---------------------------------------------------------------------- */
$meta_boxes[] = array(
	'id'       => 'open-hour-setting',
	'title'    => __('Opening Hour', 'sptheme_admin'),
	'pages'    => array('sp_listing'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
			
		array(
			'type' => 'heading',
			'name' => __( 'Opening Hour', 'sptheme_admin' ),
			'id'   => 'fake_id', // Not used but needed for plugin
		),
		
		array(
				'name' => __('Hour', 'sptheme_admin'),
				'id'   => $prefix . 'open_hour',
				'type' => 'open_hour',
			),
	)
);

/* ---------------------------------------------------------------------- */
/*	Event meta box
/* ---------------------------------------------------------------------- */

$meta_boxes[] = array(
	'id'       => 'events-organized-by',
	'title'    => __('Organized by', 'sptheme_admin'),
	'pages'    => array('sp_events'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
			
		array(
				'name' => __('Organized by', 'sptheme_admin'),
				'id'   => $prefix . 'organized_by',
				'type'    => 'post',

				// Post type
				'post_type' => 'sp_listing',
				// Field type, either 'select' or 'select_advanced' (default)
				'field_type' => 'select_advanced',
				// Query arguments (optional). No settings means get all published posts
				'query_args' => array(
					'post_status' => 'publish',
					'posts_per_page' => '10',
				)
			),			
			
	)
);		

$meta_boxes[] = array(
	'id'       => 'events-time-setting',
	'title'    => __('Event Date', 'sptheme_admin'),
	'pages'    => array('sp_events'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
			
		array(
				'name' => __( 'Event start date and time', 'sptheme_admin' ),
				'id'   => $prefix . 'evt_start',
				'type' => 'datetime',

				// jQuery datetime picker options. See here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute'     => 1,
					'showTimepicker' => true,
					'numberOfMonths' => 2,
					//'timeFormat'	 => 'hh:mm:ss',
				),
			),			
		
		array(
				'name' => __( 'Event end date and time', 'sptheme_admin' ),
				'id'   => $prefix . 'evt_end',
				'type' => 'datetime',

				// jQuery datetime picker options. See here http://trentrichardson.com/examples/timepicker/
				'js_options' => array(
					'stepMinute'     => 1,
					'showTimepicker' => true,
					'numberOfMonths'  => 2,
					//'timeFormat'	 => 'hh:mm:ss',
				),
			),
		
		array(
			'name' => __( 'Is Repeating?', 'sptheme_admin' ),
			'id'   => $prefix . 'is_repeat',
			'type' => 'checkbox',
			'desc' => 'Is this event repetition?',
			// Value can be 0 or 1
			'std'  => 0,
		),
		
		array(
			'name'     => __( 'Repeat every:', 'rwmb' ),
			'id'   => $prefix . 'repeat_options',
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => $eventRepeatOptions,
		),			
			
	)
);

/* ---------------------------------------------------------------------- */
/*	Both Listing and Event meta box
/* ---------------------------------------------------------------------- */
$meta_boxes[] = array(
	'id'       => 'company-info-settings',
	'title'    => __('Company Info', 'sptheme_admin'),
	'pages'    => array('sp_events', 'sp_listing'),
	'context'  => 'normal',
	'priority' => 'high',
	'fields'   => array(
			
		array(
				'name' => __('Address', 'sptheme_admin'),
				'id'   => $prefix . 'address',
				'type' => 'textarea',
				'std'  => '',
				'desc' => 'e.g: No. 29B, Mao Tse Toung Blvd, Sangkat Boeung Keng Kang I, Khan Chamkar Morn, 12302 Phnom Penh'
			),
		
		
		array(
				'id'            => 'location',
				'name'          => __( 'Location', 'sptheme_admin' ),
				'type'          => 'map',
				'std'           => '11.576086,104.92306,12',     // 'latitude,longitude[,zoom]' (zoom is optional)
				'style'         => 'width: 99%; height: 350px',
				'address_field' => 'sp_address',                     // Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
			),
			
		array(
			'type' => 'heading',
			'name' => __( 'Contact Information', 'sptheme_admin' ),
			'id'   => 'fake_id', // Not used but needed for plugin
		),
		
		array(
				'name' => __('Communication Line', 'sptheme_admin'),
				'id'   => $prefix . 'comm_line',
				'type' => 'contact_info',
				'std'  => ''
			),
			
		array(
			'type' => 'heading',
			'name' => __( 'Social Network Link', 'sptheme_admin' ),
			'id'   => 'fake_id', // Not used but needed for plugin
		),	
			
		array(
				'name' => __('Social Network', 'sptheme_admin'),
				'id'   => $prefix . 'social_network_link',
				'type' => 'social_network',
			),	
			
		array(
			'type' => 'heading',
			'name' => __( 'Photo Gallery', 'sptheme_admin' ),
			'id'   => 'fake_id', // Not used but needed for plugin
		),
		
		array(
				'name' => __('Upload photo', 'sptheme_admin'),
				'id'   => $prefix . 'listing_gallery',
				'type' => 'image_advanced',
				'max_file_uploads' => 5,
			),		
		
	)
);	

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function sp_register_meta_boxes()
{
	global $meta_boxes;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded
//  before (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'sp_register_meta_boxes' );