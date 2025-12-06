<?php
    get_header();
?>

<div class="content">
        <header>
            <h2>Team</h2>
            <p>L'idea era complessa, e per realizzarla è stato necessario dividerci in gruppi che si occupassero di
                mansioni simili. Dalla progettazione meccanica a quella dell' elettronica fino al software. Altri ruoli
                vedevano figure occuparsi di coordinamento e gestione di tempi/risorse mentre altre ancora
                comunicazione. Di seguito tutte le persone che hanno reso Arianna possibile.</p>
        </header>

        <?php
            $members = new WP_Query(array(
                'post_type' => 'team_members',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC',
            ));

            if ($members->have_posts()) :
        ?>

        <div class="group">
            <?php while ($members->have_posts()) : $members->the_post(); ?>
                <div class="card">
                    <div class="cardImage">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="cardContent">
                        <small><?php the_title(); ?>, <?php echo get_post_meta(get_the_ID(), '_member_role', true); ?></small>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php 
            wp_reset_postdata();
            endif;
        ?>
    </div>

    <div class="righette">
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna" style="border: none;"></div>
    </div>


<?php
    get_footer();
?>