<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('admin_folder_Redux_Framework_config')) {

    class admin_folder_Redux_Framework_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css) {
            //echo '<h1>The compiler hook has run!';
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $this->settings[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __('General Settings', THEMENAME),
                'fields' => array(
                    array(
                        'id' => 'dc_favicon',
                        'type' => 'media',
                        'title' => __('Favicon Upload', THEMENAME),
                        'compiler' => 'true',
                        'mode' => false,
                        'subtitle' =>  __('Upload a 16px x 16px .ico image that will be your favicon', THEMENAME)   
                    ),
                    array(
                        'id' => 'dc_use_logo',
                        'type' => 'switch',
                        'title' => __('Use Image for logo?', THEMENAME),
                        'subtitle' =>  __('If left unchecked, plain text will be used instead (generated from site name).', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_logo',
                        'type' => 'media',
                        'required'  => array('dc_use_logo', '=', '1'), 
                        'title' => __('Logo Upload', THEMENAME), 
                        'subtitle' => __('Upload your logo here and enter the height of it below', THEMENAME),
                        'desc' => '' 
                    ),
                    array(
                        'id' => 'dc_dark_logo',
                        'type' => 'media',
                        'required'  => array('dc_use_logo', '=', '1'), 
                        'title' => __('Dark Logo Upload', THEMENAME), 
                        'subtitle' => __('You can pload different logo for dark scheme header. Upload your logo here and enter the height of it below', THEMENAME),
                        'desc' => '' 
                    ),
                    array(
                        'id' => 'dc_logo_height', 
                        'type' => 'text', 
                        'title' => __('Logo Height', THEMENAME),
                        'sub_desc' => __('Don\'t include "px" in the string. e.g. 30', THEMENAME),
                        'desc' => '',
                        'validate' => 'numeric'
                    ),
                     array(
                        'id' => 'dc_hidden-sidebar', 
                        'type' => 'switch', 
                        'title' => __('Hidden Sidebar', THEMENAME),
                        'sub_desc' => __('Turn on/off hidden sidebar', THEMENAME),
                        'default' => '1'
                    ),
                     array(
                        'id' => 'dc_hidden-sidebar_position', 
                        'type' => 'radio',
                        'required'  => array('dc_hidden-sidebar', '=', '1'),  
                        'title' => __('Hidden Sidebar position', THEMENAME),
                        'sub_desc' => __('Determine hidden sidebar position', THEMENAME),
                        'default' => 'right',
                        'options' => array(
                            'left' => __('Left', THEMENAME),
                            'right' => __('Right', THEMENAME)
                        )
                    ),
                     array(
                        'id' => 'dc_hidden-sidebar_color',
                        'type' => 'radio',
                        'required' => array('dc_hidden-sidebar', '=', '1'),
                        'title' => __('Hidden Sidebar Color Scheme', THEMENAME),
                        'sub_desc' => __('Choose the color scheme for hidden siderbar', THEMENAME),
                        'default' => 'light-color',
                        'options' => array(
                            'light-color' => 'Light Font Color',
                            'dark-color' => 'Dark Font Color'
                        )
                    ),
                    array(
                        'id' => 'dc_css_code',
                        'type' => 'ace_editor',
                        'mode' => 'css',
                        'title' => __('CSS Code', THEMENAME),
                        'subtitle' => __('Paste your css code here', THEMENAME)
                    ),
                    array(
                        'id' => 'dc_js_code',
                        'type' => 'ace_editor',
                        'mode' => 'javascript',
                        'title' => __('Javascript Code', THEMENAME),
                        'subtitle' => __('Paste your javascript code here', THEMENAME)
                    )
                )
            );

            $this->sections[] = array(
                'icon' => ' el-icon-asterisk',
                    'title' => __('Blog Options', THEMENAME),
                    'desc' => __('All blog options are listed here.', THEMENAME),
                    'fields' => array(                        
                        array(
                            'id' => 'blog-layout',
                            'type' => 'select', 
                            'title' => __('Blog Layout', THEMENAME),
                            'subtitle' => __('Determine the layout of your blog', THEMENAME),
                            'options' => array(
                                '1' => 'One Post Per Line',
                                '2' => 'Two Post Per Line'
                            ),
                            'default' => '1'
                        )
                    )
            );
            

            $this->sections[] = array(

                    'icon' => ' el-icon-asterisk',
                    'title' => __('Footer Options', THEMENAME),
                    'desc' => __('All footer related options are listed here.', THEMENAME),
                    'fields' => array(
                        array(
                            'id' => 'enable-main-footer-area',
                            'type' => 'switch',
                            'title' => __('Main Footer Area', THEMENAME), 
                            'subtitle' => __('Do you want use the main footer that contains all the widgets areas?', THEMENAME),
                            'desc' => '',
                            'default' => '1' 
                        ),                          
                        array(
                            'id' => 'footer-copyright-text',
                            'type' => 'text',
                            'title' => __('Footer Copyright Section Text', THEMENAME), 
                            'subtitle' => __('Please enter the copyright section text. e.g. All Rights Reserved, WAELabs Corp.', THEMENAME),
                            'desc' => __('', THEMENAME)
                        ),
                        array(
                            'id' => 'use-facebook-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Facebook Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-twitter-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Twitter Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-google-plus-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Google+ Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-vimeo-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Vimeo Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-dribbble-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Dribbble Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-pinterest-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Pinterest Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-youtube-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Youtube Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-tumblr-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Tumblr Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-linkedin-icon',
                            'type' => 'checkbox',
                            'title' => __('Use LinkedIn Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-rss-icon',
                            'type' => 'checkbox',
                            'title' => __('Use RSS Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),

                        array(
                            'id' => 'use-flickr-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Flickr Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-skype-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Skype Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-behance-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Behance Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-instagram-icon',
                            'type' => 'checkbox',
                            'title' => __('Use Instagram Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-github-icon',
                            'type' => 'checkbox',
                            'title' => __('Use GitHub Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-stack-exchange-icon',
                            'type' => 'checkbox',
                            'title' => __('Use StackExchange Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        ),
                        array(
                            'id' => 'use-soundcloud-icon',
                            'type' => 'checkbox',
                            'title' => __('Use SoundCloud Icon', THEMENAME), 
                            'subtitle' => '',
                            'desc' => ''
                        )
                    )            
                );

            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => __('Social Media Options', THEMENAME),
                'desc' => __('Enter in your social media locations here and then activate which ones you would like to display in your footer options & header options tabs. <br/><br/> <strong>Remember to include the "http://" in all URLs!</strong>', THEMENAME),
                'fields' => array(
                    array(
                        'id' => 'dc_facebook_url', 
                        'type' => 'text', 
                        'title' => __('Facebook URL', THEMENAME),
                        'subtitle' => __('Please enter in your Facebook URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_twitter_url', 
                        'type' => 'text', 
                        'title' => __('Twitter URL', THEMENAME),
                        'subtitle' => __('Please enter in your Twitter URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_google-plus_url', 
                        'type' => 'text', 
                        'title' => __('Google+ URL', THEMENAME),
                        'subtitle' => __('Please enter in your Google+ URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_vimeo_url', 
                        'type' => 'text', 
                        'title' => __('Vimeo URL', THEMENAME),
                        'subtitle' => __('Please enter in your Vimeo URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_dribbble_url', 
                        'type' => 'text', 
                        'title' => __('Dribbble URL', THEMENAME),
                        'subtitle' => __('Please enter in your Dribbble URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_pinterest_url', 
                        'type' => 'text', 
                        'title' => __('Pinterest URL', THEMENAME),
                        'subtitle' => __('Please enter in your Pinterest URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_youtube_url', 
                        'type' => 'text', 
                        'title' => __('Youtube URL', THEMENAME),
                        'subtitle' => __('Please enter in your Youtube URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_tumblr_url', 
                        'type' => 'text', 
                        'title' => __('Tumblr URL', THEMENAME),
                        'subtitle' => __('Please enter in your Tumblr URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_linkedin_url', 
                        'type' => 'text', 
                        'title' => __('LinkedIn URL', THEMENAME),
                        'subtitle' => __('Please enter in your LinkedIn URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_rss_url', 
                        'type' => 'text', 
                        'title' => __('RSS URL', THEMENAME),
                        'subtitle' => __('If you have an external RSS feed such as Feedburner, please enter it here. Will use built in Wordpress feed if left blank.', THEMENAME),
                        'desc' => ''
                    ),
                     array(
                        'id' => 'dc_flickr_url',
                        'type' => 'text',
                        'title' => __('Flickr URL', THEMENAME), 
                        'subtitle' =>__('Please enter in your Flickr URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_skype_url',
                        'type' => 'text',
                        'title' => __('Skype URL', THEMENAME), 
                        'subtitle' => __('Please enter in your Skype URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_behance_url', 
                        'type' => 'text', 
                        'title' => __('Behance URL', THEMENAME),
                        'subtitle' => __('Please enter in your Behance URL.', THEMENAME),
                        'desc' => ''
                    ),
                    
                    array(
                        'id' => 'dc_instagram_url', 
                        'type' => 'text', 
                        'title' => __('Instagram URL', THEMENAME),
                        'subtitle' => __('Please enter in your Instagram URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_github_url', 
                        'type' => 'text', 
                        'title' => __('GitHub URL', THEMENAME),
                        'subtitle' => __('Please enter in your GitHub URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_stack-exchange_url', 
                        'type' => 'text', 
                        'title' => __('StackExchange URL', THEMENAME),
                        'subtitle' => __('Please enter in your StackExchange URL.', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'dc_soundcloud_url', 
                        'type' => 'text', 
                        'title' => __('SoundCloud URL', THEMENAME),
                        'subtitle' => __('Please enter in your SoundCloud URL.', THEMENAME),
                        'desc' => ''
                    )
                )
            );

            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => 'Footer Social Media Options',
                'desc' => 'Disable or Enable Social Media in Footer Area',
                'fields' => array(  
                    array(
                        'id' => 'footer_use_facebook',
                        'type' => 'checkbox',
                        'title' => __('Use Facebook Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_twitter',
                        'type' => 'checkbox',
                        'title' => __('Use Twitter Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_google-plus',
                        'type' => 'checkbox',
                        'title' => __('Use Google+ Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_vimeo',
                        'type' => 'checkbox',
                        'title' => __('Use Vimeo Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_dribbble',
                        'type' => 'checkbox',
                        'title' => __('Use Dribbble Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_pinterest',
                        'type' => 'checkbox',
                        'title' => __('Use Pinterest Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_youtube',
                        'type' => 'checkbox',
                        'title' => __('Use Youtube Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_tumblr',
                        'type' => 'checkbox',
                        'title' => __('Use Tumblr Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_linkedin',
                        'type' => 'checkbox',
                        'title' => __('Use LinkedIn Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_rss',
                        'type' => 'checkbox',
                        'title' => __('Use RSS Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),

                    array(
                        'id' => 'footer_use_flickr',
                        'type' => 'checkbox',
                        'title' => __('Use Flickr Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_skype',
                        'type' => 'checkbox',
                        'title' => __('Use Skype Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_behance',
                        'type' => 'checkbox',
                        'title' => __('Use Behance Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_instagram',
                        'type' => 'checkbox',
                        'title' => __('Use Instagram Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_github',
                        'type' => 'checkbox',
                        'title' => __('Use GitHub Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_stack-exchange',
                        'type' => 'checkbox',
                        'title' => __('Use StackExchange Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                    array(
                        'id' => 'footer_use_soundcloud',
                        'type' => 'checkbox',
                        'title' => __('Use SoundCloud Icon', THEMENAME), 
                        'subtitle' => '',
                        'desc' => ''
                    ),
                )
            );

            $this->sections[] = array(
                'icon' => ' el-icon-map-marker',
                'title' => __('Contact Options', THEMENAME),
                'desc' => __('All contact page related options are listed here.', THEMENAME),
                'fields' => array( 
                    array(
                        'id' => 'map_zoom_level',
                        'type' => 'text',
                        'title' => __('Defautl Map Zoom Level', THEMENAME), 
                        'subtitle' => __('Value should be between 1-18, 1 being the entire earth and 18 being right at street level.', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'default' => '15' 
                    ),
                    array(
                        'id' => 'map_enable_zoom',
                        'type' => 'checkbox',
                        'title' => __('Enable Map Zoom In/Out', THEMENAME), 
                        'subtitle' => __('Do you want users to be able to zoom in/out on the map?', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'default' => '0' 
                    ),
                    array(
                        'id' => 'map_marker',
                        'type' => 'media',
                        'title' => __('Use local image as a marker', THEMENAME),
                        'subtitle' => __('Upload your custom marker here', THEMENAME),
                        'desc' => ''
                    ),
                    array(
                        'id' => 'map_coordinate',
                        'type' => 'text',
                        'title' => __('Map center Coordinate', THEMENAME), 
                        'subtitle' => __('Please enter the coordinate for the maps center point. example : (-6.907342,107.645399) ', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),
                    array(
                        'id'=>'map_positions',
                        'type' => 'multi_text',
                        'title' => __('Locations', THEMENAME),
                        'subtitle' => __('Add your locations coordinate. example : (-6.907342,107.645399)', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),
                    array(
                        'id'=>'map_position_infos',
                        'type' => 'multi_text',
                        'title' => __('Location Infos', THEMENAME),
                        'subtitle' => __('Add your location info according to location input order', THEMENAME),
                        'desc' => __('', THEMENAME)
                    ),      
                    array(
                        'id'=>'map_type',
                        'type' => 'radio',
                        'title' => __('Map Type', THEMENAME),
                        'subtitle' => __('Choose your type of map display', THEMENAME),
                        'desc' => __('', THEMENAME),
                        'options' => array(
                            'styled' => 'Styled',
                            'regular' => 'Regular'
                        ),
                        'default' => 'regular'
                    ),
                    array(
                        'id' => 'map_color',
                        'required' => array('map_type', '=', 'styled'), 
                        'type' => 'select', 
                        'title' => __('Map Color', THEMENAME),
                        'subtitle' => __('Determine the color of styled map', THEMENAME),
                        'options' => array(
                            'primary_color' => 'Primary Color',
                            'secondary_color' => 'Secondary Color',
                            'secondary_complement_color' => 'Secondar Complement Color'
                        ),
                        'default' => 'primary_color'
                    ),
                    /*array(
                        'id' => 'contact_address_label',
                        'type' => 'text',
                        'title' => __('Address Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for address section', THEMENAME),
                        'default' => __('Our Humble Headquarter', THEMENAME)
                    ),*/
                    array(
                        'id' => 'contact_address',
                        'type' => 'editor',
                        'title' => __('Contact Address', THEMENAME),
                        'subtitle' => __('Your office address', THEMENAME),
                        'args'   => array(
                                'teeny'            => true,
                                'textarea_rows'    => 10
                            )
                    ), 
                    array(
                        'id' => 'phone_number',
                        'type' => 'text',
                        'title' => __('Phone Number', THEMENAME),
                        'subtitle' => __('Your Phone Number or Your Office Phone Number', THEMENAME)                        
                    ), 
                     array(
                        'id' => 'email',
                        'type' => 'text',
                        'title' => __('Email', THEMENAME),
                        'subtitle' => __('Your Email or Your Office Mail', THEMENAME)                        
                    ),
                   /* array(
                        'id' => 'contact_social_label',
                        'type' => 'text',
                        'title' => __('Social Accounts Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for social accounts section', THEMENAME),
                        'default' => __('Also Find Us On', THEMENAME)
                    ),*/
                    array(
                        'id' => 'contact_form_label',
                        'type' => 'text',
                        'title' => __('Contact Form Label', THEMENAME),
                        'subtitle' => __('Will be displayed as heading title for contact form section', THEMENAME),
                        'default' => __('Leave Us A Message. Will Ya ?', THEMENAME)
                    )                          
                )
            );
            // ACTUAL DECLARATION OF SECTIONS
       
            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'redux-framework-demo') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'redux-framework-demo') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'redux-framework-demo') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'redux-framework-demo') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }

            $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            $this->sections[] = array(
                'type' => 'divide',
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'redux-framework-demo'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'redux-framework-demo'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );

            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'redux-framework-demo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name' => 'reach',
                'display_name' => 'Reach',
                'display_version' => false,
                'page_slug' => 'reach_options',
                'page_title' => 'Reach Options',
                'update_notice' => true,
                'admin_bar' => true,
                'menu_type' => 'menu',
                'menu_title' => 'Reach Options',
                'allow_sub_menu' => true,
                'page_parent_post_type' => 'your_post_type',
                'customizer' => true,
                'default_mark' => '*',
                'google_api_key' => 'AIzaSyCTdF9TymZpzbWGHa2ii7KRU3ueY5m9Ejs',
                'hints' => 
                array(
                  'icon' => 'el-icon-question-sign',
                  'icon_position' => 'right',
                  'icon_size' => 'normal',
                  'tip_style' => 
                  array(
                    'color' => 'light',
                  ),
                  'tip_position' => 
                  array(
                    'my' => 'top left',
                    'at' => 'bottom right',
                  ),
                  'tip_effect' => 
                  array(
                    'show' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseover',
                    ),
                    'hide' => 
                    array(
                      'duration' => '500',
                      'event' => 'mouseleave unfocus',
                    ),
                  ),
                ),
                'output' => true,
                'output_tag' => true,
                'compiler' => true,
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => true,
                'show_import_export' => true,
                'transient_time' => '3600',
                'network_sites' => true,
              );

            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new admin_folder_Redux_Framework_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('admin_folder_my_custom_field')):
    function admin_folder_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('admin_folder_validate_callback_function')):
    function admin_folder_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
