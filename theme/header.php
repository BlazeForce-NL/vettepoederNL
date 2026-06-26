<!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><?php wp_head(); ?></head><body <?php body_class(); ?>><?php wp_body_open(); ?>
<div class="site-accessibility-bar" role="region" aria-label="<?php echo esc_attr(site_t('Weergave en voorlezen', 'Display and read aloud')); ?>">
  <div class="wrap site-accessibility-tools">
    <span class="site-accessibility-label"><?php echo esc_html(site_t('Weergave en voorlezen', 'Display and read aloud')); ?></span>
    <button type="button" class="site-accessibility-button" data-site-text-size aria-pressed="false"><span aria-hidden="true">A+</span><span><?php echo esc_html(site_t('Grotere tekst', 'Larger text')); ?></span></button>
    <button type="button" class="site-accessibility-button" data-site-contrast aria-pressed="false"><span aria-hidden="true">◐</span><span><?php echo esc_html(site_t('Hoog contrast', 'High contrast')); ?></span></button>
    <button type="button" class="site-accessibility-button" data-site-read aria-pressed="false"><span aria-hidden="true">▶</span><span data-site-read-label><?php echo esc_html(site_t('Lees pagina voor', 'Read page aloud')); ?></span></button>
    <button type="button" class="site-accessibility-button" data-site-stop hidden><?php echo esc_html(site_t('Stop', 'Stop')); ?></button>
    <span class="site-sr-status" data-site-a11y-status aria-live="polite"></span>
  </div>
</div><header class="site-header"><div class="wrap nav"><a class="brand" href="<?php echo esc_url(home_url('/')); ?>"><span class="brand-mark"><?php echo esc_html(substr(get_bloginfo('name'),0,2)); ?></span><span><?php bloginfo('name'); ?></span></a><nav aria-label="Hoofdnavigatie"><?php site_menu(); ?></nav><div class="site-language-switcher" aria-label="Taalkeuze"><?php site_language_switcher(); ?></div></div></header>