<?php
	class DC_component_bootstrapper{
		function __construct(){
			$this->load( 'base' );
			$this->instantiate( 'row' );
			$this->instantiate( 'our_fields' );
			$this->instantiate( 'team_member' );
			$this->instantiate( 'accordion' );
			$this->instantiate( 'tabs' );
			$this->instantiate( 'highlight');
			$this->instantiate( 'divider');
		}
		static function load($class){
			$file_path = dirname(__FILE__);
			require_once( $file_path.'/class.component.'.$class.'.php' );
		}

		static function instantiate($class){
			DC_component_bootstrapper::load($class);
			$classname = 'DC_component_'.$class;
			return new $classname;
		}
	}
?>