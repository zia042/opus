<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Button\Admin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Effects8
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Modules\Button\Modules as Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Effects8 extends Modules {

    public function register_effects() {
        return $this->add_control(
                        'image_hover_effects', $this->style, [
                    'label' => esc_html__('Effects Direction', 'image-hover-effects-ultimate'),
                    'type' => Controls::SELECT,
                    'default' => 'left_to_right',
                    'options' => [
                        'left_to_right' => esc_html__('Left to Right', 'image-hover-effects-ultimate'),
                        'top_to_bottom' => esc_html__('Top to Bottom', 'image-hover-effects-ultimate'),
                    ],
                    'selector' => [
                        '{{WRAPPER}} .oxi-image-hover-figure' => '',
                    ],
                    'simpledescription' => 'Allows you to Set Effects Direction.',
                    'description' => 'Allows you to Set Effects Direction.',
                        ]
        );
    }

}
