<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

if (!defined('ABSPATH'))
    exit;

/**
 * Description of Bootstrap
 *
 * @author $biplob018
 */
use OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi as IMAGEAPI;

class Bootstrap {

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Admin_helper;

    // instance container
    private static $instance = null;

    /**
     * Define $wpdb
     *
     * @since 9.3.0  
     */
    public $wpdb;

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct() {
        do_action('image-hover-effects-ultimate/before_init');
        // Load translation
        add_action('init', array($this, 'i18n'));

        new IMAGEAPI();
        if (is_admin()) {
            $this->User_Admin();
            $this->User_Reviews();
        }
        $this->Admin_Filters();
        $this->Shortcode_loader();
        $this->Public_loader();
        add_action('init', [$this, 'register_image_hover_ultimate_update']);
    }

    public function register_image_hover_ultimate_update() {
        $check = get_option('image_hover_ultimate_update_complete');
        if ($check != 'done') :
            add_action('image_hover_ultimate_update', [$this, 'plugin_update']);
            wp_schedule_single_event(time() + 10, 'image_hover_ultimate_update');
        endif;
    }

    public function plugin_update() {
        $upgrade = new \OXI_IMAGE_HOVER_PLUGINS\Classes\ImageApi();
        $upgrade->update_image_hover_plugin();
    }

    /**
     * Load Textdomain
     *
     * @since 9.3.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain('image-hover-effects-ultimate');
    }

    /**
     * Shortcode loader
     *
     * @since 9.3.0
     * @access public
     */
    protected function Shortcode_loader() {
        add_shortcode('iheu_ultimate_oxi', [$this, 'WP_Shortcode']);
        new \OXI_IMAGE_HOVER_PLUGINS\Modules\Visual_Composer();
        $ImageWidget = new \OXI_IMAGE_HOVER_PLUGINS\Modules\Widget();
        add_filter('widget_text', 'do_shortcode');
        add_action('widgets_init', array($ImageWidget, 'iheu_widget_widget'));
    }

    /**
     * Execute Shortcode
     *
     * @since 9.3.0
     * @access public
     */
    public function WP_Shortcode($atts) {
        extract(shortcode_atts(array('id' => ' ',), $atts));
        $styleid = (int) $atts['id'];
        ob_start();
        $this->shortcode_render($styleid, 'user');
        return ob_get_clean();
    }

    public function Public_loader() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
    }

    public function Admin_Filters() {
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d737570706f72742d616e642d636f6d6d656e7473'), array($this, $this->fixed_data('537570706f7274416e64436f6d6d656e7473')));
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d706c7567696e2d76657273696f6e'), array($this, $this->fixed_data('636865636b5f63757272656e745f76657273696f6e')));
        add_filter($this->fixed_data('6f78692d696d6167652d686f7665722d706c7567696e2f61646d696e5f6d656e75'), array($this, $this->fixed_data('6f78696c61625f61646d696e5f6d656e75')));
    }

    public function User_Admin() {
        add_action('admin_menu', [$this, 'Admin_Menu']);
        add_action('admin_head', [$this, 'Admin_Icon']);
        add_action('admin_init', array($this, 'redirect_on_activation'));
    }

}
