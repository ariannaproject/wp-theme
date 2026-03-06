<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-2"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-4"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="home-header">
        <div class="title-container">
            <h1 class="arianna-logo text-primary">Arianna</h1>
        </div>

        <div class="subtitle-container">
            <p>
                Un sistema modulare basato su componenti stampabili in 3D.<br>
                Una nuova soluzione per sperimentare sistemi automatizzati con l'utilizzo di PLC
            </p>
        </div>

        <div class="scrolldown-container">
            <div class="scrolldown-line"></div>
        </div>

        <div class="font-credit text-xsmall">Outward by Raoul Audouin. Distributed by velvetyne.fr.</div>
    </div>

    <div class="features-carousel d-flex gap-4">
        <?php $i = 0; foreach(get_posts(['post_type' => 'project_feature', 'posts_per_page' => -1]) as $feature): $i++; ?>
            <div class="card bg-bg" style="width: 22rem;">
                <div class="card-img-container">
                    <?php if (has_post_thumbnail($feature->ID)): ?>
                        <img src="<?= get_the_post_thumbnail_url($feature->ID, 'full') ?>" alt="" class="bg-white card-img w-100 h-100">
                    <?php else: ?>
                        <div class="img-placeholder w-100 h-100">
                            <h1 class="arianna-logo text-white" style="font-size: 70px; margin: 0;">Arianna</h1>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= get_the_title($feature->ID); ?></h5>
                    <div class="card-text"><?= get_the_content(null, false, $feature->ID); ?></div>
                    <p class="card-text mt-auto mb-0" style="text-align: end;"><?= str_pad($i, 2, '0', STR_PAD_LEFT); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="home-description" class="home-description p-2" style="margin-top: 4rem;">
        <h1>Come funziona?</h1>
        <p>
            I <span class="text-primary">moduli meccanici</span> possono essere composti tra loro tramite un meccanismo a scorrimento che permette ad un perno di scivolare su una scanalatura a coda di rondine ricavata sui bordi di ciascun blocco.
        </p>
        <p>
            Delle <span class="text-primary">schede elettroniche</span> sono inserite all'interno di moduli dedicati. Queste permettono al pezzo di interfacciarsi con un ecosistema di <span class="text-primary">moduli</span> e <span class="text-primary">espansioni</span> basato su PLC.
        </p>
        <p>
            Per i motori, sensori o nastri sono stati creati moduli dedicati, che meglio si combinano con le componenti più usate nel mercato.
        </p>
        <p>
            L'intero sistema si basa su una <span class="text-primary">base ad incastro</span> che si combina con moduli appositi. Dentro la base è presente un sistema elettronico che rende effettiva la connessione al PLC.
        </p>
    </div>

    <div class="model-container" id="model-container"></div>
</div>

<?php get_footer(); ?>