<?php
    get_header();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scarica il progetto</title>
    <style>
        
    </style>

<div class="content">
    <header>
        <div class="subtitleContainer">
            <h2>Scarica il progetto</h2>
            <p>Un tutorial passo-passo su come cominciare a creare progetti con Arianna.<br>
                <br>
                Per una panoramica più approfondita sul progetto trovi una relazione dettagliata qui.
            </p>
        </div>
        <span></span>
        <div class="player">
            <iframe src="https://www.youtube.com/embed/2sl1Co7-1aU?autoplay=1&mute=1" frameborder="0" allowfullscreen></iframe>
        </div>
    </header>

    <!-- Nuova sezione per accesso rapido -->
    <div class="quickLinks">
        <div class="quickLinkCard" onclick="window.location.href='<?= get_post_type_archive_link('kit') ?>'">
            <div class="quickLinkHeader">
                <div class="quickLinkIcon">📦</div>
                <div>
                    <h3>Kit Preconfigurati</h3>
                    <small>6 kit completi disponibili</small>
                </div>
            </div>
            <div class="quickLinkContent">
                <p>Scarica un kit completo con tutti i componenti necessari per costruire una specifica linea di montaggio. Ideale per iniziare velocemente.</p>
                <div class="quickLinkActions">
                    <button class="primaryBtn" onclick="event.stopPropagation(); window.location.href='<?= get_post_type_archive_link('kit') ?>'">
                        Esplora i Kit
                    </button>
                </div>
            </div>
        </div>

        <div class="quickLinkCard" onclick="window.location.href='<?= get_post_type_archive_link('component') ?>'">
            <div class="quickLinkHeader">
                <div class="quickLinkIcon">🔧</div>
                <div>
                    <h3>Libreria Componenti</h3>
                    <small>22+ componenti singoli</small>
                </div>
            </div>
            <div class="quickLinkContent">
                <p>Scegli i componenti individuali per creare la tua configurazione personalizzata. Perfetto per progetti specifici e personalizzazioni avanzate.</p>
                <div class="quickLinkActions">
                    <button class="primaryBtn" onclick="event.stopPropagation(); window.location.href='<?= get_post_type_archive_link('component') ?>'">
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