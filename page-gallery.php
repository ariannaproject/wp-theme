<?php
    get_header();
?>

<div class="content">
    <header>
        <div class="subtitleContainer">
            <h2>Galleria</h2>
            <p>I migliori angoli del nostro progetto.</p>
        </div>
        <span></span>
        <div class="player">
            <iframe src="https://www.youtube-nocookie.com/embed/zab74BI6h2o?autoplay=1&mute=1" frameborder="0"
                allowfullscreen></iframe>
        </div>
    </header>

    <?php
        $images = new WP_Query(array(
            'post_type' => 'gallery_images',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ));
    ?>

    <?php if ($images->have_posts()) : ?>

    <div class="group">
        <?php while ($images->have_posts()) : $images->the_post(); 
            $orientation = get_post_meta(get_the_ID(), '_image_orientation', true);
        ?>
            <div class="<?php echo $orientation === 'landscape' ? 'landscape' : 'portrate'; ?>" style="background-image: url('<?php echo the_post_thumbnail_url('full'); ?>');"></div>
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
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
</div>


<?php
    get_footer();
?>