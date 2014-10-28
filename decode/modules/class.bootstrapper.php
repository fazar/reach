<?php
	class DC_bootstrapper{
		function load( $class ){
		  	$rc = new ReflectionClass(get_class($this));
			$file_path = dirname($rc->getFileName());
			require_once( $file_path.'/class.' . $class . '.php'  );
		}

		function instantiate( $class ){
			$this->load($class);
			$classname = str_replace( 'bootstrapper', $class, get_class($this) );
			return new $classname;
		}
	}
?>