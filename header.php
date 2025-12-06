<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php
    wp_head();
  ?>
  
  <link rel="manifest" href="/manifest.json" />
  <meta name="theme-color" content="#000000" />
</head>

<body>

  <div class="menu">
    
    <?php if (!is_front_page()) : ?>
      <div class='tornaIndietro'>
        <a href="<?= home_url(); ?>">
          <box-icon style="width: 20px; margin-right: 5px;" name='left-arrow-alt' color="currentColor"></box-icon>
          Torna alla Home
        </a>
      </div>
    <?php else: ?>
      <span></span>
    <?php endif; ?>
    
    <div class='links'>
      <?php
        wp_nav_menu(array(
          'theme_location' => 'primary',
          'container' => '',
          'items_wrap' => '<ul class="linksText menuContainer">%3$s</ul>',
        ));
      ?>
      <div class="menuButtons">

        <?php if(!is_page('download')) : ?>
          <button id="scaricaIlProgetto" onclick="location.href='<?= get_permalink(get_page_by_path('download')) ?>'">
            Scarica il progetto
          </button>
        <?php endif; ?>

        <?php
          if(is_user_logged_in()) {
            echo '<a href="' . get_admin_url() . '">Amministrazione</a>';
          } else {
            echo '<a href="' . wp_login_url() . '">Login</a>';
          }
        ?>
      </div>
      
    </div>

    <div class="menuIcon" id="menuIcon">
      <span></span>
      <span></span>
    </div>
    
  </div>

  <div class="menuMobile" id="menuMobile">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'mobile',
          'container' => '',
          'items_wrap' => '<ul class="linkMobileContainer">%3$s</ul>',
          'add_li_class' => 'linkMobile',
        ));
      ?>
  </div>