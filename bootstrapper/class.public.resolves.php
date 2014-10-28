<?php
	class RH_public_resolves{
		function __construct(){
			add_action( 'wp_enqueue_scripts', array( $this , 'load_main_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'resolve_main_scripts') );
			add_action( 'wp_footer', array( $this, 'load_scripts' ) );
		}

		function load_main_styles(){
			if ( !is_admin() ){
				wp_register_style( 'foundation', DC_BASE_URL.'css/foundation.min.css' );
				wp_enqueue_style( 'reach', get_stylesheet_uri(), array('foundation') );
			}
		}

		function register_scripts(){
			wp_register_script( 'modernizr' ,DC_BASE_URL . 'js/vendor/modernizr.js' ,array( 'jquery' ), null, $in_footer = false);
			wp_register_script( 'foundation' ,DC_BASE_URL . 'js/foundation.min.js' ,array( 'jquery' ),null, $in_footer = true);
		}

		function resolve_main_scripts(){
			DC::resolves( array( 'modernizr' , 'foundation') );
		}

		function load_scripts(){
			if(!is_admin()){
				global $public_scripts;
				wp_enqueue_script( 'reach', DC_BASE_URL. 'js/reach.js', $public_scripts, null, $in_footer = true );
			}
		}
	}
?>