<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'RWMB_Open_Hour_Field' ) ) 
{
	class RWMB_Open_Hour_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			$url = RWMB_CSS_URL . 'jqueryui';
			wp_enqueue_style( 'jquery-timepicker', "{$url}/jquery.timepicker.css", array(), RWMB_VER );
			wp_enqueue_style( 'rwmb-slider-slide', RWMB_CSS_URL . 'open-hour.css', array(), RWMB_VER );
			
			$url = RWMB_JS_URL . 'jqueryui';
			wp_register_script( 'jquery-ui-timepicker', "{$url}/jquery.timepicker.min.js", array(), RWMB_VER, true );
			wp_enqueue_script( 'rwmb-time', RWMB_JS_URL.'open-hour.js', array( 'jquery-ui-timepicker' ), RWMB_VER, true );
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

			global $post, $openHourAttr;

			$id = $field['id'];

			$open_hours = get_post_meta( $post->ID, $id, true ) ? get_post_meta( $post->ID, $id, true ) : false;

			$html = '<ul id="open-hours" class="postbox">';

				if( $open_hours ) {

					foreach ( $open_hours as $i => $line ) {

						$day_select			= isset( $line['day-select'] )	? $line['day-select']		: null;
						switch($day_select){
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
						$start_hour			= isset( $line['start-hour'] )	? $line['start-hour']		: null;
						$end_hour			= isset( $line['end-hour'] )	? $line['end-hour']			: null;
						
						$html .= '<li class="time-line">
									<div class="inside">
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Hour', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="200"><span>' . $day_attr . ': ' . $start_hour . ' - ' . $end_hour . '</span></td>
												<td width="110">
												<select name="day-select[]" class="rwmb-select">';
										foreach ($openHourAttr as $key => $value) :
											$html .= '<option value="' . $key . '" ' . selected( $day_select, $key, false ) . '>' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="start-hour[]" class="rwmb-text rwmb-time" size="10" value="' . $start_hour . '"></td>
												<td width="95"><input type="text" name="end-hour[]" class="rwmb-text rwmb-time" size="10" value="' . $end_hour . '"></td>
												<td width="20"><button class="remove-hour button-secondary">' . __('Remove hour', 'sptheme_admin') . '</button></td>
												</tr>
											</table>
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->

										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

					}

				} else {


						$html .= '<li class="time-line">
									<div class="inside">
												
										<div class="rwmb-field">

											<div class="rwmb-label">
												<label>' . __('Hour', 'sptheme_admin') . '</label>
											</div><!-- end .rwmb-label -->

											<div class="rwmb-input">
											<table>
												<tr>
												<td width="200"><span>Always open</span><span> 8:00am - 10:00pm</span></td>
												<td width="110">
												<select name="day-select[]" class="rwmb-select">';
										foreach ($openHourAttr as $key => $value) :
											$html .= '<option value="' . $key . '">' . $value . '</option>';
										endforeach;	
										$html .= '</select>
												</td>
												<td width="95"><input type="text" name="start-hour[]" class="rwmb-text rwmb-time" size="10" value=""></td>
												<td width="95"><input type="text" name="end-hour[]" class="rwmb-text rwmb-time" size="10" value=""></td>
												<td width="20"><button class="remove-hour button-secondary">' . __('Remove hour', 'sptheme_admin') . '</button><td>
												</tr>
											</table>	
											</div><!-- end .rwmb-input -->

										</div><!-- end .rwmb-field -->
								
										
										<input type="hidden" name="' . $id . '[]" class="rwmb-text" size="30" value="">
								
									</div><!-- end .inside -->
									
								</li>';

				}

				$html .= '</ul><!-- end #open-hours -->
							
						  <p> <button id="add-time-line" class="button-primary">' . __('+ Add Hour', 'sptheme_admin') . '</button> </p>

						  <input type="hidden" name="open-hour-meta-info" value="' . $post->ID . '|' . $id . '">';

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

			$open_hours = array();
			
			foreach( $_POST[$name] as $k => $v ) {

				$open_hours[] = array(
					'day-select'      => $_POST['day-select'][$k],
					'start-hour'      => $_POST['start-hour'][$k],
					'end-hour'        => $_POST['end-hour'][$k]
				);

			}

			$new = $open_hours;

			update_post_meta( $post_id, $name, $new );

		}
	}
}