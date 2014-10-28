<?php
	class DC_post_format_audio extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_post_audio',
				'title' => 'Audio Post',
				'post_type' => 'post',
				'fields' => array(
					array(
						'id' => 'mp3',
						'type' => 'audio',
						'subtitle' => 'Upload your mp3 file here',
						'title' => 'MP3 file'
					),
					array(
						'id' => 'oga',
						'type' => 'audio',
						'subtitle' => 'Upload your oga file here',
						'title' => 'Oga file',
					),
					array(
						'id' => 'embedded',
						'type' => 'textarea',
						'title' => 'Embedded code',
						'subtitle' => 'Insert the embedded code for audio player here'
					)
				)
			);
		}
	}
?>