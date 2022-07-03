<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
/**
 * Elementor accordion widget.
 *
 * Elementor widget that displays a collapsible display of content in an
 * accordion style, showing only one item at a time.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Accordion extends Widget_Accordion {

    /**
     * Get widget name.
     *
     * Retrieve accordion widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'accordion';
    }

    /**
     * Get widget title.
     *
     * Retrieve accordion widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Opal Accordion', 'maisonco-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve accordion widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-accordion';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'accordion', 'tabs', 'toggle' ];
    }

    /**
     * Register accordion widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __( 'Accordion', 'maisonco-core' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => __( 'Title & Content', 'maisonco-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Accordion Title', 'maisonco-core' ),
                'dynamic' => [
                    'active' => true,
                ],
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label' => __( 'Content', 'maisonco-core' ),
                'type' => Controls_Manager::WYSIWYG,
                'default' => __( 'Accordion Content', 'maisonco-core' ),
                'show_label' => false,
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label' => __( 'Accordion Items', 'maisonco-core' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => __( 'Accordion #1', 'maisonco-core' ),
                        'tab_content' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'maisonco-core' ),
                    ],
                    [
                        'tab_title' => __( 'Accordion #2', 'maisonco-core' ),
                        'tab_content' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'maisonco-core' ),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'maisonco-core' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'maisonco-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-plus',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icon_active',
            [
                'label' => __( 'Active Icon', 'maisonco-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-minus',
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_html_tag',
            [
                'label' => __( 'Title HTML Tag', 'maisonco-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'div',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Accordion', 'maisonco-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_accordion_item',
            [
                'label'     => __( 'Background Color', 'maisonco-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-accordion-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_accordion_item',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-accordion .elementor-accordion-item',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_title',
            [
                'label' => __( 'Title', 'maisonco-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-title',

            ]
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __( 'Normal', 'maisonco-core' ),
            ]
        );

        $this->add_control(
            'title_background',
            [
                'label' => __( 'Background', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __( 'Active', 'maisonco-core' ),
            ]
        );

        $this->add_control(
            'title_background_active',
            [
                'label' => __( 'Active Background', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'title_color_active',
            [
                'label' => __( 'Active Color', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'maisonco-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_icon',
            [
                'label' => __( 'Icon', 'maisonco-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon .fa:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_active_color',
            [
                'label' => __( 'Active Color', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon .fa:before' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __( 'Size', 'maisonco-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => __( 'Spacing', 'maisonco-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-accordion-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_toggle_style_content',
            [
                'label' => __( 'Content', 'maisonco-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => __( 'Color', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_background_color',
            [
                'label' => __( 'Background', 'maisonco-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-accordion .elementor-tab-content',

            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_accordion_content',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-accordion .elementor-tab-content',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __( 'Padding', 'maisonco-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-accordion .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render accordion widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $id_int = substr( $this->get_id_int(), 0, 3 );
        ?>
        <div class="elementor-accordion" role="tablist">
        <?php
        foreach ( $settings['tabs'] as $index => $item ) :
            $tab_count = $index + 1;

            $tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

            $tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

            $this->add_render_attribute( $tab_title_setting_key, [
                'id' => 'elementor-tab-title-' . $id_int . $tab_count,
                'class' => [ 'elementor-tab-title' ],
                'tabindex' => $id_int . $tab_count,
                'data-tab' => $tab_count,
                'role' => 'tab',
                'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
            ] );

            $this->add_render_attribute( $tab_content_setting_key, [
                'id' => 'elementor-tab-content-' . $id_int . $tab_count,
                'class' => [ 'elementor-tab-content', 'elementor-clearfix' ],
                'data-tab' => $tab_count,
                'role' => 'tabpanel',
                'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
            ] );

            $this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
            ?>
            <div class="elementor-accordion-item">
            <<?php echo $settings['title_html_tag']; ?> <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
            <?php if ( $settings['icon'] ) : ?>
            <span class="elementor-accordion-icon" aria-hidden="true">
							<i class="elementor-accordion-icon-closed <?php echo esc_attr( $settings['icon'] ); ?>"></i>
							<i class="elementor-accordion-icon-opened <?php echo esc_attr( $settings['icon_active'] ); ?>"></i>
						</span>
        <?php endif; ?>
            <?php echo $item['tab_title']; ?>
            </<?php echo $settings['title_html_tag']; ?>>
            <div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>><?php echo $this->parse_text_editor( $item['tab_content'] ); ?></div>
            </div>
        <?php endforeach; ?>
        </div>
        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Accordion());
