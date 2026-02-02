<?php
    get_header();
?>

    <div class="righette">
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
    </div>

    <div class="content">
        <header>
            <span></span>
            <div class="subtitleContainer">
                <h2>Kit Disponibili</h2>
                <p>
                    Scegli il kit che meglio si adatta alle tue esigenze.
                    Ogni kit include tutti i componenti necessari per costruire una specifica linea di montaggio automatizzata.
                    <br><br>
                    Puoi anche consultare la <a href="<?= get_post_type_archive_link('components') ?>" style="color: var(--accent);"><b>libreria componenti</b></a> per creare configurazioni personalizzate.
                </p>
            </div>
        </header>

        <div class="statsBar">
            <div class="statItem">
                <span class="statNumber"><?= wp_count_posts('kits')->publish; ?></span>
                <small>Kit Disponibili</small>
            </div>
            <div class="statItem">
                <span class="statNumber"><?= wp_count_posts('components')->publish; ?></span>
                <small>Componenti Totali</small>
            </div>
            <div class="statItem">
                <span class="statNumber">125+</span>
                <small>Download</small>
            </div>
        </div>

        <div class="kitsGrid" id="kitsGrid">
            <?php
                $kits = new WP_Query(array(
                    'post_type' => 'kits',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ));

                if ($kits->have_posts()) :
                    while ($kits->have_posts()) : $kits->the_post();
                    $components = arianna_kits_components_get(get_the_ID());
            ?>
            <div class="kitCard">
                <div class="kitImage">
                    <span class="kitNumber">KIT</span>
                </div>
                <div class="kitContent">
                    <div class="kitHeader">
                        <h3><?= get_the_title(); ?></h3>
                        <span class="kitDifficulty base">
                            Base
                        </span>
                    </div>
                    <p><?= get_the_content(); ?></p>
                    <div class="kitStats">
                        <div class="kitStat">
                            <span>📦</span>
                            <span><?= count($components); ?> componenti</span>
                        </div>
                    </div>
                    <!--
                    <div class="kitStats" style="border-top: none; padding-top: 0;">
                        <div class="kitStat">
                            <span style="color: #4A90E2;">●</span>
                            <span>${kit.meccanica} Mec.</span>
                        </div>
                        <div class="kitStat">
                            <span style="color: #E24A4A;">●</span>
                            <span>${kit.hardware} Hard.</span>
                        </div>
                        <div class="kitStat">
                            <span style="color: #4AE290;">●</span>
                            <span>${kit.software} Soft.</span>
                        </div>
                    </div>
                    -->
                    <div class="kitActions">
                        <button class="viewBtn" onclick="event.stopPropagation(); window.location.href='<?= get_permalink(); ?>'">
                            Visualizza Kit
                        </button>
                    </div>
                </div>
            </div>
            
            <?php
                    endwhile;
                    wp_reset_postdata();
                else :
            ?>
                <p>Nessun kit trovato.</p>
            <?php
                endif;
            ?>

        </div>
    </div>


<?php
    get_footer();
?>