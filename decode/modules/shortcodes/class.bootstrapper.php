<?php
	class DC_shortcodes_bootstrapper extends DC_bootstrapper{
		function __construct(){
			$this->instantiate('audio');
			$this->instantiate('video');
			$this->instantiate('share');
			$this->instantiate('row');
			$this->instantiate('team_member');
			$this->instantiate('our_fields');
			$this->instantiate('accordion');
			$this->instantiate('tabs');
		}
	}
?>