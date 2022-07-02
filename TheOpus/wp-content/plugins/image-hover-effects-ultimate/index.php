<?php

/*
  Plugin Name: Image Hover Effects Ultimate (Photo Gallery, Effects, Lightbox, Comparison or Magnifier)
  Plugin URI: https://www.oxilabdemos.com/image-hover
  Description: Create Awesome Image Hover Effects as Image Gallery, Lightbox, Comparison or Magnifier with Impressive, Lightweight, Responsive Image Hover Effects Ultimate. Use 500+ modern and elegant CSS hover effects and animations.
  Author: Biplob Adhikari
  Author URI: http://www.oxilab.org/
  Version: 9.8.2
 */

if (!defined('ABSPATH'))
    exit;

define('OXI_IMAGE_HOVER_FILE', __FILE__);
define('OXI_IMAGE_HOVER_BASENAME', plugin_basename(__FILE__));
define('OXI_IMAGE_HOVER_PATH', plugin_dir_path(__FILE__));
define('OXI_IMAGE_HOVER_URL', plugins_url('/', __FILE__));
define('OXI_IMAGE_HOVER_PLUGIN_VERSION', '9.8.2');
define('OXI_IMAGE_HOVER_TEXTDOMAIN', 'image-hover-effects-ultimate');

/* * S
 * Including composer autoloader globally.
 *
 * @since 9.3.0
 */
require_once OXI_IMAGE_HOVER_PATH . 'autoloader.php';

/**
 * Run plugin after all others plugins
 *
 * @since 9.3.0
 */
add_action('plugins_loaded', function () {
    \OXI_IMAGE_HOVER_PLUGINS\Classes\Bootstrap::instance();
});

/**
 * Activation hook
 *
 * @since 9.3.0
 */
register_activation_hook(__FILE__, function () {
    $Installation = new \OXI_IMAGE_HOVER_PLUGINS\Classes\Installation();
    $Installation->plugin_activation_hook();
});

