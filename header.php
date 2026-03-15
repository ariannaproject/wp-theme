<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php wp_head(); ?>
    </head>
    <body>
        <div class="menu menu-desktop container">
            <div>
                <?php if(!is_front_page()): ?>
                    <a href="<?= home_url(); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                        Torna alla home
                    </a>
                <?php endif; ?>
            </div>

            <div class="d-flex" style="gap: 50px;">
                <?php
                    wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => '',
                    'items_wrap' => '%3$s',
                    ));
                ?>
            </div>

            <div class="d-flex gap-3">
                <a href="<?= get_permalink(get_page_by_path('download')) ?>" class="btn btn-primary">Scarica il progetto</a>
                <?php if(is_user_logged_in() && !current_user_can('subscriber')) : ?>
                    <a href="<?= admin_url() ?>">Amministrazione</a>
                <?php elseif(is_user_logged_in()): ?>
                    <a href="<?= wp_logout_url() ?>">Logout</a>
                <?php else: ?>
                    <a href="<?= wp_login_url() ?>">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="menu menu-mobile container" id="menu-mobile">
            <div class="menu-mobile-icon" id="menu-mobile-icon">
                <span></span>
                <span></span>
            </div>

            <div class="menu-mobile-dropdown" id="menu-mobile-dropdown">
                <?php
                    wp_nav_menu(array(
                    'items_wrap' => '%3$s',
                    'theme_location' => 'mobile',
                    'container' => '',
                    ));
                ?>
            </div>
        </div>