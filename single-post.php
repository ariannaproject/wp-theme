<?php
    get_header();

    $related_posts = get_posts(array(
        'category__in' => wp_get_post_categories(get_the_ID()),
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 3,
    ));
?>

<div class="content">
    <div class="articleHeader">
        <a href="<?php echo get_permalink(get_page_by_path('news')); ?>" class="backToNews">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Torna agli aggiornamenti
        </a>

        <div class="articleMeta">
            <?php
                foreach((get_the_category()) as $category) :
            ?>
            <span class="badge release"><?= $category->name ?></span>
            <?php
                endforeach;
            ?>
            <div class="dateInfo">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <?php echo get_the_date('d F Y'); ?>
            </div>
        </div>

        <h2><?php the_title(); ?></h2>
    </div>

    <?php
        if(has_post_thumbnail()) :
    ?>
    <div class="featuredImage" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(),'full'); ?>');">
    </div>
    <?php
        endif;
    ?>

    <div class="articleContent">
        <?php the_content(); ?>
        <!--
        <p>Siamo entusiasti di annunciare il rilascio di <b>Arianna v2.0</b>, la più grande evoluzione del nostro sistema modulare per l'automazione industriale didattica. Questa versione introduce funzionalità avanzate che rendono Arianna ancora più potente, flessibile e facile da utilizzare.</p>

        <h3>Novità Principali</h3>

        <p>La versione 2.0 porta con sé una serie di miglioramenti significativi che abbiamo sviluppato ascoltando il feedback della community e analizzando le esigenze degli utenti più avanzati.</p>

        <h3>Nuovi Moduli Meccanici</h3>
        <ul>
            <li><b>Nastro trasportatore modulare avanzato</b>: sistema completamente riprogettato con guide laterali regolabili e supporto per velocità variabile</li>
            <li><b>Modulo elevatore verticale</b>: permette di creare sistemi multi-livello per applicazioni più complesse</li>
            <li><b>Sistema di smistamento a 3 vie</b>: ideale per linee di montaggio con più destinazioni</li>
            <li><b>Pinza pneumatica intelligente</b>: con sensori di forza integrati e controllo di precisione</li>
        </ul>

        <div class="highlightBox">
            <p><b>💡 Nota importante:</b> Tutti i nuovi moduli sono completamente compatibili con i componenti della versione 1.x, garantendo un upgrade graduale senza dover sostituire l'intero sistema.</p>
        </div>

        <h3>Miglioramenti Elettronici</h3>
        <p>Le schede di controllo sono state completamente riprogettate per offrire prestazioni superiori e maggiore affidabilità:</p>
        <ul>
            <li>Supporto nativo per <b>PLC Siemens S7-1500</b> oltre agli S7-1200 già supportati</li>
            <li>Nuovi driver motori con controllo PID integrato per movimenti più precisi</li>
            <li>Interfaccia EtherCAT per comunicazione industriale ad alta velocità</li>
            <li>Protezioni avanzate contro sovracorrenti e cortocircuiti</li>
            <li>LED di stato per diagnostica rapida dei problemi</li>
        </ul>

        <h3>Software e Programmazione</h3>
        <p>Il pacchetto software è stato esteso con nuove librerie e strumenti di sviluppo:</p>
        <ul>
            <li><b>Libreria TIA Portal v4.2</b>: oltre 50 blocchi funzione pronti all'uso</li>
            <li>Nuovi esempi di programmazione per scenari complessi</li>
            <li>Simulatore virtuale per testare i programmi prima del deployment</li>
            <li>Interfaccia HMI migliorata con grafiche più moderne e intuitive</li>
            <li>Supporto per comunicazione MQTT e integrazione IoT</li>
        </ul>

        <h2>Documentazione e Supporto</h2>
        <p>Insieme alla release tecnica, abbiamo aggiornato tutta la documentazione del progetto:</p>
        <ul>
            <li>Manuale utente completamente riscritto con oltre 200 pagine di contenuti</li>
            <li>15 nuovi tutorial video per guidarti passo dopo passo</li>
            <li>Schede di laboratorio per uso didattico in classe</li>
            <li>FAQ estesa con soluzioni ai problemi più comuni</li>
        </ul>

        <h2>Come Aggiornare</h2>
        <p>Se hai già installato Arianna v1.x, l'aggiornamento è semplice e graduale. Tutti i file sono disponibili nella sezione <b>Download</b> del sito. Ti consigliamo di:</p>
        <ol style="padding-left: 30px; margin: 20px 0;">
            <li>Scaricare il pacchetto completo v2.0</li>
            <li>Fare backup delle tue configurazioni attuali</li>
            <li>Installare i nuovi file software sul PLC</li>
            <li>Stampare i nuovi moduli meccanici secondo necessità</li>
            <li>Consultare la guida di migrazione per eventuali modifiche necessarie</li>
        </ol>

        <div class="highlightBox">
            <p><b>🎓 Workshop di aggiornamento:</b> Organizzeremo un workshop gratuito il 15 Gennaio 2025 presso l'ITIS Zuccante per mostrare tutte le novità della v2.0. Posti limitati - iscriviti subito!</p>
        </div>

        <h2>Ringraziamenti</h2>
        <p>Questa release è il risultato del lavoro di mesi da parte del team di sviluppo e del contributo prezioso della community. Un ringraziamento speciale a:</p>
        <ul>
            <li>Tutti gli studenti e docenti che hanno testato le versioni beta</li>
            <li>I membri della community che hanno contribuito con suggerimenti e feedback</li>
            <li>Le aziende partner che hanno fornito supporto tecnico</li>
            <li>L'ITIS Zuccante per aver ospitato le sessioni di testing</li>
        </ul>

        <p>Arianna v2.0 rappresenta un passo importante verso il nostro obiettivo di rendere l'automazione industriale accessibile a tutti. Scarica la nuova versione e inizia a esplorare le nuove possibilità!</p>
        -->
    </div>

    <?php
        $tags = get_the_tags();
        if($tags) :
    ?>

    <div class="tagsSection">
        <span class="tagsLabel">Tags:</span>
        <?php
            foreach($tags as $tag) :
        ?>
            <a href="#" class="tag"><?= $tag->name ?></a>
        <?php
            endforeach;
        ?>
    </div>

    <?php
        endif;
    ?>

    <div class="shareSection">
        <span style="font-size: 14px; color: var(--bordi);">Condividi questo articolo:</span>
        <div class="shareButtons">
            <button class="shareBtn" title="Condividi su Twitter">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                </svg>
            </button>
            <button class="shareBtn" title="Condividi su Facebook">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
            </button>
            <button class="shareBtn" title="Condividi su LinkedIn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                    <rect x="2" y="9" width="4" height="12"></rect>
                    <circle cx="4" cy="4" r="2"></circle>
                </svg>
            </button>
            <button class="shareBtn" title="Copia link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                </svg>
            </button>
        </div>
    </div>

    <?php
        if($related_posts) :
    ?>
    <div class="relatedNews">
        <h2 style="margin: 0;">Articoli Correlati</h2>
        <div class="relatedNewsGrid">
            <?php
                foreach($related_posts as $post) :
                    setup_postdata($post);
            ?>
            <a href="<?= get_permalink($post->ID); ?>" class="relatedCard">
                <div class="relatedImage" style="background-image: url('<?= get_the_post_thumbnail_url($post->ID,'full'); ?>');"></div>
                <div class="relatedContent">
                    <h3 class="relatedTitle"><?= get_the_title($post->ID); ?></h3>
                    <small class="relatedDate"><?= get_the_date('d F Y', $post->ID); ?></small>
                </div>
            </a>
            <?php
                endforeach;
                wp_reset_postdata();
            ?>
        </div>
    </div>
    <?php
        endif;
    ?>
</div>

<script>
    // Share buttons functionality
    document.querySelectorAll('.shareBtn').forEach((btn, index) => {
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

<?php
    get_footer();
?>