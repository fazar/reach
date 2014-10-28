<?php
	class DC_post_format_link extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_post_link',
				'title' => 'Post Link',
				'post_type' => 'post',
				'fields' => array(
					array(
						'id' => 'url',
						'title' => 'Link URL',
						'subtitle' => 'Put the link url here',
						'type' => 'text',
					),
					array(
						'id' => 'title',
						'title' => 'Link Title',
						'subtitle' => 'Enter the link title here',
						'type' => 'text'
					),
					array(
						'id' => 'link_only',
						'title' => 'Link Only',
						'subtitle' => 'Display Link Only',
						'type' => 'checkbox'
					)
				)
			);
		}
	}
?>