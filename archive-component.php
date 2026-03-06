<?php
$components = get_posts([
    'post_type' => 'component',
    'posts_per_page' => -1,
]);
?>

<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="page-header">
        <h1>Libreria Componenti</h1>
        <p>
            Tutti i componenti disponibili per costruire la tua linea di montaggio personalizzata. Puoi cercare, filtrare e scaricare singolarmente ogni elemento. 
        </p>
        <p>
            Preferisci una soluzione pronta? Scopri i nostri <a href="<?= get_post_type_archive_link('kit') ?>">kit preconfigurati</a>.
        </p>
    </div>

    <div id="components-search-box" class="bg-white p-4 bordered">
        <div class="d-flex gap-3">
            <input type="text" class="form-control" id="components-search-text" placeholder="Cerca componenti per nome o descrizione...">
        </div>
        

        <div style="margin-top: 20px;">
            <div class="d-flex justify-content-between gap-3" style="flex-wrap: wrap;">
                <div class="d-flex gap-3" style="flex-wrap: wrap;" id="components-filter-buttons">
                    <button class="btn btn-select active" data-category="all">Tutti (<span id="countAll"><?= count(get_posts(['post_type' => 'component'])) ?></span>)</button>
                    <?php foreach (get_terms('component_category') as $term) : ?>
                        <button class="btn btn-select" data-category="<?= $term->slug ?>"><?= $term->name ?> (<span><?= count(get_posts(['post_type' => 'component', 'tax_query' => ['taxonomy' => 'component_category', 'field' => 'slug', 'terms' => $term->slug]])) ?></span>)</button>
                    <?php endforeach; ?>
                </div>
                
                <!--
                <select class="form-select" id="sortSelect">
                    <option value="name">Ordina per Nome</option>
                    <option value="type">Ordina per Tipologia</option>
                    <option value="recent">Più Recenti</option>
                </select>
                -->
            </div>
        </div>
    </div>

    <div class="card-grid mt-5" id="components-grid">
        <?php foreach ($components as $component) : 
            $version = get_post_meta($component->ID, '_component_version', true) ?? '1.0';
            $category = get_the_terms($component->ID, 'component_category')[0]->slug ?? 'hardware';
        ?>
        <div class="card cliccable-card col" data-category="<?= $category ?>" onclick="window.location.href='<?= get_permalink($component->ID) ?>'">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title"><?= $component->post_title ?></h5>
                    <span class="badge badge-primary"><?= ucfirst($category) ?></span>
                </div>
                <?php if (has_post_thumbnail($component->ID)) : ?>
                    <div class="card-img-container">
                        <img src="<?= get_the_post_thumbnail_url($component->ID, 'full'); ?>" alt="<?php the_title(); ?>" class="card-img">
                    </div>
                <?php else : ?>
                    <div class="img-placeholder">
                        <h1 class="arianna-logo text-white" style="font-size: 70px; margin: 0;">Arianna</h1>
                    </div>
                <?php endif; ?>
                <p class="card-text">
                    <?= get_the_excerpt($component->ID) ?>
                </p>
                <hr>
                <div class="spec-table">
                    <div class="spec-row">
                        <span>Versione:</span>
                        <span>v<?= $version ?></span>
                    </div>
                    <div class="spec-row">
                        <span>Download:</span>
                        <span>245</span>
                    </div>
                </div>
                <a class="btn btn-primary-outline" href="<?= get_permalink($component->ID) ?>">
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