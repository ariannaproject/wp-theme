<?php

// =========== BACKEND URLS ============
define('ARIANNA_BACKEND_URL', 'https://app.arianna.michieletto.it/');
define('ARIANNA_API_ME_URL', ARIANNA_BACKEND_URL . 'api/me');
define('ARIANNA_LOGIN_URL', ARIANNA_BACKEND_URL . 'auth/login');

// =========== THEME SUPPORT ===========
function arianna_theme_support() {
    // Adds dynamic title tag support
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'arianna_theme_support');

// =========== THEME INITIALIZATION ===========


// =========== MENUS ===========
function arianna_menus() {
    $locations = array(
        'primary' => "Desktop Head Menu",
        'mobile' => "Mobile Head Menu"
    );
    register_nav_menus($locations);
}

add_action('init', 'arianna_menus');


// =========== ENQUEUE STYLES & SCRIPTS ===========
function arianna_register_styles() {
    $version = wp_get_theme()->get('Version');

    if(!is_front_page() && !is_404()) {
        wp_enqueue_style('arianna-main-style', get_template_directory_uri() . '/assets/css/globalStyle.css', array(), $version, 'all');
    }

    if(is_front_page() || is_404()) {
        wp_enqueue_style('arianna-front-page-style', get_template_directory_uri() . '/assets/css/styleIndex.css', array(), $version, 'all');
    }

    if(is_page('team')) {
        wp_enqueue_style('arianna-team-page-style', get_template_directory_uri() . '/assets/css/styleTeam.css', array(), $version, 'all');
    }

    if(is_page('news')) {
        wp_enqueue_style('arianna-news-page-style', get_template_directory_uri() . '/assets/css/styleAggiornamenti.css', array(), $version, 'all');
    }

    if(is_page('download')) {
        wp_enqueue_style('arianna-download-page-style', get_template_directory_uri() . '/assets/css/styleDownload.css', array(), $version, 'all');
    }

    if(is_singular('kits')) {
        wp_enqueue_style('arianna-kit-page-style', get_template_directory_uri() . '/assets/css/styleKit.css', array(), $version, 'all');
    }

    if(is_singular('components')) {
        wp_enqueue_style('arianna-component-page-style', get_template_directory_uri() . '/assets/css/styleComponent.css', array(), $version, 'all');
    }

    if(is_singular('post')) {
        wp_enqueue_style('arianna-post-page-style', get_template_directory_uri() . '/assets/css/styleSinglePost.css', array(), $version, 'all');
    }

    if(is_post_type_archive('kits')) {
        wp_enqueue_style('arianna-kit-archive-style', get_template_directory_uri() . '/assets/css/styleKitArchive.css', array(), $version, 'all');
    }

    if(is_post_type_archive('components')) {
        wp_enqueue_style('arianna-component-archive-style', get_template_directory_uri() . '/assets/css/styleComponentArchive.css', array(), $version, 'all');
    }
}

add_action('wp_enqueue_scripts', 'arianna_register_styles');


function arianna_register_scripts() {
    $version = wp_get_theme()->get('Version');

    wp_enqueue_script('arianna-jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true);
    wp_enqueue_script('arianna-fittext', 'https://cdnjs.cloudflare.com/ajax/libs/FitText.js/1.2.0/jquery.fittext.min.js', array('arianna-jquery'), '1.2.0', true);
    wp_enqueue_script('arianna-scroll', get_template_directory_uri() . '/assets/js/appScroll.js', array('arianna-lenis'), $version, true);
    wp_enqueue_script('arianna-lenis', 'https://unpkg.com/lenis@1.1.19/dist/lenis.min.js', array(), '1.1.19', true);
    wp_enqueue_script('arianna-menu', get_template_directory_uri() . '/assets/js/appMenu.js', array(), $version, true);
    wp_enqueue_script('arianna-cursor', get_template_directory_uri() . '/assets/js/appCursor.js', array(), $version, true);
    wp_enqueue_script('arianna-icons', 'https://unpkg.com/boxicons@2.1.4/dist/boxicons.js', array(), '2.1.4', true);

    if(is_front_page()) {
        wp_enqueue_script('arianna-carousel', get_template_directory_uri() . '/assets/js/appCarousel.js', array(), $version, true);

        // This must be registered as a module to work properly
        wp_register_script_module('arianna-3d', get_template_directory_uri() . '/assets/js/appIndex.js', array(), $version);
        wp_enqueue_script_module('arianna-3d');
    }

    wp_enqueue_script('arianna-login', get_template_directory_uri() . '/assets/js/appLogin.js', array(), $version, true);
}

add_action('wp_enqueue_scripts', 'arianna_register_scripts');


function arianna_add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'arianna_add_additional_class_on_li', 1, 3);

function arianna_hide_admin_bar() {
    return false;
}
add_filter('show_admin_bar', 'arianna_hide_admin_bar');


// =========== CUSTOM POST TYPES and MENU ===========

function arianna_create_custom_menu() {
    add_menu_page(
        'Contenuti Arianna',           // Titolo pagina
        'Contenuti Arianna',           // Titolo menu
        'edit_posts',                  // Capability
        'arianna-contents',            // Slug
        '',                            // Funzione (vuota)
        'dashicons-rest-api',     // Icona
        50                             // Posizione
    );
}
add_action('admin_menu', 'arianna_create_custom_menu');


function arianna_create_carousel_features_post_type() {
    register_post_type('carousel_features',
        array(
            'labels' => array(
                'name' => 'Slide Funzionalità',
                'singular_name' => 'Slide',
                'add_new' => 'Aggiungi Slide',
                'add_new_item' => 'Aggiungi Nuova Slide',
                'edit_item' => 'Modifica Slide',
                'all_items' => 'Slide delle Funzionalità'
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-images-alt2',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true, // Per usare l'editor Gutenberg
            'show_in_menu' => 'arianna-contents',
        )
    );
}
add_action('init', 'arianna_create_carousel_features_post_type');

function arianna_create_team_members_post_type() {
    register_post_type('team_members',
        array(
            'labels' => array(
                'name' => 'Membri del Team',
                'singular_name' => 'Membro',
                'add_new' => 'Aggiungi Membro',
                'add_new_item' => 'Aggiungi Nuovo Membro',
                'edit_item' => 'Modifica Membro',
                'all_items' => 'Membri del Team'
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-groups',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true, // Per usare l'editor Gutenberg
            'show_in_menu' => 'arianna-contents',
        )
    );
}
add_action('init', 'arianna_create_team_members_post_type');


// Aggiungi il meta box
function arianna_add_member_role_metabox() {
    add_meta_box(
        'member_role',
        'Ruolo Membro',
        'arianna_show_member_role_metabox',
        'team_members',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'arianna_add_member_role_metabox');

// Mostra il contenuto del meta box
function arianna_show_member_role_metabox($post) {
    // Recupera il valore salvato
    $valore = get_post_meta($post->ID, '_member_role', true);
    // Nonce per sicurezza
    wp_nonce_field('save_member_role', 'member_role_nonce');
    ?>
    <label for="member_role">Ruolo del Membro:</label>
    <select name="member_role" id="member_role" style="width: 100%; margin-top: 10px;">
        <option value="Meccanica" <?php selected($valore, 'Meccanica'); ?>>Meccanica</option>
        <option value="Elettronica" <?php selected($valore, 'Elettronica'); ?>>Elettronica</option>
        <option value="Project Manager" <?php selected($valore, 'Project Manager'); ?>>Project Manager</option>
        <option value="Informatica" <?php selected($valore, 'Informatica'); ?>>Informatica</option>
        <option value="Supervisione" <?php selected($valore, 'Supervisione'); ?>>Supervisione</option>
    </select>
    <?php
}

// Salva il valore quando si salva il post
function arianna_save_team_member_post($post_id) {
    // Verifica nonce
    if (!isset($_POST['member_role_nonce']) || !wp_verify_nonce($_POST['member_role_nonce'], 'save_member_role')) {
        return;
    }
    // Verifica autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Verifica permessi
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    // Salva il valore
    if (isset($_POST['member_role'])) {
        update_post_meta($post_id, '_member_role', sanitize_text_field($_POST['member_role']));
    }
}
add_action('save_post', 'arianna_save_team_member_post');


function arianna_enable_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'arianna_enable_svg_upload');



foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
    require_once $file;
}

flush_rewrite_rules( false );