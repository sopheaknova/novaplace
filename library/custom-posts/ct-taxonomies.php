<?php

//ACTIONS
//Registering taxonomies
add_action( 'init', 'sp_create_taxonomies', 0 );
/*
The init action occurs after the theme's functions file has been included, so if you're looking for terms directly in the functions file, you're doing so before they've actually been registered.
*/


/*
* Custom taxonomies registration
*/
if ( ! function_exists( 'sp_create_taxonomies' ) ) {
	function sp_create_taxonomies() {
		
		register_taxonomy( 'listing-type', array('sp_listing'), array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'listing-type',
					'rewrite'           => array( 'slug' => 'listing/type' ),
					'labels'            => array(
						'name'          => __( 'Listing type', 'sptheme_admin' ),
						'singular_name' => __( 'Listing type', 'sptheme_admin' ),
						'search_items'  => __( 'Search categories', 'sptheme_admin' ),
						'all_items'     => __( 'All categories', 'sptheme_admin' ),
						'parent_item'   => __( 'Parent category', 'sptheme_admin' ),
						'edit_item'     => __( 'Edit category', 'sptheme_admin' ),
						'update_item'   => __( 'Update category', 'sptheme_admin' ),
						'add_new_item'  => __( 'Add new category', 'sptheme_admin' ),
						'new_item_name' => __( 'New category title', 'sptheme_admin' )
					)
				) );
				
		register_taxonomy( 'listing-location', array('sp_listing'), array(
						'hierarchical'      => true,
						'show_in_nav_menus' => false,
						'show_ui'           => true,
						'query_var'         => 'listing-location',
						'rewrite'           => array( 'slug' => 'listing/area' ),
						'labels'            => array(
							'name'          => __( 'Location', 'sptheme_admin' ),
							'singular_name' => __( 'Location', 'sptheme_admin' ),
							'search_items'  => __( 'Search location', 'sptheme_admin' ),
							'all_items'     => __( 'All locations', 'sptheme_admin' ),
							'parent_item'   => __( 'Parent location', 'sptheme_admin' ),
							'edit_item'     => __( 'Edit location', 'sptheme_admin' ),
							'update_item'   => __( 'Update location', 'sptheme_admin' ),
							'add_new_item'  => __( 'Add new location', 'sptheme_admin' ),
							'new_item_name' => __( 'New location title', 'sptheme_admin' )
						)
					) );
					
		register_taxonomy( 'event-type', array('sp_events'), array(
					'hierarchical'      => true,
					'show_in_nav_menus' => false,
					'show_ui'           => true,
					'query_var'         => 'event-type',
					'rewrite'           => array( 'slug' => 'event/type' ),
					'labels'            => array(
						'name'          => __( 'Events type', 'sptheme_admin' ),
						'singular_name' => __( 'Event type', 'sptheme_admin' ),
						'search_items'  => __( 'Search categories', 'sptheme_admin' ),
						'all_items'     => __( 'All categories', 'sptheme_admin' ),
						'parent_item'   => __( 'Parent category', 'sptheme_admin' ),
						'edit_item'     => __( 'Edit category', 'sptheme_admin' ),
						'update_item'   => __( 'Update category', 'sptheme_admin' ),
						'add_new_item'  => __( 'Add new category', 'sptheme_admin' ),
						'new_item_name' => __( 'New category title', 'sptheme_admin' )
					)
				) );
				
		register_taxonomy( 'event-location', array('sp_events'), array(
						'hierarchical'      => true,
						'show_in_nav_menus' => false,
						'show_ui'           => true,
						'query_var'         => 'event-location',
						'rewrite'           => array( 'slug' => 'event/location' ),
						'labels'            => array(
							'name'          => __( 'Location', 'sptheme_admin' ),
							'singular_name' => __( 'Location', 'sptheme_admin' ),
							'search_items'  => __( 'Search location', 'sptheme_admin' ),
							'all_items'     => __( 'All locations', 'sptheme_admin' ),
							'parent_item'   => __( 'Parent location', 'sptheme_admin' ),
							'edit_item'     => __( 'Edit location', 'sptheme_admin' ),
							'update_item'   => __( 'Update location', 'sptheme_admin' ),
							'add_new_item'  => __( 'Add new location', 'sptheme_admin' ),
							'new_item_name' => __( 'New location title', 'sptheme_admin' )
						)
					) );			

	}
} // /sp_create_taxonomies

/*
*****************************************************
*	CHANGE DEFAULT TITLE FOR LISTING
*****************************************************
*/
if ( ! function_exists( 'sp_change_listing_title' ) ) {

	function sp_change_listing_title( $title ){
	
		$screen = get_current_screen();
	
		if ( $screen->post_type == 'sp_listing' )
			$title = __('Enter listing name here', 'sptheme_admin');
	
		return $title;
	
	}

}

add_filter('enter_title_here', 'sp_change_listing_title');


/*
*****************************************************
*	ADD META ICON
*****************************************************
*/

// Create meta edit form
if ( ! function_exists( 'edit_listing_type' ) ) {
	
	function edit_listing_type($tag, $taxonomy) {
		$icon = get_option( 'listing_type_'.$tag->term_id.'_icon', '' );
		$marker = get_option( 'listing_type_'.$tag->term_id.'_marker', '' );
		$excerpt = get_option( 'listing_type_'.$tag->term_id.'_excerpt', '' );
	
		?>
		<tr class="form-field">
	        <th scope="row" valign="top"><label for="listing_type_excerpt">Excerpt</label></th>
	        <td>
	            <textarea name="listing_type_excerpt" id="listing_type_excerpt" cols="30" rows="5"><?php echo $excerpt; ?></textarea>
	        </td>
	    </tr>
		<tr class="form-field">
	        <th scope="row" valign="top"><label for="listing_type_icon">Icon</label></th>
	        <td>
	            <input type="text" name="listing_type_icon" id="listing_type_icon" value="<?php echo $icon; ?>" style="width: 80%;"/>
	            <input type="button" value="Select Image" class="media-select" id="listing_type_icon_selectMedia" name="listing_type_icon_selectMedia" style="width: 15%;">
	            <br />
	            <p class="description">Icon for category</p>
	        </td>
	    </tr>
	    <tr class="form-field">
	        <th scope="row" valign="top"><label for="listing_type_marker">Map Marker</label></th>
	        <td>
	            <input type="text" name="listing_type_marker" id="listing_type_marker" value="<?php echo $marker; ?>" style="width: 80%;"/>
	            <input type="button" value="Select Image" class="media-select" id="listing_type_marker_selectMedia" name="listing_type_marker_selectMedia" style="width: 15%;">
	            <br />
	            <p class="description">Marker image in map for category</p>
	        </td>
	    </tr>
	    <?php
	}
	
}

// Create meta add form
if ( ! function_exists( 'add_listing_type' ) ) {

	function add_listing_type($tag) {
		?>
		<div class="form-field">
	        <label for="listing_type_excerpt">Excerpt</label>
	        <textarea name="listing_type_excerpt" id="listing_type_excerpt" cols="30" rows="5"></textarea>
	    </div>
		<div class="form-field">
			<label for="listing_type_icon">Icon</label>
			<input type="text" name="listing_type_icon" id="listing_type_icon" value="" style="width: 80%;"/>
	        <input type="button" value="Select Image" class="media-select" id="listing_type_icon_selectMedia" name="listing_type_icon_selectMedia" style="width: 15%;">
	            <br />
	            <p class="description">Icon for category</p>
		</div>
		<div class="form-field">
			<label for="listing_type_marker">Map Marker</label>
			<input type="text" name="listing_type_marker" id="listing_type_marker" value="" style="width: 80%;"/>
	        <input type="button" value="Select Image" class="media-select" id="listing_type_marker_selectMedia" name="listing_type_marker_selectMedia" style="width: 15%;">
	            <br />
	            <p class="description">Marker image in map for category</p>
		</div>
		<?php
	}

}
add_action( 'listing-type_edit_form_fields', 'edit_listing_type', 10, 2);
add_action( 'listing-type_add_form_fields', 'add_listing_type', 10, 2);

// Save meta values
if ( ! function_exists( 'save_listing_type' ) ) {
	
	function save_listing_type($term_id, $tt_id) {
	    if (!$term_id) return;
	
		if (isset($_POST['listing_type_excerpt'])){
			$name = 'listing_type_' .$term_id. '_excerpt';
			update_option( $name, $_POST['listing_type_excerpt'] );
		}
	
		if (isset($_POST['listing_type_icon'])){
			$name = 'listing_type_' .$term_id. '_icon';
			update_option( $name, $_POST['listing_type_icon'] );
		}
	
	    if (isset($_POST['listing_type_marker'])){
			$name = 'listing_type_' .$term_id. '_marker';
			update_option( $name, $_POST['listing_type_marker'] );
	    }
	}

}
add_action( 'created_listing-type', 'save_listing_type', 10, 2);
add_action( 'edited_listing-type', 'save_listing_type', 10, 2);

// Delete Meta values fields after delete category
if ( ! function_exists( 'delete_listing_type' ) ) {

	function delete_listing_type($id) {
		delete_option( 'listing_type_'.$id.'_excerpt' );
		delete_option( 'listing_type_'.$id.'_icon' );
		delete_option( 'listing_type_'.$id.'_marker' );
	}
	
}
add_action( 'deleted_term_taxonomy', 'delete_listing_type' );	


// Show meta values in table column
if ( ! function_exists( 'listing_type_columns' ) ) {

	function listing_type_columns($category_columns) {
		$new_columns = array(
			'cb'        		=> '<input type="checkbox" />',
			'name'      		=> __('Name', 'ait'),
			'description'     	=> __('Description', 'ait'),
			'item_excerpt'	    => __('Excerpt', 'ait'),
			'icon' 				=> __('Icon', 'ait'),
			'marker'			=> __('Marker', 'ait'),
			'slug'      		=> __('Slug', 'ait'),
			'posts'     		=> __('Items', 'ait'),
			);
		return $new_columns;
	}

}
add_filter("manage_edit-listing-type_columns", 'listing_type_columns');


// Render meta value into table column
if ( ! function_exists( 'manage_listing_type_columns' ) ) {

	function manage_listing_type_columns($out, $column_name, $cat_id) {
	
		$icon = get_option( 'listing_type_'.$cat_id.'_icon', '' );
		$marker = get_option( 'listing_type_'.$cat_id.'_marker', '' );
		$excerpt = get_option( 'listing_type_'.$cat_id.'_excerpt', '' );
	
		switch ($column_name) {
			case 'item_excerpt':
				if($excerpt && !empty($excerpt)){
					$out .= $excerpt;
				}
				break;
	 		case 'icon':
				if(!empty($icon)){
					$out .= '<img src="'.$icon.'" alt="" width="50" height="50">';
				}
	 			break;
	 		case 'marker':
				if(!empty($marker)){
					$out .= '<img src="'.$marker.'" alt="" width="50" height="50">';
				}
	 			break;
			default:
				break;
		}
		return $out;
	}

}
add_filter("manage_listing-type_custom_column", 'manage_listing_type_columns', 10, 3);

/*
function aitDirItemSortableColumns()
{
  return array(
    'title'=> 'title',
    'category'=> 'category'
  );
}
add_filter( "manage_edit-ait-dir-item_sortable_columns", "aitDirItemSortableColumns" );
*/
