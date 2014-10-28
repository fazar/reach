<?php
	class DC_slider_bootstrapper extends DC_bootstrapper{
		
		function __construct(){
			$this->instantiate('admin');
			$this->instantiate('fields');
		}
	}
?>