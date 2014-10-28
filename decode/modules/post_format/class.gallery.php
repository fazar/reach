<?php
	class DC_post_format_gallery extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_post_gallery',
				'title' => 'Post Gallery',
				'post_type' => 'post',
				'fields' => array(
					array(
						'id' => 'as_slider',
						'title' => 'Display as Slider?',
						'subtitle' => 'Check this if you want to display the gallery as a slider',
						'type' => 'checkbox',
					),
				)
			);
		}
	}
?>