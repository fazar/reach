<?php
	class DC_page_options_header extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
					'id' => 'dc_page_header',
					'title' => 'Page Header Options',
					'fields' => array(
						array(
							'id' => 'background_img',
							'title' => 'Background Image',
							'subtitle' => 'Upload an image media if you want to display a hedaer with background image',
							'type' => 'image',
						),
						array(
							'id' => 'background_video',
							'title' => 'Background Video',
							'subtitle' => 'Upload a video media if you want to display a header with video background',
							'type' => 'video'
						),
						array(
							'id' => 'title',
							'title' => 'Page Title',
							'type' => 'text',
						),
						array(
							'id' => 'subtitle',
							'title' => 'Page Subtitle',
							'type' => 'textarea'
						),
						array(
							'id' => 'contoh_warna',
							'title' => 'Contoh Warna',
							'type' => 'color'
						),
						array(
							'id' => 'color_scheme',
							'title' => 'Color Scheme',
							'subtitle' => 'Choose the color scheme of you caption',
							'type' => 'radio',
							'default' => 'light',
							'options' => array(
								'light' => 'Light',
								'dark' => 'Dark'
							)
						),
						array(
							'id' => 'align',
							'title' => 'Text Alignment',
							'subtitle' => 'Determine the alignment for yor heading text',
							'type' => 'radio',
							'default' => 'center',
							'options' => array(
								'left' => 'Left',
								'center' => 'Center',
								'right' => 'Right'
							)
						),
						array(
							'id' => 'display',
							'title' => 'Display Type',
							'subtitle' => 'Determine the display type of your header area',
							'type' => 'radio',
							'default' => 'fullscreen',
							'options' => array(
								'fullscreen' => 'Fullscreen',
								'halfscreen' => 'Halfscreen'
							)
						)
					)
			);
		}
	}
?>