<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="page-header">
        <h1>Aggiornamenti</h1>
        <p>
            Resta aggiornato sulle ultime novità del progetto Arianna. Nuove release, aggiornamenti software, eventi della community e molto altro.
        </p>
    </div>

    <div id="news-search-box" class="bg-white p-4 bordered">
        <div>
            <div class="d-flex justify-content-between gap-3 align-items-center" style="flex-wrap: wrap;">
                <div class="d-flex gap-3" style="flex-wrap: wrap;" id="news-filter-buttons">
                    <button class="btn btn-select active" data-category="all">Tutti</button>
                    <?php foreach(get_terms(['taxonomy' => 'category', 'hide_empty' => true]) as $term) : ?>
                    <button class="btn btn-select" data-category="<?= $term->slug ?>"><?= $term->name ?></button>
                    <?php endforeach; ?>
                </div>
                
                
                <div class="ms-auto text-small" style="flex-wrap: wrap;">
                    <p class="text-muted" style="margin-bottom: 0;">Mostrando <span id="filter-count"><?= count(get_posts(['post_type' => 'post'])) ?></span> news</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-grid mt-5" id="news-grid">
        <?php 
        foreach(get_posts(['post_type' => 'post']) as $post) : 
            $categories = get_the_category($post->ID);
            $category_slug = $categories[0]->slug ?? 'senza-categoria';
        ?>
            <div class="card cliccable-card" data-category="<?= $category_slug ?>" onclick="window.location.href='<?= get_permalink($post->ID) ?>'">
                <div class="card-img-container">
                <?php if(has_post_thumbnail($post->ID)) : ?>
                    <img src="<?= get_the_post_thumbnail_url($post->ID, 'medium_large') ?>" alt="<?= $post->post_title ?>" class="card-img">
                <?php else : ?>
                    <div class="img-placeholder">
                        <h1 class="arianna-logo text-white" style="font-size: 70px; margin: 0;">Arianna</h1>
                    </div>
                <?php endif; ?>
                    <div class="card-img-badge"><?= $categories[0]->name ?? 'Senza categoria' ?></div>
                </div>
                <div class="card-body">
                    <div class="text-muted text-small">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <?= get_the_date('j F Y', $post->ID) ?>
                    </div>
                    <h5 class="m-0"><?= $post->post_title ?></h5>
                    <p class="text-secondary" style="opacity: 0.8; font-size: 14px;"><?= wp_trim_words($post->post_content, 20) ?></p>
                </div>
                <div class="card-footer align-items-center">
                    <div>
                        <?php foreach(get_the_tags($post->ID) as $tag) : ?>
                        <span class="badge">#<?= $tag->name ?></span>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= get_permalink($post->ID) ?>" class="text-small" style="text-decoration: none;">
                        Leggi
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>