<?php get_header(); ?>
<main>
    <section class="content pf-archive-head">
        <div class="eyebrow">Portfolio</div>
        <h1>Projecten en werkvoorbeelden</h1>
        <p>Een overzicht van projecten, cases, reizen, hobby’s of andere items die een eigen plek verdienen.</p>
    </section>
    <section class="section">
        <div class="wrap post-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <a class="post-card" href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : the_post_thumbnail('large', ['loading' => 'lazy']); endif; ?>
                    <div class="post-meta">Portfolio</div>
                    <h2 style="font-size:1.55rem"><?php the_title(); ?></h2>
                    <?php the_excerpt(); ?>
                </a>
            <?php endwhile; else : ?>
                <article class="post-card"><h2>Nog geen portfolio-items</h2><p>Maak je eerste item aan via WordPress > Portfolio.</p></article>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php get_footer(); ?>

