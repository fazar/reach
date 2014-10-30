<?php
	class DC_profile_extras_bootstrapper extends DC_bootstrapper{
		function __construct(){
			$this->instantiate('admin');
		}
	}
?>