<?php
    get_header();
?>
  <div class="righette">
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna" id="righettaTablet"></div>
    <div class="righettaInterna"></div>
    <div class="righettaInterna"></div>
  </div>

  <header>
    <div id="title">
      <h1 id="titleText">
        Arianna
      </h1>
    </div>
    <div class="subtitleContainer">
      <div class="subtitle">
        <h3>Un sistema modulare basato su componenti stampabili in 3D. <br>Una nuova soluzione per sperimentare sistemi
          automatizzati con l'utilizzo di PLC</h3>
      </div>
    </div>
    <div class="scrollContainer">
      <div class="scrollLine"></div>
    </div>
    <div class="fontCredit">Outward by Raoul Audouin. Distributed by velvetyne.fr.</div>
  </header>

  <div id="container3D"></div>

  <?php
    $cards = new WP_Query(array(
      'post_type' => 'carousel_features',
      'posts_per_page' => -1,
      'orderby' => 'menu_order',
      'order' => 'ASC',
    ));
  ?>

  <?php if($cards->have_posts()) : ?>

  <div class="carousel">
    <div class="cardGroup">
      <?php $i = 1; while($cards->have_posts()) : $cards->the_post(); ?>  

      <div class="card">
        <div class="cardImage">
          <?php if(has_post_thumbnail()) : ?>
            <img style="width: 80%;" src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
          <?php endif; ?>
        </div>
        <div class="cardContent">
          <div class="cardText">
            <h3><?php the_title(); ?></h3>
            <?php the_content(); ?>
          </div>
          <p style="text-align: end;"><?= str_pad($i++, 2, '0', STR_PAD_LEFT); ?></p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>

    <div class="cardGroup">
      <?php $i = 1; while($cards->have_posts()) : $cards->the_post(); ?>  

      <div class="card">
        <div class="cardImage">
          <?php if(has_post_thumbnail()) : ?>
            <img style="width: 80%;" src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
          <?php endif; ?>
        </div>
        <div class="cardContent">
          <div class="cardText">
            <h3><?php the_title(); ?></h3>
            <?php the_content(); ?>
          </div>
          <p style="text-align: end;"><?= str_pad($i++, 2, '0', STR_PAD_LEFT); ?></p>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

  <?php 
    wp_reset_postdata();
    endif;
  ?>

  <div id="descrizione">
    <div class="colonnaTesto" style="justify-content: start;">
      <h2>Come funziona?</h2>
      <br>
      <p>I <b>moduli meccanici</b> possono essere composti tra loro tramite un meccanismo a scorrimento che permette ad
        un perno di
        scivolare su una scanalatura a coda di rondine ricavata sui bordi di ciascun blocco.<br><br>

        Delle <b>schede elettroniche</b> sono inserite all'interno di moduli dedicati. Queste permettono al pezzo di
        interfacciarsi con un ecosistema di <b>moduli</b> e <b>espansioni</b> basato su PLC.<br><br>
        Per motori, sensori o nastri sono stati creati moduli dedicati, che meglio si combinano con le componenti più
        usate nel mercato.<br><br>
        L'intero sistema si basa su una <b>base ad incastro</b> che si combina con moduli appositi. Dentro la base è
        presente un sistema elettronico che rende effettiva la connessione al PLC.<br><br></p>
    </div>
  </div>

<?php
    get_footer();
?>