<?php
	class DC_post_format_video extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_post_video',
				'title' => 'Post Video',
				'post_type' => 'post',
				'fields' => array(
					array(
						'id' => 'm4v',
						'type' => 'video',
						'title' => 'M4v File',
						'subtitle' => 'Upload your mp4/m4v file here'
					),
					array(
						'id' => 'ogv',
						'type' => 'video',
						'title' => 'OGV File',
						'subtitle' => 'Uplaod your ogv file here'
					),
					array(
						'id' => 'poster',
						'type' => 'image',
						'title' => 'Poster',
						'subtitle' => 'Upload the poster of video here'
					),
					array(
						'id' => 'embedded',
						'type' => 'textarea',
						'title' => 'Embedded code',
						'subtitle' => 'Insert the embedded code for video player here'
					)
				)
			);
		}
	}
?>