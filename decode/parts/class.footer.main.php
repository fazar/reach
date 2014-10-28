<?php
	class DC_footer_main extends DC_parts_base{
		function __construct(){
			parent::__construct();
			add_action( 'dc_copyright', array( $this, 'display_copyright' ) );
		}

		function display_copyright(){
			$options = $this->options;
			if(!empty($options['dc_copyright'])){
				echo $options['dc_copyright'];
			}else{
				echo date("Y").' &copy; '.get_bloginfo('name'); 
			}
		}
	}
?>