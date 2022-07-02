<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Carousel\Render;

if (!defined('ABSPATH')) {
    exit;
}

use OXI_IMAGE_HOVER_PLUGINS\Page\Public_Render;

class Effects1 extends Public_Render {

    public function public_jquery() {
        wp_enqueue_script('oxi-image-carousel-slick.min', OXI_IMAGE_HOVER_URL . '/Modules/Carousel/Files/slick.min.js', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        $this->JSHANDLE = 'oxi-image-carousel-slick.min';
    }

    public function public_css() {
        wp_enqueue_style('oxi-image-hover-carousel-slick', OXI_IMAGE_HOVER_URL . '/Modules/Carousel/Files/slick.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        wp_enqueue_style('oxi-image-hover-style-1', OXI_IMAGE_HOVER_URL . '/Modules/Carousel/Files/style-1.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
    }

    public function render() {
        ?>
        <div class="oxi-addons-container <?php echo esc_attr($this->WRAPPER); ?> oxi-image-hover-wrapper-<?php
        if (array_key_exists('carousel_register_style', $this->style)):
            echo esc_attr($this->style['carousel_register_style']);
        endif;
        ?>" id="<?php echo esc_attr($this->WRAPPER); ?>">
            <div class="oxi-addons-row">
                <?php
                $this->default_render($this->style, $this->child, $this->admin);
                ?>
            </div>
        </div>
        <?php
    }

    public function public_column_render($col) {
        $column = 1;
        if (count(explode('-lg-', $col)) == 2) :
            $column = explode('-lg-', $col)[1];
        elseif (count(explode('-md-', $col)) == 2) :
            $column = explode('-md-', $col)[1];
        elseif (count(explode('-sm-', $col)) == 2) :
            $column = explode('-sm-', $col)[1];
        endif;
        if ($column == 12) :
            return 1;
        elseif ($column == 6) :
            return 2;
        elseif ($column == 4) :
            return 3;
        elseif ($column == 3) :
            return 4;
        elseif ($column == 2) :
            return 6;
        else :
            return 12;
        endif;
    }

    public function inline_public_css() {
        $css = '';
    }
   public function custom_font_awesome_render($data) {
        $fadata = get_option('oxi_addons_font_awesome');
        if ($fadata != 'no') :
            wp_enqueue_style('font-awsome.min', OXI_IMAGE_HOVER_URL . '/assets/frontend/css/font-awsome.min.css', false, OXI_IMAGE_HOVER_PLUGIN_VERSION);
        endif;
        return '<i class="' . esc_attr($data) . ' oxi-icons"></i>';
    }
    public function default_render($style, $child, $admin) {
        if (!array_key_exists('carousel_register_style', $style) && $style['carousel_register_style'] < 1) :
            ?>
            <p>Kindly Select Image Effects First to Extend Carousel.</p>
            <?php
            return;
        endif;
        $styledata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $style['carousel_register_style']), ARRAY_A);

        if (!is_array($styledata)) :
            ?>
            <p> Style Data not found. Kindly Check Carousel & Slider <a href="https://www.oxilabdemos.com/image-hover/docs/hover-extension/carousel-slider/">Documentation</a>.</p>
            <?php
            return;
        endif;
        $files = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d", $style['carousel_register_style']), ARRAY_A);
        $StyleName = explode('-', ucfirst($styledata['style_name']));
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $StyleName[0] . '\Render\Effects' . $StyleName[1];
        new $cls($styledata, $files, 'request');

        $col = json_decode(stripslashes($styledata['rawdata']), true);

        $lap = $this->public_column_render($col['oxi-image-hover-col-lap']);
        $tab = $this->public_column_render($col['oxi-image-hover-col-tab']);
        $mobile = $this->public_column_render($col['oxi-image-hover-col-mob']);

        $lap_item = $style['carousel_item_slide-lap-size'];
        $tab_item = $style['carousel_item_slide-tab-size'];
        $mobile_item = $style['carousel_item_slide-mob-size'];

        $prev = $this->custom_font_awesome_render($style['carousel_left_arrow']);
        $next = $this->custom_font_awesome_render($style['carousel_right_arrow']);

        $autoplay = ($style['carousel_autoplay'] == 'yes') ? 'true' : 'false';
        $autoplayspeed = $style['carousel_autoplay_speed'];
        $speed = $style['carousel_speed'];
        $pause_on_hover = ($style['carousel_pause_on_hover'] == 'yes') ? 'true' : 'false';
        $infinite = ($style['carousel_infinite'] == 'yes') ? 'true' : 'false';
        $adaptiveheight = ($style['carousel_adaptive_height'] == 'yes') ? 'true' : 'false';
        $center_mode = ($style['carousel_center_mode'] == 'yes') ? 'true' : 'false';

        $arrows = ($style['carousel_show_arrows'] == 'yes') ? 'true' : 'false';
        $dots = ($style['carousel_show_dots'] == 'yes') ? 'true' : 'false';

        $jquery = '(function ($) {
            $(".' . $this->WRAPPER . ' .oxi-addons-row").slick({
                fade: false,
                autoplay: ' . $autoplay . ',
                autoplaySpeed: ' . $autoplayspeed . ',
                speed: ' . $speed . ',
                infinite: ' . $infinite . ',
                pauseOnHover: ' . $pause_on_hover . ',
                adaptiveHeight: ' . $adaptiveheight . ',
                arrows: ' . $arrows . ',
                prevArrow: \'<div class="oxi_carousel_arrows oxi_carousel_prev">' . $prev . '</div>\',
                nextArrow: \'<div class="oxi_carousel_arrows oxi_carousel_next">' . $next . '</div>\',
                dots: ' . $dots . ',
                dotsClass: "oxi_carousel_dots",
                slidesToShow: ' . $lap . ',
                slidesToScroll:  ' . $lap_item . ',
                centerMode: ' . $center_mode . ',
                rtl: false,
                responsive: [
                    {
                        breakpoint: 991,
                        settings: {
                        slidesToShow:  ' . $tab . ',
                        slidesToScroll:  ' . $tab_item . '
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                        slidesToShow:  ' . $mobile . ',
                        slidesToScroll:  ' . $mobile_item . '
                        }
                    }
                ]
            });
        })(jQuery);';
        wp_add_inline_script($this->JSHANDLE, $jquery);
    }

}
