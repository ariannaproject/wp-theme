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
        <div class="subtitleContainer">
            <h2>Team</h2>
            <p>
                L'idea era complessa, e per realizzarla è stato necessario dividerci in gruppi che si occupassero di mansioni simili. Dalla progettazione meccanica a quella dell'elettronica fino al software. Altri ruoli vedevano figure occuparsi di coordinamento e gestione di tempi/risorse mentre altre ancora comunicazione. Di seguito tutte le persone che hanno reso Arianna possibile, organizzate per anno e dipartimento. 
            </p>
        </div>
    </header>

    <div style="width: 100%;">
        <!-- Anno 2025 -->
        <div class="year-section">
            <div class="year-header">
                <h3>2025</h3>
            </div>
            <?php
                $members = new WP_Query(array(
                    'post_type' => 'team_members',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC',
                ));

                if ($members->have_posts()) :
                    // Raggruppa i post per _member_role preservando l'ordine di apparizione
                    $groups = array();
                    foreach ($members->posts as $m) {
                        $role = get_post_meta($m->ID, '_member_role', true);
                        $role = trim($role) ? $role : 'Senza dipartimento';
                        if (!isset($groups[$role])) {
                            $groups[$role] = array();
                        }
                        $groups[$role][] = $m;
                    }

                    // Renderizza ogni gruppo (dipartimento)
                    foreach ($groups as $role => $posts) :
            ?>

            

                <div class="department-section">
                    <div class="department-header">
                        <h4><?php echo esc_html($role); ?></h4>
                    </div>
                    <div class="team-grid">
                        <?php foreach ($posts as $post) : setup_postdata($post); ?>
                        <div class="card">
                            <?php if (has_post_thumbnail($post->ID)) : ?>
                                <div class="cardImage">
                                    <img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'full')); ?>" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="cardContent">
                                <small><?php echo esc_html(get_the_title($post->ID)); ?></small>
                            </div>
                        </div>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                </div>
            <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>

</div>


<?php
    get_footer();
?>