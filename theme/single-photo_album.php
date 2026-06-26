<?php get_header(); ?>
<main class="content album-content">
  <?php while (have_posts()) : the_post(); ?>
    <p class="eyebrow"><?php echo esc_html(site_t('Fotoalbum', 'Photo album')); ?></p>
    <h1><?php the_title(); ?></h1>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="pf-album-hero"><?php the_post_thumbnail('large'); ?></figure>
    <?php endif; ?>
    <?php the_content(); ?>
    <?php echo site_album_gallery(get_the_ID()); ?>
  <?php endwhile; ?>
</main>
<?php get_footer(); ?>
