<?php
declare(strict_types=1);
add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag'); add_theme_support('post-thumbnails'); add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption','style','script']); add_theme_support('responsive-embeds'); register_nav_menus(['primary' => __('Primary menu', 'site')]);
});
add_action('wp_enqueue_scripts', static function (): void { wp_enqueue_style('site-style', get_stylesheet_uri(), [], '1.0.0'); });
add_filter('excerpt_length', static fn (): int => 24);
function site_menu(): void { if (has_nav_menu('primary')) { wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'menu','fallback_cb'=>false,'depth'=>1]); return; } echo '<ul class="menu"><li><a href="'.esc_url(home_url('/')).'">Home</a></li><li><a href="'.esc_url(home_url('/blog/')).'">Blog</a></li><li><a href="'.esc_url(home_url('/contact/')).'">Contact</a></li></ul>'; }

add_action('wp_enqueue_scripts', static function (): void { wp_enqueue_script('site-accessibility', get_template_directory_uri() . '/assets/js/accessibility.js', [], '1.0.0', true); });

function site_current_lang(): string { return function_exists('pll_current_language') ? (pll_current_language('slug') ?: 'nl') : 'nl'; }
function site_t(string $nl, string $en): string { return site_current_lang() === 'en' ? $en : $nl; }
function site_url_i18n(string $nl, string $en): string { return home_url(site_current_lang() === 'en' ? $en : $nl); }
function site_language_switcher(): void {
    if (function_exists('pll_the_languages')) {
        pll_the_languages(['show_flags' => 1, 'show_names' => 1, 'hide_if_empty' => 0]);
        return;
    }
    echo '<a href="' . esc_url(home_url('/')) . '">NL</a><a href="' . esc_url(home_url('/en/')) . '">EN</a>';
}
