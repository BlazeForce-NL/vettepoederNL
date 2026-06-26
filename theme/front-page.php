<?php get_header(); ?>

<main>
    <section class="vp-hero">
        <div class="vp-hero__visual" aria-hidden="true">
            <span class="vp-sun"></span>
            <span class="vp-mountain vp-mountain--back"></span>
            <span class="vp-mountain vp-mountain--front"></span>
            <span class="vp-track vp-track--one"></span>
            <span class="vp-track vp-track--two"></span>
        </div>
        <div class="wrap vp-hero__content">
            <div class="vp-kicker">Skiën · snowboarden · berglucht</div>
            <h1>Een ode aan wintersport.</h1>
            <p class="vp-lead">Vette Poeder is voor iedereen die begrijpt dat sneeuw meer is dan weer. Het is vroeg opstaan, koude lucht in je longen, eerste sporen trekken en later sterke verhalen aan een houten tafel.</p>
            <div class="actions">
                <a class="button" href="<?php echo esc_url(home_url('/blog/')); ?>">Duik de sneeuw in</a>
                <a class="button secondary" href="<?php echo esc_url(home_url('/over/')); ?>">Waarom Vette Poeder?</a>
            </div>
        </div>
    </section>

    <section class="vp-strip" aria-label="Wintersport thema's">
        <div class="wrap vp-strip__inner">
            <span>Verse poeder</span>
            <span>Boardgevoel</span>
            <span>Pisteverhalen</span>
            <span>Gear & voorbereiding</span>
            <span>Bergdorpen</span>
        </div>
    </section>

    <section class="section vp-categories">
        <div class="wrap">
            <div class="eyebrow">Wintersport leeft hier</div>
            <h2>Niet alleen de afdaling. Het hele gevoel.</h2>
            <div class="vp-category-grid">
                <a class="vp-category vp-category--ski" href="<?php echo esc_url(home_url('/blog/')); ?>">
                    <span class="vp-category__label">Skiën</span>
                    <h3>Carven, zweven en opnieuw naar boven.</h3>
                    <p>Van techniek op strak geprepareerde pistes tot dat ene stille bospaadje waar je nog dagen aan terugdenkt.</p>
                </a>
                <a class="vp-category vp-category--board" href="<?php echo esc_url(home_url('/blog/')); ?>">
                    <span class="vp-category__label">Snowboarden</span>
                    <h3>Ritme, randgevoel en vrijheid.</h3>
                    <p>Een ode aan bochten, poeder, park, slush en dat heerlijke moment waarop je board precies doet wat je voelt.</p>
                </a>
                <a class="vp-category vp-category--travel" href="<?php echo esc_url(home_url('/blog/')); ?>">
                    <span class="vp-category__label">Bergen</span>
                    <h3>Reizen naar winterland.</h3>
                    <p>Gebieden, routes, voorbereiding, familiesneeuw, hutten, warme sokken en alles wat een trip onvergetelijk maakt.</p>
                </a>
            </div>
        </div>
    </section>

    <section class="vp-manifest">
        <div class="wrap vp-manifest__grid">
            <div>
                <div class="eyebrow">Manifest</div>
                <h2>Voor wie het geluid van krakende sneeuw mist zodra de winter voorbij is.</h2>
            </div>
            <div class="vp-manifest__copy">
                <p>Wintersport is sport, natuur, vriendschap en een beetje gezonde gekte tegelijk. Het is wax op je handen, helm op je hoofd, mist op de top en zon in het dal. Het is vallen, lachen, doorgaan en ’s avonds plannen maken voor “nog één run” morgen.</p>
                <p>Vette Poeder wordt een plek voor verhalen, tips, gear, gebieden en herinneringen. Geen afstandelijk reisportaal, maar een liefdevolle verzamelplek voor de winter.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="wrap">
            <div class="eyebrow">Laatste sporen</div>
            <h2>Nieuwe verhalen</h2>
            <div class="post-grid">
                <?php
                $latest = new WP_Query(['posts_per_page' => 4, 'post_status' => 'publish']);
                if ($latest->have_posts()) :
                    while ($latest->have_posts()) : $latest->the_post(); ?>
                        <a class="post-card vp-post-card" href="<?php the_permalink(); ?>">
                            <div class="post-meta"><?php echo esc_html(get_the_date()); ?></div>
                            <h3><?php the_title(); ?></h3>
                            <?php the_excerpt(); ?>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata();
                else : ?>
                    <article class="post-card vp-post-card">
                        <h3>Binnenkort meer</h3>
                        <p>Hier verschijnen straks verhalen uit de sneeuw.</p>
                    </article>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
