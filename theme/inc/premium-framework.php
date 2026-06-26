<?php
/** Premium lightweight framework shared by the personal sites. */
declare(strict_types=1);

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_script('site-framework', get_template_directory_uri() . '/assets/js/framework.js', [], '1.0.0', true);
});

add_action('after_setup_theme', static function (): void {
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
});

add_action('init', static function (): void {
    register_post_type('portfolio', [
        'labels' => [
            'name' => 'Portfolio',
            'singular_name' => 'Portfolio-item',
            'add_new_item' => 'Nieuw portfolio-item toevoegen',
            'edit_item' => 'Portfolio-item bewerken',
            'menu_name' => 'Portfolio',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'has_archive' => 'portfolio',
        'rewrite' => ['slug' => 'portfolio'],
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields'],
        'taxonomies' => ['category', 'post_tag'],
    ]);
});

function site_reading_time(?int $post_id = null): string {
    $post_id = $post_id ?: get_the_ID();
    $words = str_word_count(wp_strip_all_tags((string) get_post_field('post_content', $post_id)));
    $minutes = max(1, (int) ceil($words / 220));
    return $minutes . ' min leestijd';
}

add_shortcode('premium_gallery', static function (array $atts = []): string {
    $atts = shortcode_atts(['ids' => '', 'columns' => '3'], $atts, 'premium_gallery');
    $ids = array_filter(array_map('absint', explode(',', (string) $atts['ids'])));
    if (!$ids) {
        return '<p class="pf-muted">Voeg afbeeldingen toe met <code>[premium_gallery ids="1,2,3"]</code> of gebruik het native WordPress galerijblok.</p>';
    }
    $columns = max(2, min(4, absint($atts['columns'])));
    $html = '<div class="pf-gallery pf-gallery--cols-' . esc_attr((string) $columns) . '" data-pf-gallery>';
    foreach ($ids as $id) {
        $full = wp_get_attachment_image_url($id, 'full');
        if (!$full) { continue; }
        $caption = wp_get_attachment_caption($id) ?: get_post_meta($id, '_wp_attachment_image_alt', true);
        $html .= '<a href="' . esc_url($full) . '" class="pf-gallery__item" data-pf-lightbox>'; 
        $html .= wp_get_attachment_image($id, 'large', false, ['loading' => 'lazy']);
        if ($caption) { $html .= '<span>' . esc_html($caption) . '</span>'; }
        $html .= '</a>';
    }
    $html .= '</div>';
    return $html;
});

function site_related_posts(int $limit = 3): void {
    if (!is_singular('post')) { return; }
    $categories = wp_get_post_categories(get_the_ID());
    $query = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post__not_in' => [get_the_ID()],
        'category__in' => $categories,
        'ignore_sticky_posts' => true,
    ]);
    if (!$query->have_posts()) { return; }
    echo '<aside class="pf-related"><h2>Gerelateerde artikelen</h2><div class="post-grid">';
    while ($query->have_posts()) { $query->the_post();
        echo '<a class="post-card" href="' . esc_url(get_permalink()) . '"><div class="post-meta">' . esc_html(site_reading_time()) . '</div><h3>' . esc_html(get_the_title()) . '</h3><p>' . esc_html(wp_trim_words(get_the_excerpt(), 20)) . '</p></a>';
    }
    wp_reset_postdata();
    echo '</div></aside>';
}

