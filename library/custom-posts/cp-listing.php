<?php
/*
*****************************************************
* Listing custom post
*****************************************************
*/





/*
*****************************************************
*	ACTIONS AND FILTERS
*****************************************************
*/
	//ACTIONS
		//Registering CP
		add_action( 'init', 'sp_listing_cp_init' );
		//CP list table columns
		add_action( 'manage_sp_listing_posts_custom_column', 'sp_listing_cp_custom_column' );

	//FILTERS
		//CP list table columns
		add_filter( 'manage_edit-sp_listing_columns', 'sp_listing_cp_columns' );




/*
*****************************************************
* 	CREATING A CUSTOM POST
*****************************************************
*/
	/*
	* Custom post registration
	*/
	if ( ! function_exists( 'sp_listing_cp_init' ) ) {
		function sp_listing_cp_init() {
			global $cpMenuPosition;

			$role     = 'post'; // page
			$slug     = 'listing';
			$supports = array('title', 'editor', 'thumbnail'); // 'title', 'editor', 'thumbnail'

			/*if ( $smof_data['sp_listing_revisions'] )
				$supports[] = 'revisions';*/

			$args = array(
				'query_var'           => 'listing',
				'capability_type'     => $role,
				'public'              => true,
				'show_ui'             => true,
				'show_in_nav_menus'	  => false,
				'exclude_from_search' => false,
				'hierarchical'        => false,
				'rewrite'             => array( 'slug' => $slug ),
				'menu_position'       => $cpMenuPosition['listing'],
				'menu_icon'           => SP_ASSETS_ADMIN . 'img/icon-news.png',
				'supports'            => $supports,
				'labels'              => array(
					'name'               => __( 'Listing', 'sptheme_admin' ),
					'singular_name'      => __( 'Listing', 'sptheme_admin' ),
					'add_new'            => __( 'Add new listing', 'sptheme_admin' ),
					'add_new_item'       => __( 'Add new listing', 'sptheme_admin' ),
					'new_item'           => __( 'Add new listing', 'sptheme_admin' ),
					'edit_item'          => __( 'Edit listing', 'sptheme_admin' ),
					'view_item'          => __( 'View listing', 'sptheme_admin' ),
					'search_items'       => __( 'Search listing', 'sptheme_admin' ),
					'not_found'          => __( 'No listing found', 'sptheme_admin' ),
					'not_found_in_trash' => __( 'No listing found in trash', 'sptheme_admin' ),
					'parent_item_colon'  => ''
				)
			);
			register_post_type( 'sp_listing' , $args );
		}
	} // /sp_listing_cp_init			


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
	if ( ! function_exists( 'sp_listing_cp_columns' ) ) {
		function sp_listing_cp_columns( $sp_listingCols ) {
			
			$sp_listingCols = array(
				//standard columns
				"cb"				=> '<input type="checkbox" />',
				"listing_logo"		=> __( 'Logo', 'spthme_admin' ),
				'title'				=> __( 'Listing name', 'sptheme_admin' ),
				'listing_address'				=> __( 'Address', 'sptheme_admin' ),
				"date"				=> __( 'Date', 'sptheme_admin' ),
				"author"			=> __( 'Created by', 'sptheme_admin' )
			);

			return $sp_listingCols;
		}
	} // /sp_listing_cp_columns

	/*
	* Outputting values for the custom columns in the table
	*
	* $Col = TEXT [column id for switch]
	*/
	if ( ! function_exists( 'sp_listing_cp_custom_column' ) ) {
		function sp_listing_cp_custom_column( $sp_listingCol ) {
			global $post;
			
			switch ( $sp_listingCol ) {
				
				case "listing_logo":
					
					$size = explode( 'x', SP_ADMIN_LIST_THUMB );
					echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail( $post->ID, $size, array( 'title' => get_the_title( $post->ID ) ) ) . '</a>';

					break;
					
				case "listing_address":
					
					echo get_post_meta($post->ID, 'sp_address', true);

					break;	
				
				default:
					break;
			}
		}
	} // /sp_listing_cp_custom_column


	
	
	