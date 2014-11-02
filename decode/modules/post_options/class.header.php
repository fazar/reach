<?php
	class DC_post_options_header extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
					'id' => 'dc_post_header',
					'title' => 'Post Header Options',
					'post_type' => 'post',
					'fields' => array(
						array(
							'id' => 'subtitle',
							'title' => 'Subtitle',
							'type' => 'text',
						),
						array(
							'id' => 'header_position',
							'title' => 'Image Header Position',
							'type' => 'custom',
							'callback' => 'header_position',
							'default' => 'top center',
                            'options' => array(
                                'top center' => 'Top Center',
                                'top left' => 'Top Left',
                                'top right' => 'Top Right',
                                'center center' => 'Center Center',
                                'center left' => 'Center Left',
                                'center right' => 'Center Right',
                                'bottom center' => 'Bottom Center',
                                'bottom left' => 'Bottom Left',
                                'bottom right' => 'Bottom Right',
                            )
						),
						array(
							'id' => 'header_type',
							'title' => 'Header Display Type',
							'type' => 'custom',
							'callback' => 'header_type',
							'default' => 'full-screen',
                            'options' => array(
                                'full-screen' => 'Full Screen',
                                'half-screen' => 'Half Screen',
                                'no-image' => 'No Image'
                            )
						)						
					)
			);
		}

		function header_position( $meta_box_id, $meta_value, $field ){
			$default_value = empty($field['default']) ? 'top center' : $field['default'] ;
			$field_value = empty($meta_value) || empty($meta_value[$field['id']]) ? $default_value : $meta_value[$field['id']] ;
			?>
			<tr>
				<td>
					<label><?php echo esc_html__( $field['title'], THEMENAME ) ?></label>
				</td>
				<td>
					<select  name="<?php echo $meta_box_id.'['.$field['id'] .']'; ?>" id="<?php echo $field['id'] ?>">
							<option value="top center" <?php selected($field_value, 'top center', true)  ?>><?php _e('Top Center', THEMENAME) ?></option>
							<option value="top left" <?php selected($field_value, 'top left', true)  ?>><?php _e('Top Left', THEMENAME) ?></option>
							<option value="top right" <?php selected($field_value, 'top right', true)  ?>><?php _e('Top Right', THEMENAME) ?></option>
							<option value="center center" <?php selected($field_value, 'center center', true)  ?>><?php _e('Center Center', THEMENAME) ?></option>
							<option value="center left" <?php selected($field_value, 'center left', true)  ?>><?php _e('Center Left', THEMENAME) ?></option>
							<option value="center right" <?php selected($field_value, 'center right', true)  ?>><?php _e('Center Right', THEMENAME) ?></option>
							<option value="bottom center" <?php selected($field_value, 'bottom center', true)  ?>><?php _e('Bottom Center', THEMENAME) ?></option>
							<option value="bottom left" <?php selected($field_value, 'bottom left', true)  ?>><?php _e('Bottom Left', THEMENAME) ?></option>
							<option value="bottom right" <?php selected($field_value, 'bottom right', true)  ?>><?php _e('Bottom Right', THEMENAME) ?></option>

					</select>
				</td>
			<tr>
			<?php
		}

		function header_type( $meta_box_id, $meta_value, $field ){
			$default_value = empty($field['default']) ? 'full-screen' : $field['default'] ;
			$field_value = empty($meta_value) || empty($meta_value[$field['id']]) ? $default_value : $meta_value[$field['id']] ;
			?>
			<tr>
				<td>
					<label><?php echo esc_html__( $field['title'], THEMENAME ) ?></label>
				</td>
				<td>
					<select  name="<?php echo $meta_box_id.'['.$field['id'] .']'; ?>" id="<?php echo $field['id'] ?>">
							<option value="full-screen" <?php selected($field_value, 'full-screen', true)  ?>><?php _e('Full Screen', THEMENAME) ?></option>
							<option value="half-screen" <?php selected($field_value, 'half-screen', true)  ?>><?php _e('Half Screen', THEMENAME) ?></option>
							<option value="no-image" <?php selected($field_value, 'no-image', true)  ?>><?php _e('No Image', THEMENAME) ?></option>							
					</select>
				</td>
			<tr>
			<?php
		}

	}
?>