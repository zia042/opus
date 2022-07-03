<?php
/*
Plugin Name: Divi Contact Form 7
Plugin URI:  https://divipeople.com
Description: Design beuatiful contact forms with <strong>Divi Contact Form 7</strong>
Version:     1.3.2
Author:      DiviPeople
Author URI:  https://divipeople.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dvppl-cf7-styler
Domain Path: /languages

Divi Contact Form 7 is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Divi Contact Form 7 is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with CF7 Styler. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

//phpcs:disable
#ET_START_REPLACE
if ( !function_exists( 'dipe_cf7_fs' ) ) {
    // Create a helper function for easy SDK access.
    function dipe_cf7_fs() {
        global $dipe_cf7_fs;

        if ( !isset( $dipe_cf7_fs ) ) {

            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';

            $dipe_cf7_fs = fs_dynamic_init(
                array(
                    'id'                  => '6220',
                    'slug'                => 'cf7-styler-for-divi',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_5ed03b8670d0cfbf345aa03dc6c80',
                    'is_premium'          => false,
                    #START_REPLACE #END_REPLACE
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'    => 'dipe_cf7_styler_options',
                        'account' => true,
                        'contact' => false,
                        'support' => false,
                        'parent'  => array(
                            'slug' => 'et_divi_options',
                        ),
                    ),
                )
            );
        }

        return $dipe_cf7_fs;
    }

    // Init Freemius.
    dipe_cf7_fs();

    dipe_cf7_fs()->add_filter( 'show_deactivation_feedback_form', '__return_false' );

    // Signal that SDK was initiated.
    do_action( 'dipe_cf7_fs_loaded' );
}
#ET_END_REPLACE
//phpcs:enable
define( 'DIPE_CF7_VERSION', '1.3.2' );
define( 'DIPE_CF7_STABLE_VERSION', '1.2.6' );
define( 'DIPE_CF7_URL', plugins_url( '/', __FILE__ ) );
define( 'DIPE_ASSETS_URL', trailingslashit( DIPE_CF7_URL . 'assets' ) );
define( 'DIPE_CF7_PATH', plugin_dir_path( __FILE__ ) );
define( 'DIPE_CF7_PLUGIN_BASE', plugin_basename( __FILE__ ) );

load_plugin_textdomain(
    'dvppl-cf7-styler',
    false,
    dirname( plugin_basename( __FILE__ ) ) . '/languages/'
);

if ( !class_exists( 'Dipe_Cf7_Module' ) ) {

    final class Dipe_Cf7_Module {

        private static $instance;

        private function __construct() {
            register_activation_hook( __FILE__, array( $this, 'activate' ) );
        }

        public static function instance() {
            if ( !isset( self::$instance ) && !( self::$instance instanceof Dipe_Cf7_Module ) ) {
                self::$instance = new Dipe_Cf7_Module();
                self::$instance->init();
                self::$instance->includes();
            }

            return self::$instance;
        }

        private function init() {
            add_action( 'divi_extensions_init', array( $this, 'initialize_extension' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        }

        public function activate() {
            update_option( 'dipe_version', DIPE_CF7_VERSION );

            if ( get_option( '_dipe_cf7_installed_time' ) === false ) {
                update_option( '_dipe_cf7_installed_time', strtotime( 'now' ) );
            }
        }

        public function enqueue_scripts() {
            $options = get_option( 'dipe_options' );
            $grid    = isset( $options['grid'] ) ? $options['grid'] : 'off';

            if ( 'on' === $grid ) {
                wp_enqueue_style( 'dipe-grid', DIPE_ASSETS_URL . 'css/cf7-grid.css' );
            }

            wp_enqueue_style( 'dipe-module', DIPE_ASSETS_URL . 'css/module.css' );
        }

        private function includes() {
            $options = get_option( 'dipe_options' );
            $grid    = isset( $options['grid'] ) ? $options['grid'] : 'off';

            require_once DIPE_CF7_PATH . 'includes/functions.php';

            if ( 'on' === $grid ) {
                require_once DIPE_CF7_PATH . 'includes/shortcode.php';
                require_once DIPE_CF7_PATH . 'includes/tag.php';
            }

            if ( is_admin() ) {
                //phpcs:ignore
                // require_once DIPE_CF7_PATH . 'includes/notice.php';
                require_once DIPE_CF7_PATH . 'includes/admin/admin.php';
                require_once DIPE_CF7_PATH . 'includes/admin/rollback.php';
            }
        }

        public function initialize_extension() {
            require_once DIPE_CF7_PATH . 'includes/Cf7StylerMain.php';
        }
    }
}

// Instance function.
function dipe_cf7_styler_module() {
    return Dipe_Cf7_Module::instance();
}

// Kickoff.
dipe_cf7_styler_module();
