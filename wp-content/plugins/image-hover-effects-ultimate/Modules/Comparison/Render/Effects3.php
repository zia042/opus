<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Comparison\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects3 extends Public_Render {

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-comparison-box', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/Comparison.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_style('oxi-image-hover-comparison-style-3', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/style-3.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_style('oxi-addons-main-wrapper-image-comparison-style-3', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/mbac.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function public_jquery() {
        $this->JSHANDLE = 'jquery-mbac';
        wp_enqueue_script('jquery-mbac', OXI_IMAGE_HOVER_URL . '/Modules/Comparison/Files/mbac.js', true, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function default_render($style, $child, $admin) {
        ?>
        <div class="oxi-addons-main-wrapper-image-comparison-style-3 oxi_addons__image_comparison_wrapper oxi-addons-main-wrapper-image-comparison">
            <div class="oxi-addons-main <?php echo esc_attr($style['oxi_image_magnifier_image_switcher']); ?>">
                <div style="width:100%" id="oxi-addons-mbac-<?php echo (int) $this->oxiid; ?>"  class="mbac-wrap"> 
                    <ul class="mbac">
                        <?php
                        foreach ($child as $key => $val) {
                            $data = json_decode(stripslashes($val['rawdata']), true);
                            ?>
                            <li class="<?php
                            if ($admin == "admin") {
                                echo 'oxi-addons-admin-edit-list';
                            }
                            ?>">
                                <img <?php $this->media_render('oxi_image_accordion_image', $data) ?> class="oxi-img">
                                <?php
                                if ($admin == 'admin'):
                                    $this->oxi_addons_admin_edit_delete_clone($val['id']);
                                endif;
                                ?>
                            </li>
                            <?php
                        }
                        ?>
                    </ul> 
                </div>
            </div>
        </div>
        <?php
    }

    public function inline_public_jquery() {
        $jquery = '';
        $jquery .= ' jQuery("#oxi-addons-mbac-' . $this->oxiid . '").mbac(); ';
        return $jquery;
    }

}
