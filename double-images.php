<?php
/**
 * Plugin Name:  Double Images
 * Description:  Plugin pour faciliter l'insertion d'images juxtaposées
 * Version:      1
 * Author:       Philippe Zénone
 * Author URI:   https://philippezenone.net/
 * Text Domain:  doubleimages
 * Domain Path:  /languages
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 */

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

define( 'DBLIMGS_PLUGIN_PATH', plugin_dir_path(__FILE__));
define( 'DBLIMGS_PLUGIN_URL', plugin_dir_url( __FILE__ )); 


// Shortcodes
if (!is_admin()) {
    include_once DBLIMGS_PLUGIN_PATH . '/front/shortcodes.php';
    add_action( 'init', 'dblimgs_add_shortcodes' );
    add_action('wp_enqueue_scripts','dblimgs_scripts_init_front');
} else {
    add_action('wp_enqueue_scripts','dblimgs_scripts_init_admin');
    include_once DBLIMGS_PLUGIN_PATH . '/admin/buttons.php';
}


function dblimgs_scripts_init_front() {
    wp_register_style('dblimgs_style', DBLIMGS_PLUGIN_URL . '/front/dblimgs.css');
    wp_enqueue_style('dblimgs_style');
    wp_register_script('dblimgs_scripts', DBLIMGS_PLUGIN_URL . '/front/dblimgs.js');
    wp_enqueue_script('dblimgs_scripts');

}

function dblimgs_scripts_init_admin() {
    wp_register_style('dblimgs_style', DBLIMGS_PLUGIN_URL . '/admin/dblimgs.css');
    wp_enqueue_style('dblimgs_style');
    /*wp_register_script('dblimgs_scripts', DBLIMGS_PLUGIN_URL . '/front/dblimgs.js');
    wp_enqueue_script('dblimgs_scripts');*/
}

add_action( 'admin_init', 'dblimgs_styles_to_editor' );
function dblimgs_styles_to_editor() {
    global $editor_styles;
    $editor_styles[] =  DBLIMGS_PLUGIN_URL . '/admin/dblimgs.css';
}
