<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Comm_Lines_Field' ) ) 
{
	class RWMB_Comm_Lines_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'thickbox' );
			wp_enqueue_style( 'rwmb-slider-slide', RWMB_CSS_URL . 'slider-slides.css', array(), RWMB_VER );

			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'rwmb-slider-slide', RWMB_JS_URL . 'comm-lines.js', array( 'jquery' ), RWMB_VER, true );
		}

		/**
		 * Show begin HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function begin_html( $html, $meta, $field )
		{
			$html = '';

			return $html;
		}

		/**
		 * Show end HTML markup for fields
		 *
		 * @param string $html
		 * @param mixed $meta
		 * @param array $field
		 *
		 * @return string
		 */
		static function end_html( $html, $meta, $field )
		{
			$html = '';

			return $html;
		}

		/**
		* Get field HTML
		*
		* @param $html
		* @param $field
		* @param $meta
		*
		* @return string
		*/
		static function html( $html, $meta, $field ) 
		{

			global $post;

			$id = $field['id'];

			$comm_lines = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="comm-lines">';
			
			if( $comm_lines ) {

				$html .= '<li class="postbox">
							<div class="inside">

								<div class="rwmb-field repeater">
								
								<div class="rwmb-label">
									<label>' . __('Communication Line', 'sptheme_admin') . '</label>
								</div><!-- end .rwmb-label -->
								
								<div class="rwmb-input">';
				print_r($comm_lines);
								
				foreach ( $comm_lines as $i => $line ) {	
						
					  $comm_attribute		= isset( $line['comm-attribute'] )		? $line['comm-attribute']		: null;
					  $comm_value			= isset( $line['comm-value'] )			? $line['comm-value']			: null;
									
					  $html .= '<div class="repeater">
									<select name="comm-attribute[]" class="rwmb-select">
										<option value="tel" ' . selected( $comm_attribute, "tel", false ) . '>' . __('Telephone', 'sptheme_admin') . '</option>
										<option value="mobile" ' . selected( $comm_attribute, "mobile", false ) . '>' . __('Mobile', 'sptheme_admin') . '</option>
										<option value="email" ' . selected( $comm_attribute, "email", false ) . '>' . __('E-mail', 'sptheme_admin') . '</option>
									</select>
									<input type="text" name="comm-value[]" class="rwmb-text" size="30" value="' . $comm_value .'">
									<button class="remove-element button-secondary">' . __('Remove', 'sptheme_admin') . '</button>									
								</div><!-- end .repeater -->';
				}				
					  $html .= '<button class="add-element button-primary">' . __('Add New Line', 'sptheme_admin') . '</button>
								</div><!-- end .rwmb-input -->
								
							</div><!-- end .rwmb-field -->

								
								
								<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
						
							</div><!-- end .inside -->
							
						</li>';
			} else {
						
				$html .= '<li class="postbox">
							<div class="inside">

								<div class="rwmb-field repeater">
								
								<div class="rwmb-label">
									<label>' . __('Communication Line', 'sptheme_admin') . '</label>
								</div><!-- end .rwmb-label -->
								
								<div class="rwmb-input">
								<div class="repeater">
									<select name="comm-attribute[]" class="rwmb-select">
										<option value="tel"  selected>' . __('Telephone', 'sptheme_admin') . '</option>
										<option value="mobile">' . __('Mobile', 'sptheme_admin') . '</option>
										<option value="email">' . __('E-mail', 'sptheme_admin') . '</option>
									</select>
									
									<input type="text" name="comm-value[]" class="rwmb-text" size="30" value="">
									<button class="remove-element button-secondary">' . __('Remove', 'sptheme_admin') . '</button>									
								</div><!-- end .repeater -->
								
								<button class="add-element button-primary">' . __('Add New Line', 'sptheme_admin') . '</button>
								</div><!-- end .rwmb-input -->
								
							</div><!-- end .rwmb-field -->

								
								
								<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
						
							</div><!-- end .inside -->
							
						</li>';
			}						

			$html .= '</ul><!-- end #comm_lines -->

					  <input type="hidden" name="comm-meta-info" value="' . $post->ID . '|' . $id . '">';

			return $html;
		}

		/**
		 * Save Comm Line
		 *
		 * @param mixed $new
		 * @param mixed $old
		 * @param int $post_id
		 * @param array $field
		 *
		 * @return void
		 */
		static function save( $new, $old, $post_id, $field )
		{
				
			$name = $field['id'];

			$comm_lines = array();
			
			foreach( $_POST[$name] as $k => $v ) {

				$comm_lines[] = array(
					'comm-attribute'            => $_POST['comm-attribute'][$k],
					'comm-value'        		=> $_POST['comm-value'][$k]
				);

			}

			$new = $comm_lines;

			update_post_meta( $post_id, $name, $new );

		}
	}
}