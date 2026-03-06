<?php get_header(); ?>

<div class="bg-rows container">
    <div class="bg-row bg-row-1"></div>
    <div class="bg-row bg-row-5"></div>
</div>

<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
        <div class="text-center">
            <h1 class="arianna-logo text-primary m-0" style="font-size: 250px">404</h1>
            <h1>Pagina non trovata</h1>
            <p>Ci dispiace, la pagina che stai cercando non esiste.</p>
            <a href="<?php echo home_url(); ?>" class="btn btn-primary">Torna alla homepage</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>