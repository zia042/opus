<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class OSF_Elementor_Image_Layers_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'opal-images-layers';
    }

    public function get_title()
    {
        return 'Opal Image Layers';
    }

    public function get_categories()
    {
        return ['opal-addons'];
    }

    public function get_script_depends()
    {
        return [
            'parallaxmouse',
            'tweenmax',
            'tilt',
            'waypoints',
        ];
    }

    protected function register_controls()
    {

        $this->start_controls_section('img_layers_content',
            [
                'label' => esc_html__('Images', 'maisonco-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control('layers_select',
            [
                'label' => esc_html__('Select Content', 'maisonco-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'image' => esc_html__('Image Content', 'maisonco-core'),
                    'text' => esc_html__('Text Content', 'maisonco-core'),
                ],
                'default' => 'image'
            ]
        );

        $repeater->add_control('img_layers_image',
            [
                'label' => esc_html__('Upload Image', 'maisonco-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'layers_select' => 'image'
                ]
            ]
        );

        $repeater->add_control('img_layers_alt',
            [
                'label' => esc_html__('Alt', 'maisonco-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'placeholder' => 'Premium Image Layers',
                'label_block' => true,
                'condition' => [
                    'layers_select' => 'image'
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'full',
                'condition' => [
                    'layers_select' => 'image'
                ]
            ]
        );

        $repeater->add_control('text_layers',
            [
                'label' => esc_html__('Content', 'maisonco-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('Lorem ipsum dolor sit amet', 'maisonco-core'),
                'condition' => [
                    'layers_select' => 'text'
                ]
            ]
        );

        $repeater->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typo',

                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .opal-img-layers-text',
                'condition' => [
                    'layers_select' => 'text'
                ]

            ]

        );

        $repeater->add_control('text_color',
            [
                'label' => esc_html__('Color', 'maisonco-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#00000',
                'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .opal-img-layers-text' => 'color: {{VALUE}};'
                ],
                'separator' => 'after',
                'condition' => [
                    'layers_select' => 'text'
                ]
            ]

        );

        $repeater->add_control('img_layers_position',
            [
                'label' => esc_html__('Position', 'maisonco-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'relative' => esc_html__('Relative', 'maisonco-core'),
                    'absolute' => esc_html__('Absolute', 'maisonco-core'),
                ],
                'default' => 'relative'
            ]
        );

        $repeater->add_responsive_control('img_layers_hor_position',
            [
                'label' => esc_html__('Horizontal Offset', 'maisonco-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Mousemove Interactivity works only with pixels', 'maisonco-core'),
                'size_units' => ['px', "em", '%'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => -20,
                        'max' => 30,
                    ],
                    '%' => [
                        'min' => -50,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.position-absolute' => 'left: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'img_layers_position' => 'absolute'
                ]
            ]
        );

        $repeater->add_responsive_control('img_layers_ver_position',
            [
                'label' => esc_html__('Vertical Offset', 'maisonco-core'),
                'description' => esc_html__('Mousemove Interactivity works only with pixels', 'maisonco-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', "em", '%'],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 300,
                    ],
                    'em' => [
                        'min' => -20,
                        'max' => 30,
                    ],
                    '%' => [
                        'min' => -50,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 50,
                    'unit' => '%',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.position-absolute' => 'top: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
                    'img_layers_position' => 'absolute'
                ],
                'separator' => 'after',
            ]
        );

        $repeater->add_control('img_layers_link_switcher',
            [
                'label' => esc_html__('Link', 'maisonco-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layers_select' => 'image'
                ]
            ]
        );

        $repeater->add_control('img_layers_link_selection',
            [
                'label' => esc_html__('Link Type', 'maisonco-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'url' => esc_html__('URL', 'maisonco-core'),
                    'link' => esc_html__('Existing Page', 'maisonco-core'),
                ],
                'default' => 'url',
                'label_block' => true,
                'condition' => [
                    'img_layers_link_switcher' => 'yes'
                ]
            ]
        );

        $repeater->add_control('img_layers_link',
            [
                'label' => esc_html__('Link', 'maisonco-core'),
                'type' => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'placeholder' => 'https://wpopal.com/',
                'label_block' => true,
                'separator' => 'after',
                'condition' => [
                    'img_layers_link_switcher' => 'yes',
                    'img_layers_link_selection' => 'url'
                ]
            ]
        );

        $repeater->add_control('img_layers_rotate',
            [
                'label' => esc_html__('Rotate', 'maisonco-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control('img_layers_rotatex',
            [
                'label' => esc_html__('Degrees', 'maisonco-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set rotation value in degress', 'maisonco-core'),
                'min' => -180,
                'max' => 180,
                'condition' => [
                    'img_layers_rotate' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => '-webkit-transform: rotate({{VALUE}}deg); -moz-transform: rotate({{VALUE}}deg); -o-transform: rotate({{VALUE}}deg); transform: rotate({{VALUE}}deg);'
                ],
            ]
        );

        $repeater->add_control('img_layers_animation_switcher',
            [
                'label' => esc_html__('Animation', 'maisonco-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control('img_layers_animation',
            [
                'label' => esc_html__('Entrance Animation', 'maisonco-core'),
                'type' => Controls_Manager::ANIMATION,
                'default' => '',
                'label_block' => false,
                'frontend_available' => true,
                'condition' => [
                    'img_layers_animation_switcher' => 'yes'
                ],
            ]
        );

        $repeater->add_control('img_layers_animation_duration',
            [
                'label' => __('Animation Duration', 'maisonco-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    'slow' => __('Slow', 'maisonco-core'),
                    '' => __('Normal', 'maisonco-core'),
                    'fast' => __('Fast', 'maisonco-core'),
                ],
                'condition' => [
                    'img_layers_animation_switcher' => 'yes',
                    'img_layers_animation!' => '',
                ],
            ]
        );

        $repeater->add_control('img_layers_animation_delay',
            [
                'label' => esc_html__('Animation Delay', 'maisonco-core') . ' (s)',
                'type' => Controls_Manager::NUMBER,
                'default' => '',
                'min' => 0,
                'step' => 0.1,
                'condition' => [
                    'img_layers_animation_switcher' => 'yes',
                    'img_layers_animation!' => '',
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.animated' => '-webkit-animation-delay:{{VALUE}}s; -moz-animation-delay: {{VALUE}}s; -o-animation-delay: {{VALUE}}s; animation-delay: {{VALUE}}s;'
                ]
            ]
        );

        $repeater->add_control('img_layers_mouse',
            [
                'label' => esc_html__('Mousemove Interactivity', 'maisonco-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Enable or disable mousemove interaction', 'maisonco-core'),
            ]
        );

        $repeater->add_control('img_layers_mouse_type',
            [
                'label' => esc_html__('Interactivity Style', 'maisonco-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'parallax' => esc_html__('Mouse Parallax', 'maisonco-core'),
                    'tilt' => esc_html__('Tilt', 'maisonco-core'),
                ],
                'default' => 'parallax',
                'label_block' => true,
                'condition' => [
                    'img_layers_mouse' => 'yes'
                ]
            ]
        );

        $repeater->add_control('img_layers_rate',
            [
                'label' => esc_html__('Rate', 'maisonco-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => -10,
                'min' => -20,
                'max' => 20,
                'step' => 1,
                'description' => esc_html__('Choose the movement rate for the layer image, default: -10', 'maisonco-core'),
                'separator' => 'after',
                'label_block' => true,
                'condition' => [
                    'img_layers_mouse' => 'yes',
                    'img_layers_mouse_type' => 'parallax'
                ]
            ]
        );

        $repeater->add_responsive_control(
            'img_layers_align',
            [
                'label' => __('Alignment', 'maisonco-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'maisonco-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'maisonco-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'maisonco-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control('img_layers_zindex',
            [
                'label' => esc_html__('z-index', 'maisonco-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.opal-img-layers-list-item' => 'z-index: {{VALUE}};'
                ],
            ]
        );

        $repeater->add_control('img_layers_class',
            [
                'label' => esc_html__('CSS Classes', 'maisonco-core'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Separate class with spaces', 'maisonco-core'),
            ]
        );

        $this->add_control('img_layers_images_repeater',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ img_layers_alt }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('img_layers_images_style',
            [
                'label' => esc_html__('Image', 'maisonco-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('img_layers_images_background',
            [
                'label' => esc_html__('Background Color', 'maisonco-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'img_layers_images_border',
                'selector' => '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image'
            ]
        );

        $this->add_responsive_control('img_layers_images_border_radius',
            [
                'label' => esc_html__('Border Radius', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_layers_images_shadow',
                'selector' => '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image'
            ]
        );

        $this->add_responsive_control('img_layers_margin',
            [
                'label' => esc_html__('Margin', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('img_layers_padding',
            [
                'label' => esc_html__('Padding', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-list-item .opal-img-layers-image' => 'padding:  {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('img_layers_container_style',
            [
                'label' => esc_html__('Container', 'maisonco-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control('img_layers_height',
            [
                'label' => esc_html__('Height', 'maisonco-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', "em"],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 800,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 80,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-wrapper' => 'min-height: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control('img_layers_container_background',
            [
                'label' => esc_html__('Background Color', 'maisonco-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-wrapper' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'img_layers_container_border',
                'selector' => '{{WRAPPER}} .opal-img-layers-wrapper'
            ]
        );

        $this->add_responsive_control('img_layers_container_radius',
            [
                'label' => esc_html__('Border Radius', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-wrapper' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'img_layers_container_shadow',
                'selector' => '{{WRAPPER}} .opal-img-layers-wrapper'
            ]
        );

        $this->add_responsive_control('img_layers_container_margin',
            [
                'label' => esc_html__('Margin', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('img_layers_container_padding',
            [
                'label' => esc_html__('Padding', 'maisonco-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .opal-img-layers-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {

        $settings = $this->get_settings_for_display();

        ?>

        <div id="opal-img-layers-wrapper" class="opal-img-layers-wrapper">
            <ul class="opal-img-layers-list-wrapper list-unstyled">
                <?php $animation_arr = array();
                foreach ($settings['img_layers_images_repeater'] as $index => $image) :
                    array_push($animation_arr, $image['img_layers_animation_switcher']);
	                $animation_dur = '';
                    if ('yes' == $animation_arr[$index]) {

                        $animation_class = $image['img_layers_animation'];

                        if ('' != $image['img_layers_animation_duration']) {

                            $animation_dur = 'animated-' . $image['img_layers_animation_duration'];

                        }
                    } else {

                        $animation_class = '';

                        $animation_dur = '';

                    }

                    $list_item_key = 'img_layer_' . $index;

                    $this->add_render_attribute($list_item_key, 'class',
                        [
                            'opal-img-layers-list-item',
                            'position-' . $image['img_layers_position'],
                            esc_attr($image['img_layers_class']),
                            'elementor-repeater-item-' . $image['_id']
                        ]
                    );

                    $this->add_render_attribute($list_item_key, 'data-layer-animation',
                        [
                            $animation_class,
                            $animation_dur,
                        ]
                    );

                    if ('url' == $image['img_layers_link_selection']) {

                        $image_url = $image['img_layers_link']['url'];

                    } else {

                        $image_url = get_permalink($image['img_layers_existing_link']);

                    }
                    ?>

                    <li <?php echo $this->get_render_attribute_string($list_item_key); ?> <?php if ('yes' == $image['img_layers_mouse']) : echo 'data-' . $image['img_layers_mouse_type'] . '="true"'; ?> data-rate="<?php echo esc_attr(!empty($image['img_layers_rate']) ? $image['img_layers_rate'] : -10); ?>"<?php endif; ?>>
                        <?php
                        if ($image['layers_select'] === 'image') {
                            $image_src = $image['img_layers_image'];
                            $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'thumbnail', $image);
                            if (empty($image_src_size)) : $image_src_size = $image_src['url'];
                            else: $image_src_size = $image_src_size; endif;


                            if ('yes' == $image['img_layers_link_switcher']) : ?>

                                <a class="opal-img-layers-link"
                                <?php if (!empty($image_url)) : ?>href="<?php echo esc_url($image_url); ?>"<?php endif; ?><?php if (!empty($image['img_layers_link']['is_external'])) : ?> target="_blank" <?php endif; ?><?php if (!empty($image['img_layers_link']['nofollow'])) : ?> rel="nofollow"<?php endif; ?>>

                            <?php endif; ?>
                            <img src="<?php echo $image_src_size; ?>" class="opal-img-layers-image"
                                 alt="<?php echo esc_attr($image['img_layers_alt']); ?>">

                            <?php if ($image['img_layers_link_switcher'] == 'yes') : ?>

                                </a>

                            <?php endif;
                        }else {
                            echo '<div class="opal-img-layers-text">'. $image['text_layers'] . '</div>';
                        } ?>

                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    <?php }
}

$widgets_manager->register(new OSF_Elementor_Image_Layers_Widget());