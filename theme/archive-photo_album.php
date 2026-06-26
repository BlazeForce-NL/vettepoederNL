<?php get_header(); ?>
<main class="content archive-content">
  <p class="eyebrow"><?php echo esc_html(site_t('Fotoalbums', 'Photo albums')); ?></p>
  <h1><?php echo esc_html(site_t('Herinneringen in beeld.', 'Memories in pictures.')); ?></h1>
  <p class="lead"><?php echo esc_html(site_t('Een overzicht van albums met foto’s, verhalen en momenten die bewaard mogen blijven.', 'A collection of albums with photos, stories and moments worth keeping.')); ?></p>
  <?php if (have_posts()) : ?>
    <div class="pf-album-grid">
      <?php while (have_posts()) : the_post(); ?>
        <a class="pf-album-card" href="<?php the_permalink(); ?>">
          <?php if (has_post_thumbnail()) : the_post_thumbnail('large', ['loading' => 'lazy']); endif; ?>
          <span><?php echo esc_html(site_t('Fotoalbum', 'Photo album')); ?></span>
          <h3><?php the_title(); ?></h3>
          <?php the_excerpt(); ?>
        </a>
      <?php endwhile; ?>
    </div>
  <?php else : ?>
    <p><?php echo esc_html(site_t('Nog geen fotoalbums gevonden.', 'No photo albums yet.')); ?></p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
