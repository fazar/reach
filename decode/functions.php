<?php
	abstract class DC{
		protected $config;

		function __construct(){
			$this->define_globals();
			$this->define_constants();
			$this->initiate_config();
			$this->define_config();
			$this->required_support();
			$this->initiate_options();
			$this->register_menus();
			$this->include_modules();
			$this->load_modules();
			add_action( 'widgets_init', array($this, 'include_widgets') );
			add_action( 'widgets_init', array($this, 'load_widgets') );
			add_action( 'widgets_init', array( $this, 'register_sidebar' ) );
			add_action( 'widgets_init', array( $this, 'register_footer_widget_areas' ) );
			$this->include_parts();
			$this->load_parts();
			$this->fire_resources();
			add_filter('the_content', array( $this, 'shortcode_empty_paragraph_fix' ) );
		}

		function define_globals(){
			global $public_scripts;
			global $admin_scripts;
			$public_scripts = array();
			$admin_scripts = array();
		}

		function load_modules(){}
		function load_widgets(){}
	    protected abstract function load_parts();
	    protected abstract function define_config();

		protected function load_part( $namespace ){
			$file_path = DC_BASE;
			$file_path .= 'parts/class.'. $namespace[0]. '.'. $namespace[1]. '.php';
			require_once( $file_path );
			$classname = $this->config['class-prefix']. $namespace[0] . '_' . $namespace[1] ;
			return new $classname;
		}

		protected function load_module( $module_name ){
	    	$file_path = DC_BASE;
			$file_path .= 'modules/'. $module_name .'/class.bootstrapper.php';
			require_once( $file_path );
			$classname = $this->config['class-prefix']. $module_name .'_bootstrapper';
            return new $classname;
	    }

		protected function load_widget( $name ){
	    	$file_path = DC_BASE.'/widgets/';
	    	require_once( $file_path.'class.'. $name . '.widget.php' );
			register_widget( $this->config['class-prefix'] . $name . '_widget' );
	    }


		private	function define_constants(){
		    //get WP_Theme object
		    $dc_theme                     = wp_get_theme();
		    $dc_base_data['prefix']       = $dc_base_data['title'] = $dc_theme -> name;
		    $dc_base_data['version']      = $dc_theme -> version;
		    $dc_base_data['authoruri']    = $dc_theme -> {'Author URI'};
			 

			/* THEME_VER is the Version */
			if( ! defined( 'THEME_VER' ) )      { define( 'THEME_VER' , $dc_base_data['version'] ); }

			/* dc_BASE is the root server path of the parent theme */
			if( ! defined( 'DC_BASE' ) )            { define( 'DC_BASE' , get_template_directory().'/' ); }

			/* dc_BASE_CHILD is the root server path of the child theme */
			if( ! defined( 'DC_BASE_CHILD' ) )      { define( 'DC_BASE_CHILD' , get_stylesheet_directory().'/' ); }

			/* dc_BASE_URL http url of the loaded parent theme*/
			if( ! defined( 'DC_BASE_URL' ) )        { define( 'DC_BASE_URL' , get_template_directory_uri() . '/' ); }

			/* THEMENAME contains the Name of the currently loaded theme */
			if( ! defined( 'THEMENAME' ) )          { define( 'THEMENAME' , $dc_base_data['title'] ); }

			/* dc_WEBSITE is the home website of dc theme  */
			if( ! defined( 'DC_WEBSITE' ) )         { define( 'DC_WEBSITE' , $dc_base_data['authoruri'] ); }
		}

		private function initiate_options(){
	    	if ( !class_exists( $this->config['admin-class'] ) && file_exists( DC_BASE . 'admin/admin-init.php' ) ) {
	    	    require_once( DC_BASE. 'admin/admin-init.php' );
	    	}
	    	global $dc;
	    	$dc = get_option($this->config['global-options']);
		}

	    private function include_modules(){
	    	$module_names = $this->config['include-modules'];
	    	$file_path = DC_BASE . 'decode/';
	    	require_once($file_path.'modules/class.bootstrapper.php');
	    	require_once($file_path.'modules/class.meta_boxes.php');
	    	foreach ($module_names as $key => $module_name) {
	    		require_once( $file_path ."modules/$module_name/class.bootstrapper.php" );
	    		$classname = 'DC_' . $module_name . '_bootstrapper';
	    		new $classname;
	    	}
	    }



	    private function include_parts(){
	    	$file_path = DC_BASE;
	    	require_once($file_path.'decode/parts/class.parts.base.php');
	    	$part_names = $this->config['include-parts'];
	    	foreach ($part_names as $key => $name) {
	    		$part = DC_BASE. 'decode/parts/class.'. $name. '.main.php';
	    		require_once( $part );
	    		$classname = 'DC_'. $name . '_main';
	    		new $classname;
	    	}
	    }

	    function include_widgets( ){
    		$file_path = DC_BASE . 'decode';
	    	foreach ($this->config['include-widgets'] as $key => $widget) {
	    		require_once( $file_path .'/widgets/class.'. $widget . '.widget.php' );
				register_widget( 'DC_' . $widget . '_widget' );
	    	}
	    }

	    function register_sidebar(){
	    	// global $dc;
			foreach ($this->config['sidebar-widget-areas'] as $key => $widget_area) {
				$options_id = 'dc_' . $widget_area['id'];
				// if( array_key_exists('dc_' . $widget_area['id'], $dc) && $dc['dc_' . $widget_area['id']] == '0'){
				// 	continue;
				// }
				register_sidebar( array(
					'name' => $widget_area['name'],
					'id' => $widget_area['id'],
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
				) );
			}
		}

		function register_footer_widget_areas(){
			foreach ($this->config['footer-widget-areas'] as $key => $widget_area) {
				register_sidebar( array(
					'name' => $widget_area['name'],
					'id' => $widget_area['id'],
					'before_widget' => '<div class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h2>',
					'after_title' => '</h2>'
				) );
			}
		}

		function shortcode_empty_paragraph_fix($content){   
		    $array = array (
		        '<p>[' => '[', 
		        ']</p>' => ']', 
		        ']<br />' => ']'
		    );

		    $content = strtr($content, $array);
		    return $content;
		}

        private function initiate_config(){
        	$this->config = array(
    			'global-options' => null,
    			'class-prefix' => 'DC_',
    			'content-width' => 960,
    			'nav-menus' => array( 
    				'primary' => __( 'Primary Menu', THEMENAME )
    			),
    			'sidebar-widget-areas' => array(
    				array(
    					'name' => __( 'Main Sidebar', THEMENAME),
    					'id' => 'main-sidebar'
    				)		
    			),
    			'footer-widget-areas' => array(),
    			'admin-class' => 'dc_admin_config',
    			'include-modules' => array(),
    			'include-widgets' => array(),
    			'include-parts' => array(),
    		);
        }

        private function required_support(){
			if(function_exists('add_theme_support')) {
				add_theme_support( 'automatic-feed-links' );
		  	} 
		  	global $content_width;
		  	if ( ! isset( $content_width ) ) $content_width = $this->config['content-width'];	
		}

		private function register_menus(){
	    	register_nav_menus( $this->config['nav-menus'] );
	    }

	    //helpers
	    static function resolves( $scripts ){
			global $public_scripts;
			foreach ($scripts as $key => $script) {
				if(!in_array($script,  $public_scripts)){
					array_push($public_scripts, $script);
				}
			}
		}

		static function admin_resolves( $scripts ){
			global $admin_scripts;
			foreach ( $scripts as $key => $script ) {
				if(!in_array($script,  $admin_scripts)){
					array_push($admin_scripts, $script);
				}
			}
		}

		private function fire_resources(){
			require_once(DC_BASE. 'decode/bootstrapper/class.admin.resolves.php');
			new DC_admin_resolves;
		}

	}
?>