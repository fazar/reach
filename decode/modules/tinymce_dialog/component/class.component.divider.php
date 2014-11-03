<?php 
	class DC_component_divider extends DC_component_base{
		function __construct(){
			$this->component_control = array('divider', __('Divider', THEMENAME) );
			parent::__construct();
		}

		function display_form(){			
			?>			
			<div id="divider">
				<h4><?php _e('Divider', THEMENAME) ?></h4>
				<table class="form-table">			
				    <tr>
						<td>
							<label><?php _e('Type', THEMENAME) ?></label>						
						</td>
						<td>
							<select name="divider-type" class='divider-type'>
								<option value="space" selected="selected"><?php _e('Space', THEMENAME) ?></option>
								<option value="horizontal"><?php _e('Horizontal', THEMENAME) ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label><?php _e('Height', THEMENAME) ?></label>						
						</td>
						<td>
							<input type='text' name="divider-height" class="divider-height" />
						</td>
					</tr>
					<tr class='horizontal-divider'>
						<td>
							<label><?php _e('Width', THEMENAME) ?></label>						
						</td>
						<td>
							<input type='text' name="divider-width" class="divider-width" />
						</td>
					</tr>
					<tr class='horizontal-divider'>
						<td>
							<label><?php _e('Background Color', THEMENAME) ?></label>						
						</td>
						<td>
							<input type='text' class='color-field' name="divider-color"/>
						</td>
					</tr>
					<tr class="last">
				    	<td colspan="2" class="submit-holder"><a class="button submit-divider button-primary">Add Shortcode</a></td>
				    </tr>
				</table>
			</div>
			<?php
		}
	}

?>