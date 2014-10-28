<?php
	class RH_footer_main extends DC_parts_base {
		function __construct() {
			parent::__construct();
			add_action( 'rh_main_footer', array( $this, 'display_main_footer') );
			//add_action( 'widgets_init', array( $this, 'register_widget_area' ) );
		}

		/*function register_widget_area(){
			$footer_columns = $this->get_footer_columns();
			for ($i=1; $i <= $footer_columns ; $i++) { 
				register_sidebar(array(
					'name' => 'footer_' . $i,
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
					));
			}
		}*/

		function display_main_footer() {
			$options = $this->options;
			if( !(!empty( $options['enable-main-footer-area'] ) && $options['enable-main-footer-area']) )
				return;			
			
			?>
			<div class="main-footer first-row">
				<?php do_action('social_in', 'footer'); ?>
				<div class="row">

					<div class="large-offset-4 large-8 medium-8 large-offset-2 columns">
						<?php $this->display_copyright(); ?>
						
					</div>
					
				</div>
			</div>


			<?php
		}

		private function display_copyright(){
			$options = $this->options;
	 		?><div class="copyright"><?php
					if(!empty($options['footer-copyright-text'])){
						echo $options['footer-copyright-text'];
					}else{
						echo ' &copy; '.get_bloginfo('name'). ' . '. date("Y"); 
					}
			?></div><?php
		}
	}
?>