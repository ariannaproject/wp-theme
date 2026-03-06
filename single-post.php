<?php get_header(); ?>
<div class="container">
    <div class="w-100 h-100 container-sm mx-auto">
        <div class="mt-5 mb-4 d-flex flex-column gap-3">
            <a href="<?= get_permalink(get_page_by_path('news')) ?>" style="text-decoration: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"></path>
                </svg>
                Torna agli aggiornamenti
            </a>
            <div class="mt-2 d-flex gap-5">
                <div class="badge badge-primary"><?= get_the_category($post->ID)[0]->name ?></div>
                <div class="text-secondary text-small d-flex align-items-center gap-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <?= get_the_date('j F Y') ?>
                </div>
            </div>
            <h1><?php the_title(); ?></h1>
        </div>

        <?php if (has_post_thumbnail()) : ?>
        <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="Post Image" class="post-image bordered">
        <?php else : ?>
        <div class="img-placeholder bordered">
            <h1 class="arianna-logo text-white" style="font-size: 100px; margin: 0;">Arianna</h1>
        </div>
        <?php endif; ?>

        <div class="mt-5 mb-5 bg-white bordered p-5 wp-content">
            <?= the_content(); ?>
        </div>

        <hr>

        <div class="mt-5 mb-5 d-flex align-items-center justify-content-between">
            <p class="text-muted text-small m-0">Condividi questo articolo:</p>
            <div class="d-flex gap-3">
                <a href="#twitter" class="btn btn-select btn-share">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                    </svg>
                </a>
                <a href="#facebook" class="btn btn-select btn-share">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                    </svg>
                </a>
                <a href="#linkedin" class="btn btn-select btn-share">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                        <rect x="2" y="9" width="4" height="12"></rect>
                        <circle cx="4" cy="4" r="2"></circle>
                    </svg>
                </a>
                <a href="#link" class="btn btn-select btn-share">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-share').forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const actions = ['X', 'Facebook', 'LinkedIn', 'Copia link'];
            
            switch(index) {
                case 0:
                    window.open(`https://x.com/intent/tweet?url=${encodeURIComponent(window.location.href)}`, '_blank');
                    break;
                case 1:
                    window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`, '_blank');
                    break;
                case 2:
                    window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(window.location.href)}`, '_blank');
                    break;
                case 3:
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        alert('Link copiato negli appunti!');
                    });
                    break;
            }
        });
    });
</script>
<?php get_footer(); ?>