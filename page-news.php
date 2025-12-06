<?php
    get_header();
?>

<div class="content">
    <header>
        <div class="subtitleContainer">
            <h2>Aggiornamenti</h2>
            <p>Di lato una lista aggiornata degli utlimi aggiornamenti apportati al progetto, con le rispettive
                date.</p>
        </div>
    </header>
    <span></span>
    <?php
        query_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        if ( have_posts() ) :
    ?>
    <div class="colonne">
        <?php
            while ( have_posts() ) : the_post();
        ?>
        <div class="date">
            <div class="sinistra">
                <div class="dataETitolo">
                    <h3>
                        <?php the_date(); ?>
                    </h3>
                    <span></span>
                    <p>
                        <?php the_title(); ?>
                    </p>
                </div>
            </div>
            <div class="destra">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="immagine">
                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                </div>
                <?php endif; ?>
                <div class="testo">
                    <p>
                        <?php the_content(); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php
            endwhile;
        ?>
    </div>

    <?php
        endif;
    ?>
</div>

<div class="righette">
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna" id="righettaTablet"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
</div>

<?php
    get_footer();
?>