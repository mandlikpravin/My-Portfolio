<?php
/**
 * Plugin Name:       Titan Preloaders
 * Plugin URI:        https://codecanyon.net/user/gfxpartner
 * Description:       All-in-one Preloader Plugin for WordPress that comes with intuitive editor, exclusive features & award-winning designs collection. Enhance the user experience with modern preloader designs brought to life with hand crafted beautiful animations.
 * Version:           1.2.6
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            GfxPartner
 * Author URI:        https://codecanyon.net/user/gfxpartner
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       titan
 * Domain Path:       /inc/languages
 */

if ( ! function_exists( 'add_action' ) ) {
	wp_die(
		esc_html__( 'This file can not be accessed directly', 'titan' ),
		esc_html__( 'Unauthorized access', 'titan' )
	);
}

define( 'TITAN_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'TITAN_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TITAN_PLUGIN_VERSION', '1.2.6' );
define( 'TITAN_PLUGIN_DEMO', false );

require 'class-titanplugin.php';

add_action(
    'after_setup_theme',
    function() {
        global $gfx_titan;

        if (
        ! class_exists( 'ReduxFramework' ) &&
        file_exists( TITAN_PLUGIN_DIR . '/inc/options/framework/framework.php' )
        ) {
            require_once TITAN_PLUGIN_DIR . '/inc/options/framework/framework.php';
        }

        if (
        ! isset( $gfx_titan ) &&
        file_exists( TITAN_PLUGIN_DIR . '/inc/options/config/config.php' )
        ) {
            require_once TITAN_PLUGIN_DIR . '/inc/options/config/config.php';
        }

    }
);
