<?php get_header(); ?>

<div class="bg-rows container">
	<div class="bg-row bg-row-1"></div>
	<div class="bg-row bg-row-3"></div>
	<div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="page-header">
		<h1><?php the_title(); ?></h1>
	</div>

	<div class="bg-white bordered p-4 wp-content">
        <?php the_content(); ?>
	</div>

</div>

<?php get_footer(); ?>