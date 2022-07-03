<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Page;

if (!defined('ABSPATH')) {
    exit;
}

class Admin {

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
    public $child_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    use \OXI_IMAGE_HOVER_PLUGINS\Helper\Public_Helper;
    use \OXI_IMAGE_HOVER_PLUGINS\Helper\CSS_JS_Loader;

    /**
     * Constructor of Image Hover Home Page
     *
     * @since 9.3.0
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->CSSJS_load();
        $this->Render();
    }

    public function CSSJS_load() {
        $this->admin_css_loader();
        $this->admin_home();
        $this->admin_rest_api();
        apply_filters('oxi-image-hover-plugin/admin_menu', TRUE);
    }

    public function font_awesome_render($data) {
        $fadata = get_option('oxi_addons_font_awesome');
        if ($fadata != 'no') :
            wp_enqueue_style('font-awsome.min', OXI_IMAGE_HOVER_URL . '/assets/frontend/css/font-awsome.min.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        endif;
        ?>
        <i class="<?php echo esc_attr($data); ?> oxi-icons"></i>
        <?php
    }

    /**
     * Admin Notice JS file loader
     * @return void
     */
    public function admin_rest_api() {
        wp_enqueue_script('oxi-image-hover-shortcode', OXI_IMAGE_HOVER_URL . '/assets/backend/js/home.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }
     public function name_converter($data) {
        $data = str_replace('_', ' ', $data);
        $data = str_replace('-', ' ', $data);
        $data = str_replace('+', ' ', $data);
        echo esc_html(ucwords($data));
    }

    public function Render() {
        ?>
        <div class="oxi-addons-row">
            <?php
            $this->Elements_Render();
            ?>
        </div>
        <?php
    }

    public function Admin_header() {
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-import-layouts">
                <h1>Image Hover › Shortcode</h1>
                <p>Collect Image Hover Shortcode, Edit, Delect, Clone or Export it. </p>
            </div>
        </div>
        <?php
    }

    public function Elements_Render() {
        $Elements = [
            'Image-Effects' => [
                'button' => ['name' => 'button-effects', 'version' => 1.0],
                'general' => ['name' => 'general-effects', 'version' => 1.0],
                'square' => ['name' => 'square-effects', 'version' => 1.0],
                'caption' => ['name' => 'caption-effects', 'version' => 1.0],
                'flipbox' => ['name' => 'flipbox-effects', 'version' => 1.0],
                'magnifier' => ['name' => 'image-magnifier', 'version' => 1.0],
                'comparison' => ['name' => 'image-comparison', 'version' => 1.0],
                'lightbox' => ['name' => 'image-lightbox', 'version' => 1.0],
            ],
            'Extension' => [
                'display' => [
                    'name' => 'display-post',
                    'version' => 1.0
                ],
                'carousel' => [
                    'name' => 'carousel-slider',
                    'version' => 1.0
                ],
                'filter' => [
                    'name' => 'filter-&-sorting',
                    'version' => 1.0
                ],
            ]
        ];
        ?>
        <div class="oxi-addons-wrapper">
            <div class="oxi-addons-row">
                <?php
                foreach ($Elements as $key => $elements) {
                    ?>
                    <div class="oxi-addons-text-blocks-body-wrapper">
                        <div class="oxi-addons-text-blocks-body">
                            <div class="oxi-addons-text-blocks">
                                <div class="oxi-addons-text-blocks-heading"><?php echo esc_html($key); ?></div>
                                <div class="oxi-addons-text-blocks-border">
                                    <div class="oxi-addons-text-block-border"></div>
                                </div>
                                <div class="oxi-addons-text-blocks-content">Available (<?php echo (int) count($elements); ?>)</div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $elementshtml = '';

                    foreach ($elements as $k => $value) {
                        $oxilink = 'admin.php?page=oxi-image-hover-ultimate&effects=' . $k;
                        ?>
                        <div class="oxi-addons-shortcode-import" id="<?php echo esc_attr($value['name']); ?>" oxi-addons-search="<?php echo esc_html($value['name']); ?>">
                            <a class="addons-pre-check" href="<?php echo esc_url(admin_url($oxilink)); ?>" sub-type="<?php
                            if (apply_filters('oxi-image-hover-plugin-version', false) == false && $key == 'Extension'):
                                echo 'premium';
                            endif;
                            ?>">
                                <div class="oxi-addons-shortcode-import-top">
                                    <?php
                                    $ifco = array_key_exists('icon', $value) ? $value['icon'] : 'fas fa-cloud-download-alt';
                                    $this->font_awesome_render($ifco);
                                    ?>

                                </div>
                                <div class="oxi-addons-shortcode-import-bottom">
                                    <span><?php $this->name_converter($value['name']) ?> <?php
                                        if (apply_filters('oxi-image-hover-plugin-version', false) == false && $key == 'Extension'):
                                            ?>
                                            <b style="color: red;font-weight: 600;font-size: 12px;">Pro Only</b>
                                            <?php
                                        endif;
                                        ?></span>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <?php
    }

   

}
