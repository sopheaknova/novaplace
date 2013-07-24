<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Contact_Info_Field' ) ) 
{
	class RWMB_Contact_Info_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-contact-info', RWMB_CSS_URL . 'contact-info.css', array(), RWMB_VER );
			wp_enqueue_script( 'rwmb-contact-info', RWMB_JS_URL.'contact-info.js', array(), RWMB_VER, true );
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

			global $post, $commLine;

			$id = $field['id'];

			$contact_infos = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="contact-infos" class="postbox">';

				if( $contact_infos ) {

					foreach ( $contact_infos as $i => $line ) {

						$comm_type			= isset( $line['comm-type'] )		? $line['comm-type']		: null;
						$comm_value			= isset( $line['comm-value'] )		? $line['comm-value']		: null;
						
						
						$html .= '<li class="comm-line">
									<div class="inside">
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Comm line', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="110">
												<select name="comm-type[]" class="rwmb-select">';
										foreach ($commLine as $key => $value) :
											$html .= '<option value="' . $key . '" ' . selected( $comm_type, $key, false ) . '>' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="comm-value[]" class="rwmb-text" size="30" value="' . $comm_value . '"></td>
												<td width="20"><button class="remove-comm-line button-secondary">' . __('Remove line', 'sptheme_admin') . '</button><td>
												</tr>
											</table>
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->

										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

					}

				} else {


						$html .= '<li class="comm-line">
									<div class="inside">
												
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Comm line', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="110">
												<select name="comm-type[]" class="rwmb-select">';
										foreach ($commLine as $key => $value) :
											$html .= '<option value="' . $key . '">' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="comm-value[]" class="rwmb-text" size="30" value=""></td>
												<td width="20"><button class="remove-comm-line button-secondary">' . __('Remove line', 'sptheme_admin') . '</button><td>
												</tr>
											</table>	
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->
								
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

				}

				$html .= '</ul><!-- end #open-hours -->
							
						  <p> <button id="add-comm-line" class="button-primary">' . __('+ Add Comm Line', 'sptheme_admin') . '</button> </p>

						  <input type="hidden" name="contact-info-meta-info" value="' . $post->ID . '|' . $id . '">';

			return $html;
		}

		/**
		 * Save slides
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

			$contact_infos = array();
			
			foreach( $_POST[$name] as $k => $v ) {

				$contact_infos[] = array(
					'comm-type'      => $_POST['comm-type'][$k],
					'comm-value'      => $_POST['comm-value'][$k]
				);

			}

			$new = $contact_infos;

			update_post_meta( $post_id, $name, $new );

		}
	}
}