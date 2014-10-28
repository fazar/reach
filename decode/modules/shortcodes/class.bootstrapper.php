<?php
	class DC_shortcodes_bootstrapper extends DC_bootstrapper{
		function __construct(){
			$this->instantiate('audio');
			$this->instantiate('video');
			$this->instantiate('share');
		}
	}
?>