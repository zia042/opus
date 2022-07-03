<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Filter\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects2 extends Public_Render {

    public function public_jquery() {
        wp_enqueue_script('imagesloaded.pkgd.min', OXI_IMAGE_HOVER_URL . '/Modules/Filter/Files/imagesloaded.pkgd.min.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_script('jquery.isotope', OXI_IMAGE_HOVER_URL . '/Modules/Filter/Files/jquery.isotope.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->JSHANDLE = 'jquery.isotope';
    }

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-filter-style-2', OXI_IMAGE_HOVER_URL . '/Modules/Filter/Files/style-2.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function custom_column_render($id) {
        if (!array_key_exists($id . '-tab', $this->style) || $this->style[$id . '-tab'] == ''):
            if ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-8'):
                $this->style[$id . '-tab'] = 'oxi-bt-col-md-3';
            elseif ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-5'):
                $this->style[$id . '-tab'] = 'oxi-bt-col-md-6';
            elseif ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-4'):
                $this->style[$id . '-tab'] = 'oxi-bt-col-md-6';
            elseif ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-3'):
                $this->style[$id . '-tab'] = 'oxi-bt-col-md-6';
            else:
                $this->style[$id . '-tab'] = 'oxi-bt-col-md-12';
            endif;
        endif;
        if (!array_key_exists($id . '-mob', $this->style) || $this->style[$id . '-mob'] == ''):
            if ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-2'):
                $this->style[$id . '-mob'] = 'oxi-bt-col-sm-6';
            elseif ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-8'):
                $this->style[$id . '-mob'] = 'oxi-bt-col-sm-6';
            elseif ($this->style[$id . '-lap'] == 'oxi-bt-col-lg-1'):
                $this->style[$id . '-mob'] = 'oxi-bt-col-sm-6';
            else:
                $this->style[$id . '-mob'] = 'oxi-bt-col-sm-12';
            endif;
        endif;
    }

    public function inline_public_css() {
        $this->custom_column_render('category_col');
        $styledata = $this->style;

        $item_width = '.' . $this->WRAPPER . ' .image-hover-category-item-show {
                        width: ' . (100 / explode('-', $styledata['category_col-lap'])[4]) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_2-lap {
                        width: ' . ((100 / explode('-', $styledata['category_col-lap'])[4]) * 2) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_3-lap {
                        width: ' . ((100 / explode('-', $styledata['category_col-lap'])[4]) * 3) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_4-lap {
                        width: ' . ((100 / explode('-', $styledata['category_col-lap'])[4]) * 4) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show {
                        max-width: 100%;
                    }
                @media only screen and (min-width : 669px) and (max-width : 993px){
                    .' . $this->WRAPPER . ' .image-hover-category-item-show {
                        width: ' . (100 / explode('-', $styledata['category_col-tab'])[4]) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_2-tab {
                        width: ' . ((100 / explode('-', $styledata['category_col-tab'])[4]) * 2) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_3-tab {
                        width: ' . ((100 / explode('-', $styledata['category_col-tab'])[4]) * 3) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_4-tab {
                        width: ' . ((100 / explode('-', $styledata['category_col-tab'])[4]) * 4) . '%;
                    }
                }
                @media only screen and (max-width : 668px){
                    .' . $this->WRAPPER . ' .image-hover-category-item-show {
                        width: ' . (100 / explode('-', $styledata['category_col-mob'])[4]) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_2-mob {
                        width: ' . ((100 / explode('-', $styledata['category_col-mob'])[4]) * 2) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_3-mob {
                        width: ' . ((100 / explode('-', $styledata['category_col-mob'])[4]) * 3) . '%;
                    }
                    .' . $this->WRAPPER . ' .image-hover-category-item-show.grid_item_width_4-mob {
                        width: ' . ((100 / explode('-', $styledata['category_col-mob'])[4]) * 4) . '%;
                    }
                }
                ';
        return $item_width;
    }

    public function inline_public_jquery() {
        $jquery = '';
        $oxiid = $this->oxiid;
        $jquery = ' $(".image-hover-category-data-' . $oxiid . '").imagesLoaded(function(){
                        $(".image-hover-category-data-' . $oxiid . '").isotope({
                            filter: "*",
                            animationOptions: {
                                duration: 750,
                                easing: "linear",
                                queue: false
                            },
                            layoutMode: "masonry",
                        });
                    });
                    $(".image-hover-category-menu-' . $oxiid . ' .image-hover-category-menu-item").on("click", function () {
                        if(!$(this).hasClass("oxi_active")){
                            $(".image-hover-category-menu-' . $oxiid . ' .image-hover-category-menu-item").removeClass("oxi_active");
                            $(this).addClass("oxi_active");
                            var selector = jQuery(this).attr("cat_ref");
                            $(".image-hover-category-data-' . $oxiid . '").isotope({
                                filter: selector, 
                                animationOptions: {
                                    duration: 750, 
                                    easing: "linear",
                                    queue: false
                                }
                            });
                            return false;
                        }
                    });';

        return $jquery;
    }

    public function default_render($style, $child, $admin) {
        $styledata = $this->style;
        $oxiid = $this->oxiid;
        $all_cat_data = (array_key_exists('category_menu_settings', $styledata) && is_array($styledata['category_menu_settings'])) ? $styledata['category_menu_settings'] : [];
        $active_default = '';
        if (array_key_exists('category_parent_cat', $styledata) && $styledata['category_parent_cat'] != '') :
            $active_default = $styledata['category_parent_cat'];
        endif;
        ?>
        <div class="image-hover-filter-style image-hover-filter-style-2">
            <div class="image-hover-category-menu image-hover-category-menu-<?php echo (int) $oxiid; ?>">
                <?php
                foreach ($all_cat_data as $value) :
                    ?>
                <div class="image-hover-category-menu-item <?php echo esc_attr($styledata['category_menu_width_type']); ?>  <?php
                    if ($active_default == $value['category_item_text']) :
                        echo 'oxi_active';
                    endif;
                    ?> " cat_ref="<?php
                         if ($active_default == $value['category_item_text']) :
                             echo '*';
                         else :
                             echo '.';
                             $this->CatStringToClassReplacce($value['category_item_text'], $oxiid) . '';
                         endif;
                         ?>">
                             <?php $this->text_render($value['category_item_text']); ?>
                    </div>
                    <?php
                endforeach;
                ?>     </div>

            <div class="image-hover-category  image-hover-category-<?php echo (int) $oxiid; ?>">
                <div class="image-hover-category-data  image-hover-category-data-<?php echo (int) $oxiid; ?>"><?php
                    foreach ($child as $value) :
                        $childdata = json_decode(stripslashes($value['rawdata']), true);
                        ?>
                       <div class="image-hover-category-item-show  <?php
                                   $select_cat_data = (array_key_exists('image_hover_category_select', $childdata) && is_array($childdata['image_hover_category_select'])) ? $childdata['image_hover_category_select'] : [];

                                   foreach ($select_cat_data as $item) :
                                       $this->CatStringToClassReplacce($item, $oxiid) ;
                                       echo ' ';
                                   endforeach;
                                   ?> <?php echo esc_attr($childdata['category_item_col-lap'] . '-lap'); ?> <?php echo esc_attr($childdata['category_item_col-tab'] . '-tab'); ?> <?php echo esc_attr($childdata['category_item_col-mob'] . '-mob'); ?> <?php
                                   if ($admin == "admin"):
                                       echo '  oxi-addons-admin-edit-list';
                                   endif;
                                   ?>">
                                       <?php
                                       $this->text_render($childdata['image_hover_info']);
                                       if ($admin == 'admin'):
                                           $this->oxi_addons_admin_edit_delete_clone($value['id']);
                                       endif;
                                       ?>
                        </div><?php
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function CatStringToClassReplacce($string, $number = '000') {
        $entities = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', "t");
        $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", " ");
        echo esc_attr('sa_STCR_' . str_replace($replacements, $entities, urlencode($string)) . $number);
    }

}
