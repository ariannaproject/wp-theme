<?php

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
    global $post;
    $version = wp_get_theme()->get('Version');

    wp_enqueue_style('arianna-style', get_template_directory_uri() . '/assets/css/arianna.css', array(), $version, 'all');

    if(is_front_page()) {
        wp_enqueue_style('arianna-front-page', get_template_directory_uri() . '/assets/css/front-page.css', array('arianna-style'), $version, 'all');
    }

    if(is_archive() && file_exists(get_template_directory() . '/assets/css/' . get_post_type() . '-archive.css')) {
        wp_enqueue_style('arianna-' . get_post_type() . '-archive', get_template_directory_uri() . '/assets/css/' . get_post_type() . '-archive.css', array('arianna-style'), $version, 'all');
    } else if(file_exists(get_template_directory() . '/assets/css/' . $post->post_name . '.css')) {
        wp_enqueue_style('arianna-' . $post->post_name, get_template_directory_uri() . '/assets/css/' . $post->post_name . '.css', array('arianna-style'), $version, 'all');
    } else if(is_single() && file_exists(get_template_directory() . '/assets/css/' . get_post_type() . '-single.css')) {
        wp_enqueue_style('arianna-single-' . get_post_type(), get_template_directory_uri() . '/assets/css/' . get_post_type() . '-single.css', array('arianna-style'), $version, 'all');
    }
}
add_action('wp_enqueue_scripts', 'arianna_register_styles');

function arianna_register_scripts() {
    global $post;
    $version = wp_get_theme()->get('Version');

    wp_enqueue_script('arianna-script', get_template_directory_uri() . '/assets/js/arianna.js', array(), $version, true);

    if(is_archive() && file_exists(get_template_directory() . '/assets/js/' . get_post_type() . '-archive.js')) {
        wp_enqueue_script('arianna-component', get_template_directory_uri() . '/assets/js/' . get_post_type() . '-archive.js', array('arianna-script'), $version, true);
    } else if(file_exists(get_template_directory() . '/assets/js/' . $post->post_name . '.js')) {
        wp_enqueue_script('arianna-' . $post->post_name, get_template_directory_uri() . '/assets/js/' . $post->post_name . '.js', array('arianna-script'), $version, true);
    } else if(is_single() && file_exists(get_template_directory() . '/assets/js/' . get_post_type() . '-single.js')) {
        wp_enqueue_script('arianna-single-' . get_post_type(), get_template_directory_uri() . '/assets/js/' . get_post_type() . '-single.js', array('arianna-script'), $version, true);
    }

    // Module for 3d model on the front page
    if(is_front_page()) {
        wp_register_script_module('arianna-front-page', get_template_directory_uri() . '/assets/js/front-page.js', array(), $version);
        wp_enqueue_script_module('arianna-front-page');
    }
}
add_action('wp_enqueue_scripts', 'arianna_register_scripts');


// =========== CUSTOM MENU ===========

function arianna_create_custom_menu() {
    // Add separator
    global $menu;
    $menu[39] = ['', 'read', '', '', 'wp-menu-separator'];

    add_menu_page(
        'Altro Arianna',
        'Altro Arianna',
        'edit_posts',
        'arianna-contents',
        '',
        'dashicons-portfolio',
        51
    );
}
add_action('admin_menu', 'arianna_create_custom_menu');


// =========== UTILS ===========
function arianna_enable_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'arianna_enable_svg_upload');

function arianna_hide_admin_bar() {
    return false;
}
add_filter('show_admin_bar', 'arianna_hide_admin_bar');


foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
    require_once $file;
}

flush_rewrite_rules( false );