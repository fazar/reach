<?php
	class DC_tinymce_dialog_bootstrapper extends DC_bootstrapper{
		function __construct(){
			$this->instantiate('admin');
			$this->load_component();
		}

		function load_component(){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/component/class.component.bootstrapper.php' );
			return new DC_component_bootstrapper;
		}
	}
?>