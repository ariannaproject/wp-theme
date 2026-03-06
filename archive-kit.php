<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="page-header">
        <h1>Kit Disponibili</h1>
        <p>
                Scegli il kit che meglio si adatta alle tue esigenze. Ogni kit include tutti i componenti necessari per costruire una specifica linea di montaggio automatizzata. 
        </p>
        <p>
            Puoi anche consultare la <a href="<?= get_post_type_archive_link('component') ?>">libreria componenti</a> per creare configurazioni personalizzate.
        </p>
    </div>

    <div id="kits-stats" class="stats text-center">
        <div>
            <span class="stats-number"><?= wp_count_posts('kit')->publish ?></span>
            <span class="stats-desc">Kit disponibili</span>
        </div>
        <div>
            <span class="stats-number"><?= wp_count_posts('component')->publish ?></span>
            <span class="stats-desc">Componenti totali</span>
            
        </div>
        <div>
            <span class="stats-number">0</span>
            <span class="stats-desc">Downloads</span>
        </div>
    </div>

    <div class="card-grid mt-5" id="kits-grid">
        <?php foreach(get_posts(['post_type' => 'kit', 'posts_per_page' => -1]) as $kit) : ?>
        <div class="card cliccable-card col" onclick="window.location.href='<?= get_permalink($kit) ?>'">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title"><?= the_title(); ?></h5>
                    <span class="badge badge-primary">Base</span>
                </div>
                <?php if (has_post_thumbnail($kit->ID)) : ?>
                    <div class="card-img-container">
                        <img src="<?= get_the_post_thumbnail_url($kit->ID, 'full'); ?>" alt="<?php the_title(); ?>" class="card-img">
                    </div>
                <?php else : ?>
                    <div class="img-placeholder">
                        <h1 class="arianna-logo text-white" style="font-size: 70px; margin: 0;">Arianna</h1>
                    </div>
                <?php endif; ?>
                <p class="card-text">
                    <?= wp_trim_words(get_the_content(), 20, '...') ?>
                </p>
                <hr>
                <div class="spec-table">
                    <div class="spec-row">
                        <span>Componenti:</span>
                        <span><?= count(arianna_kit_components_get($kit->ID)) ?></span>
                    </div>
                    <!--
                    <div class="spec-row">
                        <span>Download:</span>
                        <span>245</span>
                    </div>
                    -->
                </div>
                <a class="btn btn-primary-outline" href="<?= get_permalink($kit) ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    Visualizza
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

</div>

<?php get_footer(); ?>