<?php get_header(); ?>
<main class="content">
    <?php while (have_posts()) : the_post(); ?>
        <article>
            <div class="eyebrow">Portfolio</div>
            <h1><?php the_title(); ?></h1>
            <?php if (has_post_thumbnail()) : the_post_thumbnail('large', ['loading' => 'lazy']); endif; ?>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>

