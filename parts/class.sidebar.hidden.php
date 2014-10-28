<?php
	class RH_sidebar_hidden extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action('rh_after_footer', array($this, 'display'));
			// add_filter('wp_nav_menu_items',array($this, 'toggle') );
		}
		function display(){
			$options = $this->options;
			$color = !empty( $options['dc_hidden-sidebar_color'] ) ? $options['dc_hidden-sidebar_color'] : 'light-color';
			// if(array_key_exists('dc_hidden-sidebar', $options) && $options['dc_hidden-sidebar']){
				$position = !empty( $options['dc_hidden-sidebar_position'] ) ?
					 $options['dc_hidden-sidebar_position'] : 'left';
				?>
				<aside class="off-sidebar <?php echo $color ?> <?php echo $position ?>-pos">
					<div class="main-navigation">
					<?php do_action( 'dc_menu', 'primary', 'center'); ?>
					</div>
					<div class="widgets-area">
					<?php
					if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('hidden-sidebar')) :
						echo '<p>there is not any widgets registered</p>';
					endif;
					?>
					</div>
				</aside>
				<?php
			// }
		}

		// function toggle($items){
		// 	$options = $this->options;
		// 	if(array_key_exists('dc_hidden-sidebar', $options) && $options['dc_hidden-sidebar']){
		// 		$position = !empty( $options['dc_hidden-sidebar_position'] ) ?
		// 			 $options['dc_hidden-sidebar_position'] : 'right';
		// 		if($position == 'right'){
		// 			return $items.'<li class="hidden-sidebar-toggle">
		//                   <a href="#" class="off-sidebar-control right-off-sidebar">
		//                     <span class="bar">
		//                     <span class="icon-bar"></span>
		//                     <span class="icon-bar"></span>
		//                     <span class="icon-bar"></span>
		//                     </span>
		//                   </a>
		//                 </li>';
		// 		}else{
		// 			return '<li class="hidden-sidebar-toggle">
		//                   <a href="#" class="off-sidebar-control left-off-sidebar">
		//                     <span class="bar">
		//                     <span class="icon-bar"></span>
		//                     <span class="icon-bar"></span>
		//                     <span class="icon-bar"></span>
		//                     </span>
		//                   </a>
		//                 </li>'.$items;
		// 		}
		// 	}
		// 	return $items;
		// }
	}
?>