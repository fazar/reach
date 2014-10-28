<?php 
	/**
	* Fires the theme : constants definition, core classes loading
	*
	* 
	* @package      Reach
	* @subpackage   classes
	* @since        1.0
	* @author       Decode PDF <decode.pdf@gmail.com>
	* @copyright    Copyright (c) 2014, Decode PDF
	* @link         http://decodepdf.com/helium
	* @license      http://www.gnu.org/licenses/gpl-3.0.html
	*/
	require_once( dirname(__FILE__). '/decode/functions.php' );
	class Reach extends DC{
		function __construct(){
			parent::__construct();
			$this->add_image_sizes();
			$this->fire_bootstrapper();
		}

		function define_config(){
			$config = array(
				'class-prefix' => 'RH_',
				'admin-class' => 'reach_admin_config',
				'include-widgets' => array(
					'about',
					'popular_posts',
					'recent_comments',
					'instagram',
					'recent_posts'
				),
				'nav-menus' => array(
					'primary' => __( 'Primary Menu', THEMENAME ),
					'footer' => __( 'Footer Menu', THEMENAME )
				),
				'sidebar-widget-areas' => array(
    				array(
    					'name' => __( 'Main Sidebar', THEMENAME),
    					'id' => 'main-sidebar'
    				),
    				array(
    					'name' => __( 'Hidden Sidbar', THEMENAME ),
    					'id' => 'hidden-sidebar'
    				)		
    			),
    			'include-modules' => array(
					'page_options',
					'post_format',
					'shortcodes'
				),
				'include-parts' => array(
					'header',
					'footer',
					'content',
					'comment',
					'social',
					'slider'
				),
				'global-options' => 'reach',
			);
			$this->config = array_merge( $this->config, $config );
		}

		function load_parts(){
		}

		function add_image_sizes(){

		}

		function fire_bootstrapper(){
			require_once(DC_BASE . 'bootstrapper/class.public.resolves.php');
			new RH_public_resolves;
		}
	}
	new Reach;
	