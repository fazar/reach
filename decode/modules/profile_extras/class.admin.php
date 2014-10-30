<?php
	class DC_profile_extras_admin{
		function __construct(){
			add_action('show_user_profile', array( $this, 'profile_image' ) );
			add_action('show_user_profile', array( $this, 'social_accounts' ) );
			add_action('personal_options_update', array( $this, 'profile_update' ) );
		}

		function social_accounts(){
			global $user_ID;
			$social_accounts = get_user_meta($user_ID, "social_accounts");
			if(is_array($social_accounts))
			        $social_accounts = $social_accounts[0];
			$maps = array( 
				'facebook' => 'Facebook',
				'twitter' => 'Twitter',
				'google-plus' => 'Google Plus',
				'vimeo' => 'Vimeo',
				'dribbble ' => 'Dribbble',
				'pinterest' => 'Pinterest',
				'youtube' => 'Youtube',
				'thumblr' => 'Thumblr',
				'linkedin' => 'LinkedIn',
				'rss' => 'RSS',
				'flickr' => 'Flickr',
				'skype' => 'Skype',
				'behance' => 'Behance',
				'instagram' => 'Instagram',
				'github' => 'GitHub',
				'stack-exchange' => 'StackExchange',
				'soundcloud' => 'Soundcloud' 
			);
			?>
		    <h3><?php _e('Social Accounts', THEMENAME) ?></h3>
		    <table class="form-table">
		    <?php 
		    foreach ($maps as $account => $label) {
		    	$value = !empty($social_accounts[$account]) ? $social_accounts[$account] : '';
		    	?>
		    	<tr>
		            <th><label for="social_accounts[<?php echo $account ?>]">
		            	<?php echo $label ?></label></th>
		            <td><input class="regular-text" type="text" id="social_accounts[<?php echo $account ?>]" 
		            name="social_accounts[<?php echo $account ?>]" 
		            value="<?php echo $value ?>" /><br />
		            <span class="description"><?php echo __('Enter your ', THEMENAME) . $label . __(' Address here', THEMENAME) ?></span></td>
		        </tr>
		    	<?php
		    }?>
		    </table>
		    <?php
		}

		function profile_update(){
			global $user_ID;
    		update_user_meta($user_ID, "social_accounts",$_POST['social_accounts']);
    		update_user_meta($user_ID, "profile_image",$_POST['profile_image']);  
		}

		function profile_image(){
			DC::admin_resolves( array('media-uploader') );
			global $user_ID;
			$profile_image = get_user_meta($user_ID, "profile_image", true);
			?>
			<h3><?php _e('Profile image', THEMENAME) ?></h3>
		    <table class="form-table">
		    <tr>
		            <th>
		            	<label for="profile_image">
		            		<?php _e('Image', THEMENAME) ?>
		            	</label>
		            </th>
		            <td>
						<div id="member-preview-image"><?php
						 if(!empty( $profile_image )){
						 	echo "<img src='$profile_image' style='width:100%'/>";
						 } 
						?></div>
	        			<input  type="hidden" name="profile_image" id="profile_image" value="<?php echo $profile_image ?>"/>
						<input type="button" class="button image-button" value="<?php _e( 'Upload', THEMENAME )?>" />
						<input type="button" class="button remove-button" value="<?php _e( 'Remove', THEMENAME )?>" />	
		            </td>
		        </tr>
		    </table>
		    <?php
		}

	}
?>