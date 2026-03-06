<?php

function arianna_custom_login() { ?>
    <style type="text/css">
        #login h1 a {
            background-image: url(<?php echo get_site_icon_url(); ?>);
            background-size: contain;
            width: 100%;
            height: 120px;
        }
    </style>
<?php }
add_action('login_enqueue_scripts', 'arianna_custom_login');