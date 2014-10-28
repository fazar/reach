<?php
	/** array structure for meta_boxes 
	* 	array(
	*		'post_type' => 'page' 
	*			// if post_type == null or not defined then it's not for specific psot type
	*		'id' => 'id'
	*		'context' => 'context',
	*		'priority' => 'priority',
	*		'title' => 'title',
	*		'fields' => array(
	*			array(
	*				'id' => 'id',
	*				'title' => 'title',
	*				'subtitle' => 'subtitle',
	*				'type' => 'type of field',
	*				'default' => 'default-value',
	*				'options' => array(
	*					'value' => 'label'
	*				)
	*			)
	*		)
	*	)
	*/
	abstract class DC_meta_boxes{

		protected $meta_boxes = array();

		function __construct(){
			$this->meta_boxes_config();
			add_action("add_meta_boxes", array($this, 'add_meta_boxes'));
			add_action('save_post', array( $this, 'save' ) );
		}

		abstract function meta_boxes_config();

		function add_meta_boxes(){
			$default = array(
				'context' => 'normal',
				'priority' => 'core',
				'post_type' => 'page'
			);
			foreach ($this->meta_boxes as $key => $meta_box) {
				$merge_metabox = array_merge( $default, $meta_box );
				add_meta_box( $merge_metabox['id'], 
					esc_html__($merge_metabox['title'], THEMENAME),
					array($this, 'render_meta_box' ),
					$merge_metabox['post_type'],
					$merge_metabox['context'],
					$merge_metabox['priority']
				);
			}
		}

		function render_meta_box($post, $meta_box){
			wp_nonce_field( $meta_box['id'], $meta_box['id'].'_nonce' );
	        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post->ID;
			$meta_value = get_post_meta( $post->ID, '_' . $meta_box['id'], true );
			$current_meta_box = array();
			foreach ($this->meta_boxes as $key => $mb) {
				if($mb['id'] == $meta_box['id']){
					$current_meta_box = $mb;
					break;
				}
			}
			?>
			<table class="form-table">
				<?php 
					foreach ($current_meta_box['fields'] as $key => $field) {
						if($field['type'] == 'custom'){
							call_user_func(array($this, $field['callback']), $meta_box['id'], $meta_value, $field);
						}else{
							$this->render_field($meta_box['id'], $meta_value, $field );
						}
					} 
				?>
			</table>
			<?php
		}

		function render_field( $meta_box_id, $meta_value, $field ){
			$default_value = empty($field['default']) ? '' : $field['default'] ;
			$field_value = empty($meta_value) || empty($meta_value[$field['id']]) ? $default_value : $meta_value[$field['id']] ;
			?>
				<tr>
					<td>
						<label><?php echo esc_html__( $field['title'], THEMENAME ) ?></label>
					</td>
					<td>
						<?php
							 switch ($field['type']) {
							 	case 'text':
							 		echo '<input type="text" class="widefat" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" value="'.$field_value.'" />';
							 		break;
							 	
							 	case 'radio':
							 		foreach ($field['options'] as $value => $label) {
							 			echo '<input  type="radio"  name="'.$meta_box_id.'['.$field['id'] .']"  value="'.$value.'" '.checked($field_value, $value, false).' />'. __($label, THEMENAME). '<br/>';
							 		}
							 		break;
							 	case 'checkbox' :
							 		echo '<input type="checkbox" name="'.$meta_box_id.'['.$field['id'] .']"  value="1" '. checked( $field_value, '1', false ) .' />';
							 		break;
							 	case 'textarea':
							 		echo '<textarea rows="4" class="widefat" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" >'.$field_value.'</textarea>';
							 		break;
							 	case 'color' :
							 		DC::admin_resolves( array( 'wp-color-picker' ) );
							 		echo '<input type="text" class="color-picker" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" value="'.$field_value.'" />';
							 		break;
							 	case 'image':
							 		DC::admin_resolves( array( 'media-uploader' ) );
		 							echo '<div class="image-preview">';
		 							echo empty($field_value) ? '' : '<img style="width:100%;height:auto;" src="'.$field_value.'" />';
		 							echo '</div>';
		 		        			echo '<input type="hidden" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" value="'.$field_value.'" />';
		 							echo '<input type="button" class="button image-button" value="'. __( 'Upload', THEMENAME ). '" />';
		 							echo '<input type="button" class="button remove-button" value="'.__( 'Remove', THEMENAME ).'" />';
							 		break;
							 	case 'audio' :
							 		DC::admin_resolves( array( 'media-uploader' ) );
						 			echo '<input type="text" class="widefat" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" value="'.$field_value.'" />';
									echo '<input type="button" class="button audio-button" value="'. __( 'Add Media', THEMENAME ). '" />';
							 		break;
							 	case 'video' :
							 		DC::admin_resolves( array( 'media-uploader' ) );
							 		echo '<input class="widefat" type="text" name="'.$meta_box_id.'['.$field['id'] .']" id="'.$field['id'].'" value="'.$field_value.'" />';
									echo '<input type="button" class="button video-button" value="'. __( 'Add Media', THEMENAME ). '" />';
							 }
						?>
					</td>
				</tr>
			<?php
		}

		function save( $post_id ){
			$nonce_break = false;
			foreach ($this->meta_boxes as $key => $meta_box) {
				if ( ! isset( $_POST[$meta_box['id'].'_nonce'] ) ){
					$nonce_break = true;
			  		continue;
				}

				$nonce = $_POST[$meta_box['id'].'_nonce'];

				 // Verify that the nonce is valid.
				 if ( ! wp_verify_nonce( $nonce, $meta_box['id'] ) ){
					$nonce_break = true;
					continue;				 	
				 }

				
				update_post_meta( $post_id, '_'.$meta_box['id'], $_POST[$meta_box['id']] );
			}
			if($nonce_break) return $post_id;
		}

		
	}
?>