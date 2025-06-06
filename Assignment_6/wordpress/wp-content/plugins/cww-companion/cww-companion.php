<?php
/**
 * Plugin Name: CWW Companion
 * Plugin URI: http://codeworkweb.com/plugins/cww-companion
 * Description: This plugin adds some useful featuers to themes made by us(Code Work Web).
 * Version: 1.3.2
 * Author: Code Work Web
 * Author URI: https://codeworkweb.com
 * Text Domain: cww-companion
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 *
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die();
}

define( 'CWW_COMP_VER', '1.3.2' );

define( 'CWW_COMP_FILE', __FILE__ );
define( 'CWW_COMP_PLUGIN_BASENAME', plugin_basename( CWW_COMP_FILE ) );
define( 'CWW_COMP_PATH', plugin_dir_path( CWW_COMP_FILE ) );
define( 'CWW_COMP_URL', plugins_url( '/', CWW_COMP_FILE ) );

define( 'CWW_COMP_ASS_URL', CWW_COMP_URL . 'inc/assets/' );


 require CWW_COMP_PATH. '/inc/svg-icons/svg-icons.php';
 require CWW_COMP_PATH. '/inc/customizer/controllers/repeater-controller/customizer.php';
 require CWW_COMP_PATH. '/inc/customizer/custom-controller.php';
 require CWW_COMP_PATH. '/inc/customizer/controllers/controller-main.php';

if( ! class_exists('Newzz_Elements') ){
    require CWW_COMP_PATH. '/inc/elementor/includes/helpers.php'; //elementor elements
}


//disable elementor onboarding
$already_had_onboarding = get_option( 'elementor_onboarded' );
if($already_had_onboarding == false ){
    update_option( 'elementor_onboarded', true );
}

$cww_companion_demo             = array('cww-portfolio','uportfolio','xews','xews-lite','news-magazinex','blog-news'); //list of themes for demo import
$cww_companion_th               = array('cww-portfolio','uportfolio');
$cww_companion_active_theme     = wp_get_theme();
if ( in_array($cww_companion_active_theme->template,$cww_companion_th) ) {
    require CWW_COMP_PATH. '/inc/customizer/cww-portfolio/home-settings/main-banner.php';
    require CWW_COMP_PATH. '/inc/customizer/cww-portfolio/home-settings/about-settings.php';
    require CWW_COMP_PATH. '/inc/customizer/cww-portfolio/home-settings/contact-settings.php';
    require CWW_COMP_PATH. '/inc/customizer/cww-portfolio/home-settings/cta-settings.php';
    require CWW_COMP_PATH. '/inc/customizer/cww-portfolio/home-settings/service-settings.php';
    require CWW_COMP_PATH. '/inc/importer/cww-portfolio/demo-config.php';
}

if ( in_array($cww_companion_active_theme->template,$cww_companion_demo) ) {
    require_once CWW_COMP_PATH . '/inc/importer/demo-importer/classes/class-install-demos.php';
    require_once CWW_COMP_PATH . '/inc/importer/demo-importer/includes/demos.php';
}

require CWW_COMP_PATH. '/cww-companion-class.php';

// Runs on plugin activation
function cww_companion_activate() {
    
    require_once CWW_COMP_PATH . '/inc/companion-activation.php';
    CWW_Companion_Plugin_Activator::activate();
}
register_activation_hook( __FILE__, 'cww_companion_activate' );