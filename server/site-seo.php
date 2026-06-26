<?php
/**
 * Lightweight SEO, Open Graph and structured data for the site.
 */
declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

remove_action('wp_head', 'rel_canonical');

function site_seo_description(): string
{
    if (is_singular()) {
        $post = get_queried_object();
        if ($post instanceof WP_Post) {
            $text = has_excerpt($post) ? get_the_excerpt($post) : wp_strip_all_tags(strip_shortcodes($post->post_content));
            $text = preg_replace('/\s+/', ' ', trim((string) $text));
            if ($text !== '') {
                return wp_trim_words($text, 26, '…');
            }
        }
    }

    $description = get_bloginfo('description');
    return $description ?: get_bloginfo('name');
}

function site_seo_url(): string
{
    if (is_singular()) {
        return get_permalink();
    }
    if (is_home()) {
        $posts_page = (int) get_option('page_for_posts');
        return $posts_page ? get_permalink($posts_page) : home_url('/');
    }
    if (is_front_page()) {
        return home_url('/');
    }
    return home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));
}

function site_seo_image(): string
{
    if (is_singular() && has_post_thumbnail()) {
        $image = wp_get_attachment_image_url(get_post_thumbnail_id(), 'full');
        if ($image) {
            return $image;
        }
    }
    return get_site_icon_url(512) ?: '';
}

add_action('wp_head', static function (): void {
    if (is_admin() || is_feed() || is_robots()) {
        return;
    }

    $title = wp_get_document_title();
    $description = site_seo_description();
    $url = site_seo_url();
    $image = site_seo_image();
    $locale = str_replace('-', '_', get_bloginfo('language') ?: 'nl_NL');
    $type = is_singular('post') ? 'article' : 'website';

    echo "\n<!-- Site SEO metadata -->\n";
    printf("<meta name=\"description\" content=\"%s\">\n", esc_attr($description));
    printf("<link rel=\"canonical\" href=\"%s\">\n", esc_url($url));
    printf("<link rel=\"alternate\" hreflang=\"x-default\" href=\"%s\">\n", esc_url(home_url('/')));
    printf("<meta property=\"og:locale\" content=\"%s\">\n", esc_attr($locale));
    printf("<meta property=\"og:type\" content=\"%s\">\n", esc_attr($type));
    printf("<meta property=\"og:site_name\" content=\"%s\">\n", esc_attr(get_bloginfo('name')));
    printf("<meta property=\"og:title\" content=\"%s\">\n", esc_attr($title));
    printf("<meta property=\"og:description\" content=\"%s\">\n", esc_attr($description));
    printf("<meta property=\"og:url\" content=\"%s\">\n", esc_url($url));
    if ($image) {
        printf("<meta property=\"og:image\" content=\"%s\">\n", esc_url($image));
        printf("<meta name=\"twitter:image\" content=\"%s\">\n", esc_url($image));
    }
    printf("<meta name=\"twitter:card\" content=\"%s\">\n", $image ? 'summary_large_image' : 'summary');
    printf("<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr($title));
    printf("<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr($description));
    echo "<!-- /Site SEO metadata -->\n";
}, 2);

add_action('wp_head', static function (): void {
    if (is_admin() || is_feed() || is_404() || is_search()) {
        return;
    }

    $home = home_url('/');
    $url = site_seo_url();
    $graph = [
        [
            '@type' => 'WebSite',
            '@id' => $home . '#website',
            'url' => $home,
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'inLanguage' => get_bloginfo('language') ?: 'nl-NL',
        ],
        [
            '@type' => is_singular('post') ? 'BlogPosting' : 'WebPage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'name' => wp_get_document_title(),
            'description' => site_seo_description(),
            'isPartOf' => ['@id' => $home . '#website'],
            'inLanguage' => get_bloginfo('language') ?: 'nl-NL',
        ],
    ];

    if (is_singular('post')) {
        $graph[1]['datePublished'] = get_the_date(DATE_W3C);
        $graph[1]['dateModified'] = get_the_modified_date(DATE_W3C);
    }

    echo '<script type="application/ld+json">' . wp_json_encode([
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}, 5);

