<?php
	class DC_shortcodes_our_fields{
		function __construct(){
			add_shortcode('dc_our_fields', array($this, 'display'));
		}

		function display(  $attr, $content ){
			extract(shortcode_atts(array( 'is_active' => '0', 'desc' => '', 'title' => '', 'icon' => ''),$attr));
			$class = '';
			if($is_active == '1'){
				$class='active';
			}
			return "<div class='our-fields-wrapper $class'><i class='$icon our-fields'></i><h3 class='our-fields-title'>$title</h3><p class='our-fields-desc'>$desc</p></div>";
		}
	}
?>