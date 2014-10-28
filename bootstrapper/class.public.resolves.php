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
				wp_enqueue_style( 'reach', get_stylesheet_uri(), array() );
			}
		}

		function register_scripts(){

		}

		function resolve_main_scripts(){
		}

		function load_scripts(){

		}
	}
?>