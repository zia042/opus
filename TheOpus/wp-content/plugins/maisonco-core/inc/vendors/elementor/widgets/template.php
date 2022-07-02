<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

/**
 * Class OSF_Elementor_Template
 */
class OSF_Elementor_Template extends Elementor\Widget_Base{

    public function get_name() {
        return 'opal-template';
    }

    public function get_title() {
        return __('Opal Template', 'maisonco-core');
    }

    public function get_icon() {
        return 'eicon-document-file';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_template',
            [
                'label' => __( 'Opal Template', 'maisonco-core' ),
            ]
        );

        $templates = Elementor\Plugin::instance()->templates_manager->get_source( 'local' )->get_items();

        if ( empty( $templates ) ) {

            $this->add_control(
                'no_templates',
                [
                    'label' => false,
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<div id="elementor-widget-template-empty-templates">
				<div class="elementor-widget-template-empty-templates-icon"><i class="eicon-nerd"></i></div>
				<div class="elementor-widget-template-empty-templates-title">' . __( 'You Haven’t Saved Templates Yet.', 'maisonco-core' ) . '</div>
				<div class="elementor-widget-template-empty-templates-footer">' . __( 'Want to learn more about Elementor library?', 'maisonco-core' ) . ' <a class="elementor-widget-template-empty-templates-footer-url" href="https://go.elementor.com/docs-library/" target="_blank">' . __( 'Click Here', 'maisonco-core' ) . '</a>
				</div>
				</div>',
                ]
            );

            return;
        }

        $options = [
            '0' => '— ' . __( 'Select', 'maisonco-core' ) . ' —',
        ];

        $types = [];

        foreach ( $templates as $template ) {
            $options[ $template['template_id'] ] = $template['title'] . ' (' . $template['type'] . ')';
            $types[ $template['template_id'] ] = $template['type'];
        }

        $this->add_control(
            'template_id',
            [
                'label' => __( 'Choose Template', 'maisonco-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $options,
                'types' => $types,
                'label_block'  => 'true',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $template_id = $this->get_settings( 'template_id' );
        ?>
        <div class="elementor-template">
            <?php
            $template_id = apply_filters( 'wpml_object_id', $template_id, 'elementor_library' );
            echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $template_id );
            ?>
        </div>
        <?php
    }
}
$widgets_manager->register(new OSF_Elementor_Template());