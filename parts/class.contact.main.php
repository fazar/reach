<?php
	class RH_contact_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action('rh_contact', array($this, 'display_contact_page'));
		}

		function display_contact_page(){
			$options = $this->options;
			$blog_layout = 'std-with-sidebar';
			$blog_layout = !empty($options['blog_layout']) ? 
			$options['blog_layout'] : $blog_layout;
			$contact_form_label = !empty($options['contact_form_label']) ? $options['contact_form_label'] : '';
			$contact_title = !empty($options['contact_title']) ? $options['contact_title'] : '';
				?>
				<div class="row main-content" >
					<div class="large-8 medium-8 large-centered columns">
						<div class="map-wrapper">
							<div class="divider-contact-title"></div>
							<span class='contact-title'><?php echo $contact_title; ?></span>
							<?php do_action('dc_google_map') ?>
							<ul class="contact-us-attribute">
								<li><a><i class="fa fa-home"></i></a><span><?php echo !empty($options['contact_address']) ? $options['contact_address'] : ''; ?></span></li>
								<li><a><i class="fa fa-paper-plane"></a></i><span><?php echo !empty($options['email']) ? $options['email'] : ''; ?></span></li>
								<li><a><i class="fa fa-phone"></a></i><span><?php echo !empty($options['phone_number']) ? $options['phone_number'] : ''; ?></span></li>
							</ul>					
							
						</div>
					</div>	
					<div class="large-8 medium-8 large-centered columns">
						<ul>
							<li class='contact-form-label'><?php echo $contact_form_label ?></li>
						</ul>
					<?php 
						while(have_posts()) : the_post();
							the_content();
						endwhile; 
					?>
					</div>
									
				</div>
				<?php
		}

		function my_social_accounts( $curauth ){
			$social_accounts = get_user_meta($curauth->ID, "social_accounts");
			if(is_array($social_accounts)){
				$social_accounts = $social_accounts[0];
			}
			if(empty($social_accounts)) return; 
			echo "<ul>";
			foreach ($social_accounts as $key => $value) {
				$class = $key;
				if( $key == 'vimeo' ){
					$class .= '-square';
				}
				if( !empty($social_accounts[$key] )){
					echo '<li><a href="'.$value.'" class="'.$key.'">
	               		<i class="fa fa-'.$class.'"></i>
	               		</a></li>';
				}
			}
			echo "</ul>";
		}
	}
?>