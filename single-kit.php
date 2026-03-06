<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="item-header">
        <div class="item-header-image">
            <?php if (has_post_thumbnail()) : ?>
                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>" class="item-header-img">
            <?php else : ?>
                <div class="img-placeholder w-100">
                    <h1 class="arianna-logo text-white" style="font-size: 200px; margin: 0;">Arianna</h1>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="item-header-text">

            <div class="d-flex justify-content-between" style="align-items: start;">
                <h1><?= the_title(); ?></h1>
                <span class="badge badge-primary">Base</span>
            </div>

            <div class="mt-4 bg-white bordered p-4">
                <div class="wp-content"><?= the_content(); ?></div>
            </div>
            
            <!--
            <div class="mt-4 d-flex gap-3">
                <a class="btn btn-primary" href="#">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"></path>
                    </svg>
                    Scarica kit completo
                </a>
                <a href="#" class="btn btn-secondary-outline">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                    </svg>
                    Istruzioni di montaggio
                </a>
            </div>
            -->

        </div>
    </div>

    <div id="components-search-box" class="bg-white p-4 bordered">
        <div>
            <div class="d-flex align-items-center justify-content-between gap-3" style="flex-wrap: wrap;">
                <span>Componenti del Kit</span>
                <div class="d-flex gap-3 ms-auto" style="flex-wrap: wrap;" id="components-filter-buttons">
                    <button class="btn btn-select active" data-category="all">Tutti</button>
                    <button class="btn btn-select" data-category="meccanica">Meccanica</button>
                    <button class="btn btn-select" data-category="hardware">Hardware</button>
                    <button class="btn btn-select" data-category="software">Software</button>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 card-grid" id="components-grid">
        <?php foreach(arianna_kit_components_get(get_the_ID()) as $component) : ?>
        <div class="card cliccable-card col" data-category="<?= get_the_terms($component->ID, 'component_category')[0]->slug ?? 'hardware' ?>" onclick="window.location.href='<?= get_permalink($component->ID) ?>'">
            <div class="card-body">
                <div class="card-header">
                    <h5 class="card-title"><?= get_the_title($component->ID) ?></h5>
                    <span class="badge badge-primary"><?= get_the_terms($component->ID, 'component_category')[0]->name ?? '' ?></span>
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
                        <span>v<?= get_post_meta($component->ID, '_component_version', true) ?? '1.0' ?></span>
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