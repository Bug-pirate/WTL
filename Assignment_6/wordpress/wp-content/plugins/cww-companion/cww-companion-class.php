<?php
/**
 * Main plugin class 
 * 
 */

if ( !class_exists( 'CWW_Companion' ) ) {

    /**
     * Sets up and initializes the plugin.
     */
    class CWW_Companion {

        /**
         * A reference to an instance of this class.
         *
         * @since  1.0.0
         * @access private
         * @var    object
         */
        private static $instance = null;

        /**
         * Plugin version
         *
         * @var string
         */
        private $version = CWW_COMP_VER;

        /**
         * Returns the instance.
         *
         * @since  1.0.0
         * @access public
         * @return object
         */
        public static function get_instance() {
            // If the single instance hasn't been set, set it now.
            if ( null == self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        /**
         * Sets up needed actions/filters for the plugin to initialize.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function __construct() {

            // Load translation files
            add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

            add_action( 'wp_enqueue_scripts', [ $this, 'cww_companion_view_scripts' ] );
            add_action('admin_enqueue_scripts', [ $this, 'cww_companion_customizer_scripts'] );
            add_action( 'admin_notices', array( $this,'cww_check_active_themes') );
             
            add_action( 'elementor/controls/controls_registered', [ $this, 'cww_register_elements_controls' ] );
            add_action( 'elementor/widgets/widgets_registered',array($this,'cww_register_elements') );

            add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'cww_enqueue_styles' ] );
            add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'cww_enqueue_styles' ] );
           
        }

        /**
         * Loads the translation files.
         *
         * @since 1.0.0
         * @access public
         * @return void
         */
        public function load_plugin_textdomain() {
        	
            load_plugin_textdomain( 'cww-companion', false, basename( dirname( __FILE__ ) ) . '/languages' );
        }

        /**
         * Returns plugin version
         *
         * @return string
         */
        public function get_version() {
            return $this->version;
        }

       
        /**
         * Frontend styles & scripts
         * 
         * 
         */ 
        function cww_companion_view_scripts(){

            wp_register_style( 'magnific-popup', CWW_COMP_ASS_URL. '/magnific-popup/magnific-popup.css', array(), CWW_COMP_VER );

            wp_register_script( 'jarallax', CWW_COMP_ASS_URL. '/jarallax/jarallax.min.js', array('jquery'), CWW_COMP_VER, true );
            wp_register_script( 'jquery-magnific-popup', CWW_COMP_ASS_URL. '/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), CWW_COMP_VER, true );
            wp_register_script( 'jquery-waypoints', CWW_COMP_ASS_URL.'/waypoints/jquery.waypoints.min.js', array('jquery'), CWW_COMP_VER, true );
            wp_register_script( 'jquery-counterup', CWW_COMP_ASS_URL.'/counter-up/jquery.counterup.min.js', array(), CWW_COMP_VER, true );
        }
    

        /**
        * Admin scripts
        */
        function cww_companion_customizer_scripts(){
        	
        	$current_screen = get_current_screen();
			
			if( $current_screen->base == 'customize' ){
            wp_enqueue_style( 'font-awesome', CWW_COMP_ASS_URL . '/font-awesome/css/font-awesome.min.css', array(), CWW_COMP_VER );
        	}
            wp_enqueue_media();
            wp_enqueue_script('category-image-upload', CWW_COMP_URL. 'inc/assets/js/category-image-upload.js', array('jquery'), null, true);

        }



        /**
         * Display message if CWW themes are not installed
         * 
         * 
         * 
         */ 
        function cww_check_active_themes(){
            
            $cww_companion_th       = array('cww-portfolio','portfolio','xews','xews-lite');
            $cww_companion_active_theme   = wp_get_theme();
            $themes_url = array_intersect( array_keys( wp_get_themes() ), $cww_companion_th ) ? admin_url( 'themes.php?search=codeworkweb' ) : admin_url( 'theme-install.php?search=codeworkweb' );

            if ( ! in_array($cww_companion_active_theme->template,$cww_companion_th) ) { ?>
                <div class="cww-instal-theme-wrapp notice notice-warning">
                    
                    <p><?php printf( '%1$s <b>%2$s</b> %3$s', esc_html__('You need to have','cww-companion'), esc_html__('CWW Portfolio','cww-companion'), esc_html__('theme installed & activated to use CWW Companion','cww-companion')  ); ?>
                    </p>
                    <p class="actions">
                        <a href="<?php echo esc_url($themes_url)?>" class="button button-primary"><?php echo esc_html__('Install & Activate'); ?></a>
                    </p>
                </div>
            <?php 
            }
        }
        
        /**
         * Elementor elements
         */
        function cww_register_elements(){
            if( class_exists('Newzz_Elements') ){
                return;
            }
            require CWW_COMP_PATH. '/inc/elementor/elements/hero2.php';
            require CWW_COMP_PATH. '/inc/elementor/elements/module1.php';
            require CWW_COMP_PATH. '/inc/elementor/elements/module2.php';
            require CWW_COMP_PATH. '/inc/elementor/elements/module3.php';
            require CWW_COMP_PATH. '/inc/elementor/elements/module4.php';
            require CWW_COMP_PATH. '/inc/elementor/elements/slider1.php';
        }

        public function cww_register_elements_controls(){
            if( class_exists('Newzz_Elements') ){
                return;
            }
            require CWW_COMP_PATH. '/inc/elementor/includes/group-control-query.php';
        }

        function cww_enqueue_styles(){
            if( class_exists('Newzz_Elements') ){
                return;
            }
            wp_enqueue_style( 'slick', CWW_COMP_URL . 'inc/elementor/elements/slick/slick.css', [], CWW_COMP_VER );
            wp_enqueue_style( 'slick-theme', CWW_COMP_URL . 'inc/elementor/elements/slick/slick-theme.css', [], CWW_COMP_VER );
            wp_enqueue_script( 'slick', CWW_COMP_URL . 'inc/elementor/elements/slick/slick.min.js',array('jquery'), CWW_COMP_VER, true );

            wp_enqueue_style( 'code-elements-companion-frontend', CWW_COMP_URL . 'inc/elementor/elements/css/elements-styles.css', [], CWW_COMP_VER );
            
        }
        
    }

}

if ( !function_exists( 'cww_companion' ) ) {

    /**
     * Returns instanse of the plugin class.
     *
     * @since  1.0.0
     * @return object
     */
    function cww_companion() {
        return CWW_Companion::get_instance();
    }
}
cww_companion();
