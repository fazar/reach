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
				wp_register_style( 'fontawesome', DC_BASE_URL.'css/font-awesome.min.css' );
				wp_register_style( 'flexslider', DC_BASE_URL.'css/flexslider.css' );
				wp_register_style( 'mediaplayer', DC_BASE_URL.'css/mediaelement/mediaelementplayer.min.css');
				wp_register_style( 'foundation', DC_BASE_URL.'css/foundation.min.css' );
				wp_enqueue_style( 'reach', get_stylesheet_uri(), array('foundation', 'flexslider', 'mediaplayer', 'fontawesome') );
			}
		}

		function register_scripts(){
			wp_register_script( 'imagesloaded', DC_BASE_URL . 'js/imagesloaded.pkgd.min.js', array( 'jquery' ));
			wp_register_script( 'flexslider', DC_BASE_URL . 'js/jquery.flexslider-min.js',array( 'jquery', 'imagesloaded'));
			wp_register_script( 'mediaplayer', DC_BASE_URL . 'js/mediaelement-and-player.min.js', array( 'jquery' ));
			wp_register_script( 'modernizr' ,DC_BASE_URL . 'js/vendor/modernizr.js' ,array( 'jquery' ), null, $in_footer = false);
			wp_register_script( 'foundation' ,DC_BASE_URL . 'js/foundation.min.js' ,array( 'jquery' ),null, $in_footer = true);
			wp_register_script( 'nicescroll' ,DC_BASE_URL . 'js/jquery.nicescroll.min.js' ,array( 'jquery' ),null, $in_footer = true);
		}

		function resolve_main_scripts(){
			DC::resolves( array( 'modernizr' , 'foundation', 'nicescroll') );
		}

		function load_scripts(){
			if(!is_admin()){
				global $public_scripts;
				wp_enqueue_script( 'reach', DC_BASE_URL. 'js/reach.js', $public_scripts, null, $in_footer = true );
			}
		}
	}
?>