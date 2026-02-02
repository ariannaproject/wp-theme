<?php
    get_header();
?>

<div class="content">
    <header>
        <div class="subtitleContainer">
            <h2>Scarica il progetto</h2>
            <p>Un tutorial passo-passo su come cominciare a creare progetti con Arianna.<br>
                <br>
                Per una panoramica più approfondita sul progetto trovi una relazione dettagliata qui.
            </p>
        </div>
    </header>

    <!-- Nuova sezione per accesso rapido -->
    <div class="quickLinks">
        <div class="quickLinkCard" onclick="window.location.href='<?= get_post_type_archive_link('kits') ?>'">
            <div class="quickLinkHeader">
                <div class="quickLinkIcon">📦</div>
                <div>
                    <h3>Kit Preconfigurati</h3>
                    <small><?= wp_count_posts('kits')->publish; ?> kit completi disponibili</small>
                </div>
            </div>
            <div class="quickLinkContent">
                <p>Scarica un kit completo con tutti i componenti necessari per costruire una specifica linea di montaggio. Ideale per iniziare velocemente.</p>
                <div class="quickLinkActions">
                    <button class="primaryBtn" onclick="event.stopPropagation(); window.location.href='<?= get_post_type_archive_link('kits') ?>'">
                        Esplora i Kit
                    </button>
                </div>
            </div>
        </div>

        <div class="quickLinkCard" onclick="window.location.href='<?= get_post_type_archive_link('components') ?>'">
            <div class="quickLinkHeader">
                <div class="quickLinkIcon">🔧</div>
                <div>
                    <h3>Libreria Componenti</h3>
                    <small><?= wp_count_posts('components')->publish; ?> componenti singoli</small>
                </div>
            </div>
            <div class="quickLinkContent">
                <p>Scegli i componenti individuali per creare la tua configurazione personalizzata. Perfetto per progetti specifici e personalizzazioni avanzate.</p>
                <div class="quickLinkActions">
                    <button class="primaryBtn" onclick="event.stopPropagation(); window.location.href='<?= get_post_type_archive_link('components') ?>'">
                        Sfoglia Componenti
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="righette">
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
</div>

<?php
    get_footer();
?>