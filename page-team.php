<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-3"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="page-header">
        <h1>Team</h1>
        <p>
             L'idea era complessa, e per realizzarla è stato necessario dividerci in gruppi che si occupassero di mansioni simili. Dalla progettazione meccanica a quella dell'elettronica fino al software. Altri ruoli vedevano figure occuparsi di coordinamento e gestione di tempi/risorse mentre altre ancora comunicazione. Di seguito tutte le persone che hanno reso Arianna possibile, organizzate per anno e dipartimento. 
        </p>
    </div>

    <div>
        <?php foreach(get_terms(['taxonomy' => 'team_member_year']) as $year) : ?>
            <div class="year-section">
                <h5 class="year-header">
                    <?php echo esc_html($year->name); ?>
                </h5>

                <?php
                    foreach(get_terms(['taxonomy' => 'team_member_department']) as $department) :
                    $members = get_posts([
                                'post_type' => 'team_member',
                                'numberposts' => -1,
                                'tax_query' => [
                                    'relation' => 'AND',
                                    [
                                        'taxonomy' => 'team_member_year',
                                        'field' => 'slug',
                                        'terms' => $year->slug,
                                    ],
                                    [
                                        'taxonomy' => 'team_member_department',
                                        'field' => 'slug',
                                        'terms' => $department->slug,
                                    ],
                                ],
                                'orderby' => 'title',
                                'order' => 'ASC',
                            ]);
                    if(count($members) === 0) continue;
                ?>
                    <div class="department-section">
                        <div class="department-header">
                            <h6 class="mb-0"><?php echo esc_html($department->name); ?></h6>
                        </div>
                        <div class="team-grid">
                            <?php foreach($members as $member) : ?>
                                <div class="card cliccable-card">
                                    <div class="card-img-container">
                                        <img src="<?= get_the_post_thumbnail_url($member->ID); ?>" alt="<?= esc_attr($member->post_title); ?>" class="card-img">
                                    </div>
                                    <div class="card-text text-center text-small px-2 py-3"><?= esc_html($member->post_title); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>