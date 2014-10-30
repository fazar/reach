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
			add_filter( 'excerpt_length', array($this, 'custom_excerpt_length'), 999 );
			add_filter('excerpt_more', array($this, 'new_excerpt_more'), 999);
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
					'post_options',
					'post_format',
					'shortcodes',
					'tinymce_dialog',
					'profile_extras'
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
			$this->load_part( array('header', 'main') );
			$this->load_part( array('sidebar', 'hidden') );
			$this->load_part( array('content', 'main') );
			$this->load_part( array('footer', 'main') );
			$this->load_part( array('contact', 'main') );
		}

		function add_image_sizes(){
			add_image_size( 'dc-medium', 695, 350, array('center', 'center'));
			add_image_size( 'dc-small', 385, 350, array('center', 'center'));
			add_image_size( 'landscape', 600, 185, array('center', 'center') );
			add_image_size( 'main-thumbnail', 600);
		}

		function fire_bootstrapper(){
			require_once(DC_BASE . 'bootstrapper/class.public.resolves.php');
			new RH_public_resolves;
		}

		function custom_excerpt_length( $length ) {
			return 30;
		}

		function new_excerpt_more( $more ) {
			return ' ...';
		}

	}
	new Reach;
	