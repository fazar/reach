<?php
	class DC_visual_composer_bootstrapper extends DC_bootstrapper{
		function __construct(){
			$this->instantiate('fullwidth_section');
		}

		function instantiate( $class ){
			$this->load($class);
			$classname = str_replace( 'bootstrapper', $class, get_class($this) );
			$classname = str_replace( 'visual_composer', 'vc', $classname);
			return new $classname;
		}
	}
?>