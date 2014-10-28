<?php
	class DC_post_format_bootstrapper extends DC_bootstrapper{
		function __construct(){	
			add_theme_support( 'post-thumbnails' );
			$this->instantiate('audio');
			$this->instantiate('quote');
			$this->instantiate('link');
			$this->instantiate('video');
			$this->instantiate('gallery');
			$this->instantiate('control');
		}
	}
?>