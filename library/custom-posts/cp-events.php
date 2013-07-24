<?php
/*
*****************************************************
* Events custom post
*****************************************************
*/





/*
*****************************************************
*	ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_events_cp_init' );
		//CP list table columns
		add_action( 'manage_sp_events_posts_custom_column', 'sp_events_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_events_columns', 'sp_events_cp_columns' );




/*
*****************************************************
* 	CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_events_cp_init' ) ) {
		function sp_events_cp_init() {
			global $cpMenuPosition;

			$role     = 'post'; // page
			$slug     = 'events';
			$supports = array('title', 'editor', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			/*if ( $smof_data['sp_events_revisions'] )
				$supports[] = 'revisions';*/

			$args = array(
				'query_var'           => 'events',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'show_in_nav_menus'	  => false,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['events'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'img/icon-events.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Events', 'sptheme_admin' ),
					'singular_name'      => __( 'Event', 'sptheme_admin' ),
					'add_new'            => __( 'Add new event', 'sptheme_admin' ),
					'add_new_item'       => __( 'Add new event', 'sptheme_admin' ),
					'new_item'           => __( 'Add new event', 'sptheme_admin' ),
					'edit_item'          => __( 'Edit event', 'sptheme_admin' ),
					'view_item'          => __( 'View event', 'sptheme_admin' ),
					'search_items'       => __( 'Search events', 'sptheme_admin' ),
					'not_found'          => __( 'No events found', 'sptheme_admin' ),
					'not_found_in_trash' => __( 'No events found in trash', 'sptheme_admin' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'sp_events' , $args );
		}
	} // /sp_events_cp_init			


/*
*****************************************************
*	CUSTOM POST LIST IN ADMIN
*****************************************************
*/
	/*
	* Registration of the table columns
	*
	* $Cols = ARRAY [array of columns]
	*/
	if ( ! function_exists( 'sp_events_cp_columns' ) ) {
		function sp_events_cp_columns( $sp_eventsCols ) {
			
			$sp_eventsCols = array(
				//standard columns
				"cb"				=> '<input type="checkbox" />',
				'title'				=> __( 'events name', 'sptheme_admin' ),
				'event_address'				=> __( 'Address', 'sptheme_admin' ),
				"event_date"				=> __( 'Date', 'sptheme_admin' ),
				"organizer"				=> __( 'Organizer', 'sptheme_admin' ),
				"author"			=> __( 'Created by', 'sptheme_admin' )
			);

			return $sp_eventsCols;
		}
	} // /sp_events_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_events_cp_custom_column' ) ) {
		function sp_events_cp_custom_column( $sp_eventsCol ) {
			global $post;
			
			$event_start = explode(' ', get_post_meta(get_the_ID(), 'sp_evt_start', true));
			$event_end = explode(' ', get_post_meta(get_the_ID(), 'sp_evt_end', true));
			
			switch ( $sp_eventsCol ) {
				
				case "event_address":
					echo get_post_meta($post->ID, 'sp_address', true);
					break;
					
				case "event_date":
					echo date('F j, Y', strtotime($event_start[0])) . ' to ' . date('F j, Y', strtotime($event_end[0]));
					break;
					
				case "organizer":
					echo get_the_title(get_post_meta(get_the_ID(), 'sp_organized_by', true));
					break;			
				
				default:
					break;
			}
		}
	} // /sp_events_cp_custom_column

/*
*****************************************************
*	CHANGE DEFAULT TITLE FOR EVENTS
*****************************************************
*/
if ( ! function_exists( 'sp_change_events_title' ) ) {

	function sp_change_events_title( $title ){
	
		$screen = get_current_screen();
	
		if ( $screen->post_type == 'sp_events' )
			$title = __('Enter event name here', 'sptheme_admin');
	
		return $title;
	
	}

}

add_filter('enter_title_here', 'sp_change_events_title');



	
	
	