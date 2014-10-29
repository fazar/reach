<?php 
	class DC_component_team_member extends DC_component_base{
		function __construct(){
			$this->component_control = array('team-member', __('Team Member', THEMENAME) );
			parent::__construct();
		}

		function display_form(){
			DC::admin_resolves( array( 'media-uploader' ) );
			?>
			<div id="team-member">
				<h4><?php _e('Team Member', THEMENAME) ?></h4>
				<table class="form-table">
					<tr>
						<th>
							<label><?php echo  _e('Preview Image', THEMENAME) ?></label>
						</th>
						<td>
							<div id="member-preview-image"></div>
		        			<input  type="hidden" name="member-photo" id="member-photo" />
							<input type="button" class="button image-button" value="<?php _e( 'Upload', THEMENAME )?>" />
							<input type="button" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />
						</td>
					</tr>
					<tr>
						<th><label><?php echo _e('Position', THEMENAME) ?></label></th>
						<td>
							<input  class="widefat" type="text" name="position" class="position" />
						</td>
					</tr>
					<tr>
						<th><label><?php echo _e('Name', THEMENAME) ?></label></th>
						<td>
							<input class="widefat" type="text" name="name" class="name" />
						</td>
					</tr>
				    <tr class="last">
				    	<td colspan="2" class="submit-holder"><a class="button submit-team-member button-primary">Add Shortcode</a></td>
				    </tr>
				</table>
			</div>
			<?php
		}
	}
?>