<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Flipbox\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects18 extends Public_Render {

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-flipbox', OXI_IMAGE_HOVER_URL . '/Modules/Flipbox/Files/flipbox.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_style('oxi-image-hover-flipbox-style-18', OXI_IMAGE_HOVER_URL . '/Modules/Flipbox/Files/style-18.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function default_render($style, $child, $admin) {

        foreach ($child as $key => $val) {
            $value = json_decode(stripslashes($val['rawdata']), true);
            $ht = '';
            ?>
            <div class="oxi-image-hover-style <?php $this->column_render('oxi-image-hover-col', $style); ?> <?php
            if ($admin == "admin"):
                echo 'oxi-addons-admin-edit-list';
            endif;
            ?>"  <?php $this->animation_render('oxi-image-hover-animation', $style); ?>>
                <div class="oxi-image-hover-style-flipbox">
                    <?php
                    if ($this->checkurl_render('image_hover_button_link', $value) === true && empty($value['image_hover_button_text'])):
                        $ht = true;
                        ?>
                        <a <?php $this->url_render('image_hover_button_link', $value); ?>>
                            <?php
                        endif;
                        ?>
                        <div class="oxi-image-hover oxi-image-flipbox-hover oxi-image-flipbox-hover-style-18 oxi-image-flipbox-hover-<?php echo esc_attr($this->oxiid); ?>-<?php echo esc_attr($val['id']); ?>">
                            <div class="oxi-image-hover-figure <?php echo esc_attr($style['image_hover_effects']); ?> <?php echo esc_attr($style['image_hover_timing_type']); ?>">
                                <div class="oxi-image-hover-figure-frontend">
                                    <div class="oxi-image-hover-figure-front-section  <?php echo esc_attr($this->style['oxi-image-flip-front-alignment']); ?>">
                                        <div class="oxi-image-hover-icon-section">
                                            <?php
                                            if ($value['image_hover_front_icon'] != ''):
                                                ?>
                                                <div class="oxi-image-hover-icon"><?php $this->font_awesome_render($value['image_hover_front_icon']); ?></div>
                                                <?php
                                            endif;
                                            ?>
                                        </div>
                                        <?php
                                        if ($value['image_hover_front_heading'] != ''):
                                            ?>
                                            <div class="oxi-image-hover-heading  <?php echo esc_attr($style['oxi-image-flip-front-heading-underline']); ?>"><?php $this->text_render($value['image_hover_front_heading']); ?></div>
                                            <?php
                                        endif;
                                        if ($value['image_hover_front_description'] != ''):
                                            ?>
                                            <div class="oxi-image-hover-content"><?php $this->text_render($value['image_hover_front_description']); ?></div>
                                            <?php
                                        endif;
                                        ?>    
                                    </div>
                                </div>
                                <div class="oxi-image-hover-figure-backend">
                                    <div class="oxi-image-hover-figure-back-section <?php echo esc_attr($this->style['oxi-image-flip-back-content-alignment']); ?>">
                                        <?php
                                        if ($value['image_hover_back_heading'] != ''):
                                            ?>
                                            <div class="oxi-image-hover-heading <?php echo esc_attr($style['oxi-image-flip-back-heading-underline']); ?> <?php echo esc_attr($this->style['oxi-image-flip-back-heading-animation']); ?>  <?php echo esc_attr($this->style['oxi-image-flip-back-animation-delay']); ?>"> <?php $this->text_render($value['image_hover_back_heading']); ?></div>
                                            <?php
                                        endif;

                                        if ($value['image_hover_back_description'] != ''):
                                            ?>
                                            <div class="oxi-image-hover-content  <?php echo esc_attr($this->style['oxi-image-flip-back-desc-animation']); ?>  <?php echo esc_attr($this->style['oxi-image-flip-back-desc-animation-delay']); ?>"> <?php $this->text_render($value['image_hover_back_description']); ?></div>
                                            <?php
                                        endif;

                                        if ($value['image_hover_button_text'] != '' && $this->checkurl_render('image_hover_button_link', $value) == true):
                                            ?>
                                            <div class="oxi-image-hover-button  <?php echo esc_attr($this->style['oxi-image-flip-back-button-animation']); ?>  <?php echo esc_attr($this->style['oxi-image-flip-back-button-animation-delay']); ?>">
                                                <a  <?php $this->url_render('image_hover_button_link', $value); ?> class="oxi-image-btn"><?php $this->text_render($value['image_hover_button_text']); ?></a>
                                            </div>
                                            <?php
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        if ($ht === true):
                            ?>
                        </a>
                        <?php
                    endif;
                    ?>
                </div> 
                <?php
                if ($admin == 'admin') :
                    $this->oxi_addons_admin_edit_delete_clone($val['id']);
                endif;

                if ($this->media_background_render('image_hover_front_image', $value) != ''):
                    $url = $this->media_background_render('image_hover_front_image', $value);
                    $this->inline_css .= '.' . $this->WRAPPER . ' .oxi-image-flipbox-hover-' . $this->oxiid . '-' . $val['id'] . ' .oxi-image-hover-figure-frontend:after{background: url(' . $url . ');-moz-background-size: 100% 100% !important;-o-background-size: 100% 100% !important; background-size: 100% 100% !important;}';
                endif;
                if ($this->media_background_render('image_hover_back_image', $value) != ''):
                    $url = $this->media_background_render('image_hover_back_image', $value);
                    $this->inline_css .= '.' . $this->WRAPPER . ' .oxi-image-flipbox-hover-' . $this->oxiid . '-' . $val['id'] . ' .oxi-image-hover-figure-backend:after{background: url(' . $url . ');-moz-background-size: 100% 100% !important;-o-background-size: 100% 100% !important; background-size: 100% 100% !important;}';
                endif;
                ?>
            </div> 
            <?php
        }
    }

}
