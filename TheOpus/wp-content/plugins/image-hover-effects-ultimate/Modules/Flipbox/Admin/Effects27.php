<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Modules\Flipbox\Admin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Description of Effects27
 *
 * @author biplo
 */
use OXI_IMAGE_HOVER_PLUGINS\Modules\Flipbox\Modules as Modules;
use OXI_IMAGE_HOVER_PLUGINS\Classes\Controls as Controls;

class Effects27 extends Modules {

    public function register_frontend_tabs() {
        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'frontend'
            ]
                ]
        );
        $this->start_section_devider();
        $this->register_front_content_settings();
        $this->end_section_devider();
        $this->start_section_devider();
        $this->register_front_heading_settings();
        $this->register_front_icon_settings();
        $this->end_section_devider();
        $this->end_section_tabs();
    }

    public function register_front_icon_settings() {
        $this->start_controls_section(
                'imahe-hover', [
            'label' => esc_html__('Icon Settings', 'image-hover-effects-ultimate'),
            'showing' => FALSE,
                ]
        );

        $this->add_responsive_control(
                'oxi-image-flip-front-icon-size', $this->style, [
            'label' => esc_html__('Icon Size', 'image-hover-effects-ultimate'),
            'type' => Controls::SLIDER,
            'default' => [
                'unit' => 'px',
                'size' => 20,
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-front-section .oxi-image-hover-icon .oxi-icons' => 'font-size:{{SIZE}}{{UNIT}};',
            ],
            'description' => 'Allows you to Set Icon Size.',
                ]
        );
        $this->add_control(
                'oxi-image-flip-front-icon-color', $this->style, [
            'label' => esc_html__('Color', 'image-hover-effects-ultimate'),
            'type' => Controls::COLOR,
            'default' => '#b414c9',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-front-section .oxi-image-hover-icon .oxi-icons' => 'color: {{VALUE}};',
            ],
            'description' => 'Color property is used to set the color of the Icon.',
                ]
        );

        $this->add_responsive_control(
                'oxi-image-flip-front-icon-margin', $this->style, [
            'label' => esc_html__('Margin', 'image-hover-effects-ultimate'),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure-front-section .oxi-image-hover-icon ' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ], 'description' => 'Margin properties are used to create space around Icon.',
                ]
        );
        $this->end_controls_section();
    }

    public function register_backend_tabs() {
        $this->start_section_tabs(
                'oxi-image-hover-start-tabs', [
            'condition' => [
                'oxi-image-hover-start-tabs' => 'backend'
            ]
                ]
        );
        $this->start_section_devider();
        $this->register_back_content_settings();
        $this->register_back_description_settings();
        $this->end_section_devider();

        $this->start_section_devider();
        $this->register_back_button_settings();
        $this->end_section_devider();

        $this->end_section_tabs();
    }

    public function register_back_button_settings() {
        $this->start_controls_section(
                'oxi-image-hover', [
            'label' => esc_html__('Button Settings', 'image-hover-effects-ultimate'),
            'showing' => false,
                ]
        );
        $this->add_control(
                'oxi-image-flip-back-button-position', $this->style, [
            'label' => esc_html__('Position', 'image-hover-effects-ultimate'),
            'type' => Controls::CHOOSE,
            'operator' => Controls::OPERATOR_ICON,
            'default' => 'center',
            'toggle' => true,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'image-hover-effects-ultimate'),
                    'icon' => 'fa fa-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'image-hover-effects-ultimate'),
                    'icon' => 'fa fa-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'image-hover-effects-ultimate'),
                    'icon' => 'fa fa-align-right',
                ],
            ],
            'selector' => [
                '{{WRAPPER}}  .oxi-image-hover-button' => 'text-align:{{VALUE}}',
            ],
            'description' => 'Allows you set Button Align as Left, Center or Right.',
                ]
        );

        $this->add_group_control(
                'oxi-image-flip-back-button-typho', $this->style, [
            'type' => Controls::TYPOGRAPHY,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => '',
            ]
                ]
        );
        $this->start_controls_tabs(
                'oxi-image-hover-start-tabs', [
            'options' => [
                'normal' => esc_html__('Normal ', 'image-hover-effects-ultimate'),
                'hover' => esc_html__('Hover ', 'image-hover-effects-ultimate'),
            ]
                ]
        );
        $this->start_controls_tab();
        $this->add_control(
                'oxi-image-flip-back-button-color', $this->style, [
            'label' => esc_html__('Color', 'image-hover-effects-ultimate'),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}}  .oxi-image-hover-button a.oxi-image-btn' => 'color: {{VALUE}};',
                '{{WRAPPER}}  .oxi-image-hover-button a.oxi-image-btn:hover' => 'color: {{VALUE}};',
            ],
            'description' => 'Color property is used to set the color of the Button.',
                ]
        );

        $this->add_group_control(
                'oxi-image-flip-back-button-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button  a.oxi-image-btn' => '',
                '{{WRAPPER}} .oxi-image-hover-button  a.oxi-image-btn:hover' => '',
            ],
            'description' => 'Text Shadow property adds shadow to Button.',
                ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab();
        $this->add_control(
                'oxi-image-flip-back-button-hover-color', $this->style, [
            'label' => esc_html__('Color', 'image-hover-effects-ultimate'),
            'type' => Controls::COLOR,
            'default' => '#ffffff',
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure .oxi-image-hover-button a.oxi-image-btn:hover' => 'color: {{VALUE}};',
            ],
            'description' => 'Color property is used to set the Hover color of the Button.',
                ]
        );

        $this->add_group_control(
                'oxi-image-flip-back-button-hover-tx-shadow', $this->style, [
            'type' => Controls::TEXTSHADOW,
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-figure .oxi-image-hover-button a.oxi-image-btn:hover' => '',
            ], 'description' => 'Text Shadow property adds shadow to Hover Button.',
                ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
                'oxi-image-flip-back-button-margin', $this->style, [
            'label' => esc_html__('Margin', 'image-hover-effects-ultimate'),
            'type' => Controls::DIMENSIONS,
            'default' => [
                'unit' => 'px',
                'size' => '',
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => .1,
                ],
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button a.oxi-image-btn' => 'margin:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ], 'description' => 'Generate space around a Button, Outside of Content.',
                ]
        );
        $this->add_control(
                'oxi-image-flip-back-button-animation', $this->style, [
            'label' => esc_html__('Animation', 'image-hover-effects-ultimate'),
            'type' => Controls::SELECT,
            'default' => 'solid',
            'options' => [
                '' => esc_html__('None', 'image-hover-effects-ultimate'),
                'iheu-fade-up' => esc_html__('Fade Up', 'image-hover-effects-ultimate'),
                'iheu-fade-down' => esc_html__('Fade Down', 'image-hover-effects-ultimate'),
                'iheu-fade-left' => esc_html__('Fade Left', 'image-hover-effects-ultimate'),
                'iheu-fade-right' => esc_html__('Fade Right', 'image-hover-effects-ultimate'),
                'iheu-fade-up-big' => esc_html__('Fade up Big', 'image-hover-effects-ultimate'),
                'iheu-fade-down-big' => esc_html__('Fade down Big', 'image-hover-effects-ultimate'),
                'iheu-fade-left-big' => esc_html__('Fade left Big', 'image-hover-effects-ultimate'),
                'iheu-fade-right-big' => esc_html__('Fade Right Big', 'image-hover-effects-ultimate'),
                'iheu-zoom-in' => esc_html__('Zoom In', 'image-hover-effects-ultimate'),
                'iheu-zoom-out' => esc_html__('Zoom Out', 'image-hover-effects-ultimate'),
                'iheu-flip-x' => esc_html__('Flip X', 'image-hover-effects-ultimate'),
                'iheu-flip-y' => esc_html__('Flip Y', 'image-hover-effects-ultimate'),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button' => '',
            ], 'description' => 'Allows you to animated Button while viewing.',
                ]
        );
        $this->add_control(
                'oxi-image-flip-back-button-animation-delay', $this->style, [
            'label' => esc_html__('Animation Delay', 'image-hover-effects-ultimate'),
            'type' => Controls::SELECT,
            'default' => '',
            'options' => [
                '' => esc_html__('None', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-xs' => esc_html__('Delay XS', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-sm' => esc_html__('Delay SM', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-md' => esc_html__('Delay MD', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-lg' => esc_html__('Delay LG', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-xl' => esc_html__('Delay XL', 'image-hover-effects-ultimate'),
                'oxi-image-hover-delay-xxl' => esc_html__('Delay XXL', 'image-hover-effects-ultimate'),
            ],
            'selector' => [
                '{{WRAPPER}} .oxi-image-hover-button' => '',
            ], 'description' => 'Allows you to animation delay at Button while viewing.',
                ]
        );

        $this->end_controls_section();
    }

    public function modal_form_data() {
        ?>
        <div class="modal-header">
            <h4 class="modal-title">Image Hover Form</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php
            $this->add_control(
                    'image_hover_front_heading', $this->style, [
                'label' => esc_html__('Front Title', 'image-hover-effects-ultimate'),
                'type' => Controls::TEXT,
                'default' => '',
                'placeholder' => 'Heading',
                'description' => 'Add Your Flipbox Front Title.'
                    ]
            );

            $this->add_control(
                    'image_hover_front_icon', $this->style, [
                'label' => esc_html__('Front Icon', 'image-hover-effects-ultimate'),
                'type' => Controls::ICON,
                'description' => 'Add Your Flipbox Front Icon.'
                    ]
            );

            $this->add_control(
                    'image_hover_back_description', $this->style, [
                'label' => esc_html__('Backend Description', 'image-hover-effects-ultimate'),
                'type' => Controls::TEXTAREA,
                'description' => 'Add Your Backend Description Unless make it blank.'
                    ]
            );

            $this->start_controls_tabs(
                    'image_hover-start-tabs', [
                'separator' => TRUE,
                'options' => [
                    'frontend' => esc_html__('Front Image', 'image-hover-effects-ultimate'),
                    'backend' => esc_html__('Backend Image', 'image-hover-effects-ultimate'),
                ]
                    ]
            );
            $this->start_controls_tab();

            $this->add_group_control(
                    'image_hover_front_image', $this->style, [
                'label' => esc_html__('Image', 'image-hover-effects-ultimate'),
                'type' => Controls::MEDIA,
                'description' => 'Add or Modify Your Front Image. Adjust Front background to get better design.'
                    ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab();
            $this->add_group_control(
                    'image_hover_back_image', $this->style, [
                'label' => esc_html__('Feature Image', 'image-hover-effects-ultimate'),
                'type' => Controls::MEDIA,
                'description' => 'Add or Modify Your Backend Image. Adjust Backend background to get better design.'
                    ]
            );
            $this->end_controls_tab();
            $this->end_controls_tabs();

            $this->add_group_control(
                    'image_hover_button_link', $this->style, [
                'label' => esc_html__('URL', 'image-hover-effects-ultimate'),
                'type' => Controls::URL,
                'separator' => TRUE,
                'default' => '',
                'placeholder' => 'https://www.yoururl.com',
                'description' => 'Add Your Desire Link or Url Unless make it blank'
                    ]
            );
            $this->add_control(
                    'image_hover_button_text', $this->style, [
                'label' => esc_html__('Button Text', 'image-hover-effects-ultimate'),
                'type' => Controls::TEXT,
                'default' => '',
                'description' => 'Customize your button text. Button will only view while Url given'
                    ]
            );
            ?>
        </div>
        <?php
    }

    /**
     * Template Parent Item Data Rearrange
     *
     * @since 2.0.0
     */
    public function Rearrange() {
        return '<li class="list-group-item" id="{{id}}">{{image_hover_front_heading}}</li>';
    }

}
