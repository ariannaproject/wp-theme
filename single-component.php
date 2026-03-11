<?php

$files = get_post_meta(get_the_ID(), '_attachments', true) ?: [];

$size = 0;
$downloads = 0;
foreach($files as $file) {
    $downloads += isset($file['count']) ? intval($file['count']) : 0;
    $size += filesize(get_attached_file($file['file_id']));
}

?>

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
                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>" alt="<?php the_title(); ?>">
            <?php else : ?>
                <div class="img-placeholder w-100">
                    <h1 class="arianna-logo text-white" style="font-size: 70px; margin: 0;">Arianna</h1>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="item-header-text">

            <div class="d-flex justify-content-between" style="align-items: start;">
                <h1><?php the_title(); ?></h1>
                <span class="badge badge-primary"><?= get_the_terms(get_the_ID(), 'component_category')[0]->name ?? '' ?></span>
            </div>

            <div class="d-flex">
                <div class="badge">
                    Versione v<?= get_post_meta(get_the_ID(), '_component_version', true); ?>
                </div>
            </div>

            <div class="mt-4 stats">
                <div>
                    <span class="stats-desc">Downloads</span>
                    <span class="stats-number"><?= $downloads ?></span>
                </div>
                <div>
                    <span class="stats-desc">Dimensione</span>
                    <span class="stats-number"><?= size_format($size) ?></span>
                </div>
                <div>
                    <span class="stats-desc">Commenti</span>
                    <span class="stats-number"><?= get_comments_number() ?></span>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2" style="flex-wrap: wrap;">
                <a class="btn btn-primary" href="#tabs" onclick="switchTab('files')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"></path>
                    </svg>
                    Scarica allegati
                </a>
                <button class="btn btn-secondary-outline" onclick="share()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    Condividi
                </button>
            </div>

        </div>
    </div>

    <a id="tabs"></a>
    <div class="tab-container mt-4">

        <div class="tab-buttons">
            <button class="tab-button active" onclick="switchTab('documentation')">Documentazione</button>
            <?php if(count($files) > 0) : ?>
            <button class="tab-button" onclick="switchTab('files')">File</button>
            <?php endif; ?>
            <?php if(count(arianna_kit_components_get_kits(get_the_ID())) > 0) : ?>
            <button class="tab-button" onclick="switchTab('kits')">Kit</button>
            <?php endif; ?>
            <?php if(comments_open()) : ?>
            <button class="tab-button" onclick="switchTab('comments')">Commenti</button>
            <?php endif; ?>
        </div>

        <div id="tab-documentation" class="tab-content active">
            <div class="wp-content">
                <?php the_content(); ?>
            </div>
        </div>

        <div id="tab-files" class="tab-content">
            <div>
                <h5>File Disponibili</h5>
                <p>Scarica i file necessari per la stampa 3D e l'assemblaggio. Tutti i file sono forniti in formati standard per la massima compatibilità.</p>
            </div>
            
            <div class="card-grid">
                <?php
                    foreach ($files as $file) :
                        $attachment_url = wp_get_attachment_url($file['file_id']);
                        $file_name = basename($attachment_url);
                        $file_size = size_format(filesize(get_attached_file($file['file_id'])));
                ?>
                <div class="card bg-secondary">
                    <div class="card-body">
                        <h6 class="card-title"><?= $file['desc'] ?></h6>
                        <div class="card-text text-small"><?= $file['count'] ?> downloads</div>
                        <div class="card-text text-small"><?= $file_size ?></div>
                        <div>
                            <a class="btn btn-primary" href="<?= home_url() ?>/?component_id=<?= get_the_ID() ?>&file_id=<?= $file['file_id'] ?>">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"></path>
                                </svg>
                                Scarica
                            </a>
                        </div>
                    </div>                                
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="tab-kits" class="tab-content">
            <div>
                <h5>Kit che includono questo componente</h5>
                <p>Scopri i kit composti da questo componente e i relativi dettagli.</p>
            </div>

            <?php
                $related_kits = arianna_kit_components_get_kits(get_the_ID());
            ?>

            <div class="card-grid mt-5" id="components-grid">

                <?php foreach ($related_kits as $kit) : ?>
                <div class="card cliccable-card col" onclick="window.location.href='<?= get_post_permalink($kit->ID) ?>'">
                    <div class="card-body">
                        <div class="card-header">
                            <h5 class="card-title"><?= get_the_title($kit->ID) ?></h5>
                            <span class="badge badge-primary">Base</span>
                        </div>
                        <p class="card-text">
                            <?= get_the_excerpt($kit->ID) ?>
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
                        <a class="btn btn-primary-outline" href="<?= get_post_permalink($kit->ID) ?>">
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
        <div id="tab-comments" class="tab-content">
            <div>
                <h5>Commenti degli Utenti</h5>
                <p>Leggi cosa dicono gli altri utenti sulla base modulare e lascia il tuo feedback!</p>
            </div>
            <div class="commentsSection">
                <?php
                    $comments = get_comments(array('post_id' => get_the_ID()));
                    foreach ($comments as $comment) :
                ?>
                <div class="bordered bg-bg w-100">
                    <div class="p-3 d-flex">
                        <span style="font-weight: bold;"><?php echo $comment->comment_author; ?></span>
                        <span class="ms-auto"><?php echo get_comment_date('d M Y', $comment); ?></span>
                    </div>
                    <div class="p-3">
                        <p><?php echo $comment->comment_content; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="wp-content mt-4">
                <?php
                    comment_form(array(
                        'title_reply' => 'Lascia un Commento',
                        'label_submit' => 'Invia Commento',
                        'comment_field' => '<textarea class="form-control w-100" placeholder="Scrivi il tuo commento qui..." name="comment" id="comment" rows="4"></textarea>',
                        'class_submit' => 'btn btn-primary mt-2',
                    ));
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabId) {
        const tabs = document.querySelectorAll('.tab-content');
        const buttons = document.querySelectorAll('.tab-button');

        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.id === "tab-" + tabId) {
                tab.classList.add('active');
            }
        });

        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('onclick').includes(tabId)) {
                btn.classList.add('active');
            }
        });
    }

    function share() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link copiato negli appunti!');
        }).catch(err => {
            alert('Errore nel copiare il link: ' + err);
        });
    }
</script>

<?php get_footer(); ?>