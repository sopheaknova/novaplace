<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Social_Network_Field' ) ) 
{
	class RWMB_Social_Network_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'rwmb-social-network', RWMB_CSS_URL . 'social-network.css', array(), RWMB_VER );
			wp_enqueue_script( 'rwmb-social-network', RWMB_JS_URL.'social-network.js', array(), RWMB_VER, true );
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

			global $post, $socialNetwork;

			$id = $field['id'];

			$social_network = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="social-network" class="postbox">';

				if( $social_network ) {

					foreach ( $social_network as $i => $line ) {

						$social_select			= isset( $line['social-select'] )	? $line['social-select']		: null;
						$social_link			= isset( $line['social-link'] )		? $line['social-link']			: null;
						
						
						$html .= '<li class="social-link">
									<div class="inside">
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Social link', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="110">
												<select name="social-select[]" class="rwmb-select">';
										foreach ($socialNetwork as $key => $value) :
											$html .= '<option value="' . $key . '" ' . selected( $social_select, $key, false ) . '>' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="social-link[]" class="rwmb-text" size="50" value="' . $social_link . '"></td>
												<td width="20"><button class="remove-social-link button-secondary">' . __('Remove Social', 'sptheme_admin') . '</button><td>
												</tr>
											</table>
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->

										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

					}

				} else {


						$html .= '<li class="social-link">
									<div class="inside">
												
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Social link', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="110">
												<select name="social-select[]" class="rwmb-select">';
										foreach ($socialNetwork as $key => $value) :
											$html .= '<option value="' . $key . '">' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="social-link[]" class="rwmb-text" size="50" value=""></td>
												<td width="20"><button class="remove-social-link button-secondary">' . __('Remove Social', 'sptheme_admin') . '</button><td>
												</tr>
											</table>	
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->
								
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

				}

				$html .= '</ul><!-- end #open-hours -->
							
						  <p> <button id="add-social-link" class="button-primary">' . __('+ Add Social Link', 'sptheme_admin') . '</button> </p>

						  <input type="hidden" name="social-network-meta-info" value="' . $post->ID . '|' . $id . '">';

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

			$social_network = array();
			
			foreach( $_POST[$name] as $k => $v ) {

				$social_network[] = array(
					'social-select'      => $_POST['social-select'][$k],
					'social-link'      => $_POST['social-link'][$k]
				);

			}

			$new = $social_network;

			update_post_meta( $post_id, $name, $new );

		}
	}
}