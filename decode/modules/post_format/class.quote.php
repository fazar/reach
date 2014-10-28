<?php
	class DC_post_format_quote extends DC_meta_boxes{
		function __construct(){
			parent::__construct();
		}

		function meta_boxes_config(){
			$this->meta_boxes[] = array(
				'id' => 'dc_post_quote',
				'title' => 'Post Quote',
				'post_type' => 'post',
				'fields' => array(
					array(
						'id' => 'content',
						'type' =>  'textarea',
						'title'=> 'Quote Content',
						'subtitle' => 'Insert the quote here',
					),
					array(
						'id' => 'author',
						'type' => 'text',
						'title' => 'Author',
						'subtitle' => 'The author of your quote'
					),
					array(
						'id' => 'quote_only',
						'type' => 'checkbox',
						'title' => 'Display Quote Only?',
						'subtitle' => 'Check this if you want to display only qoute'
					)
				)
			);
		}
	}
?>