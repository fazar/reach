<?php
	class DC_slider_fields extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_slider_content',
				'title' => 'Slide Cotent',
				'post_type' => 'dc_slider',
				'fields' => array(
					array(
						'id' => 'image',
						'title' => 'Slide Image',
						'subtitle' => 'Upload your image slide',
						'type' => 'image',
					),
					array(
						'id' => 'mp4',
						'title' => 'Mp4 File',
						'subtitle' => 'Upload your mp4 file here',
						'type' => 'video'
					),
					array(
						'id' => 'ogv',
						'title' => 'Ogg File',
						'subtitle' => 'Upload your ogg file here',
						'type' => 'video'
					),
					array(
						'id' => 'title',
						'title' => 'Title',
						'subtitle' => 'Type your title here',
						'type' => 'text'
					),
					
					array(
						'id' => 'subtitle',
						'title' => 'Subtitle',
						'subtitle' => 'Enter your subtitle here',
						'type' => 'textarea'
					),

					array(
						'id' => 'button_1',
						'title' => 'Button Text 1',
						'subtitle' => 'Add the button here',
						'type' => 'text'
					),
					array(
						'id' => 'button_link_1',
						'title' => 'Button Link 1',
						'subtitle' => 'Add the button here',
						'type' => 'text'
					),
					array(
						'id' => 'button_2',
						'title' => 'Button Text 2',
						'subtitle' => 'Add the button here',
						'type' => 'text'
					),
					array(
						'id' => 'button_link_2',
						'title' => 'Button Link 2',
						'subtitle' => 'Add the button here',
						'type' => 'text'
					)
				)
			);
			$this->meta_boxes[] = array(
				'id' => 'dc_slider_options',
				'title' => 'General Settings',
				'context' => 'side',
				'post_type' => 'dc_slider',
				'fields' => array(
					array(
						'id' => 'alignment',
						'type' => 'radio',
						'title' => 'Alignment',
						'default' => 'center',
						'options' => array(
							'left' => 'Left',
							'center' => 'Center',
							'right' => 'Right'
						)
					),
					array(
						'id' => 'color_scheme',
						'type' => 'radio',
						'title' => 'Color Scheme',
						'default' => 'light',
						'options' => array(
							'light' => 'Light',
							'dark' => 'Dark'
						)
					),
					array(
						'id' => 'style_and_animation',
						'type' => 'radio',
						'title' => 'Style and Animation',
						'default' => 'group',
						'options' => array(
							'group' => 'Group',
							'per-element' => 'Per Element'
						)
					),
					array(
						'id' => 'caption_style',
						'type' => 'radio',
						'title' => 'Caption Style',
						'default' => 'regular',
						'options' => array(
							'regular' => 'Regular',
							'border' => 'Border',
							'background' => 'Background'
						)
					),
					array(
						'id' => 'caption_animation',
						'type' => 'radio',
						'title' => 'Caption Animation',
						'default' => 'move-up',
						'options' => array(
							'move-up' => 'Move Up',
							'fade-in' => 'Fade In'
						)
					)
				)
			);



			$this->meta_boxes[] = array(
				'id' => 'dc_slider_title',
				'title' => 'Title Settings',
				'post_type' => 'dc_slider',
				'fields' => array(
					array(
						'id' => 'style',
						'type' => 'custom',
						'title' => 'Style',
						'callback' => 'caption_style'
					),
					array(
						'id' => 'animation',
						'type' => 'custom',
						'title' => 'Animation',
						'callback' => 'caption_animation'
					),
				)
			);
			$this->meta_boxes[] = array(
				'id' => 'dc_slider_subtitle',
				'title' => 'Subtitle Settings',
				'post_type' => 'dc_slider',
				'fields' => array(
					array(
						'id' => 'style',
						'type' => 'custom',
						'title' => 'Style',
						'callback' => 'caption_style'
					),
					array(
						'id' => 'animation',
						'type' => 'custom',
						'title' => 'Animation',
						'callback' => 'caption_animation'
					),
				)
			);
			$this->meta_boxes[] = array(
				'id' => 'dc_slider_buttons',
				'title' => 'Buttons Settings',
				'post_type' => 'dc_slider',
				'fields' => array(
					array(
						'id' => 'style',
						'type' => 'custom',
						'title' => 'Style',
						'callback' => 'caption_style'
					),
					array(
						'id' => 'animation',
						'type' => 'custom',
						'title' => 'Animation',
						'callback' => 'caption_animation'
					),
				)
			);
		}

		function caption_style( $meta_box_id, $meta_value, $field ){
			$default_value = empty($field['default']) ? 'regular' : $field['default'] ;
			$field_value = empty($meta_value) || empty($meta_value[$field['id']]) ? $default_value : $meta_value[$field['id']] ;
			?>
				<tr>
					<td>
						<label><?php echo esc_html__( $field['title'], THEMENAME ) ?></label>
						<select  name="<?php echo $meta_box_id.'['.$field['id'] .']'; ?>" id="<?php echo $field['id'] ?>">
							<option value="regular" <?php selected($field_value, 'regular', true)  ?>><?php _e('Regular', THEMENAME) ?></option>
							<option value="border" <?php selected($field_value, 'border', true)  ?>><?php _e('Border', THEMENAME) ?></option>
							<option value="background" <?php selected($field_value, 'background', true)  ?>><?php _e('Background', THEMENAME) ?></option>
						</select>
					
			<?php
		}

		function caption_animation( $meta_box_id, $meta_value, $field ){
			$default_value = empty($field['default']) ? 'move-up' : $field['default'] ;
			$field_value = empty($meta_value) || empty($meta_value[$field['id']]) ? $default_value : $meta_value[$field['id']] ;
			?>
					<td>
						<label><?php echo esc_html__( $field['title'], THEMENAME ) ?></label>
						<select  name="<?php echo $meta_box_id.'['.$field['id'] .']'; ?>" id="<?php echo $field['id'] ?>">
							<option value="move-up" <?php selected($field_value, 'move-up', true) ?>><?php _e('Move Up', THEMENAME) ?></option>
							<option value="fade-in" <?php selected($field_value, 'fade-in', true) ?>><?php _e('Fade In', THEMENAME) ?></option>
						</select>
					</td>
				</tr>
			<?php
		}
	}
?>