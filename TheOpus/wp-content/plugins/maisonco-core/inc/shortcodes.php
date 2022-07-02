<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

function property_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 12,
        'gutter'         => '',
        'columns'        => 3
    ), $atts);
    $atts['posts_per_page'] = intval($atts['posts_per_page']);
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query_args = [
        'post_type'           => 'osf_property',
        'ignore_sticky_posts' => 1,
        'post_status'         => 'publish',
        'posts_per_page'      => $atts['posts_per_page'],
        'paged'               => $paged
    ];
    $wrap_class = 'row';
    if ($atts['gutter'] == 'no') {
        $wrap_class .= ' no-gutter';
    }

    $query = new WP_Query($query_args);
    echo '<div class="' . esc_attr($wrap_class) . '" data-elementor-columns="' . esc_attr($atts['columns']) . '">';
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template-parts/property/content', 'property');
    }
    wp_reset_postdata();
    echo '</div>';
    $paginate_args = array(
        'current'   => max(1, get_query_var('paged')),
        'total'     => $query->max_num_pages,
        'show_all'  => false,
        'end_size'  => 1,
        'mid_size'  => 2,
        'prev_next' => true,
        'type'      => 'plain',
        'add_args'  => false,
        'prev_text'          => '<span class="arrow">&larr;</span><span class="screen-reader-text">' . esc_html__( 'Previous', 'maisonco-core' ) . '</span>',
        'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next', 'maisonco-core' ) . '</span><span class="arrow">&rarr;</span>',
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'maisonco-core' ) . ' </span>',
    );

    printf('<nav class="navigation pagination" role="navigation"><div class="nav-links">%s</div></nav>',
        paginate_links($paginate_args)
    );
}

add_shortcode('opal_property', 'property_shortcode');