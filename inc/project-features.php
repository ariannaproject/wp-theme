<?php
function arianna_create_project_features_post_type() {
    register_post_type('project_feature',
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
            'show_in_rest' => true,
            'show_in_menu' => 'arianna-contents',
            'rest_base' => 'project-features',
        )
    );
}
add_action('init', 'arianna_create_project_features_post_type');