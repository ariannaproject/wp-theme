<?php

function arianna_components_taxonomy() {
    register_taxonomy(
        'component_category',
        'components',
        array(
            'labels' => array(
                'name' => 'Categorie Componenti',
                'singular_name' => 'Categoria Componente',
                'search_items' => 'Cerca Categorie Componenti',
                'all_items' => 'Tutte le Categorie Componenti',
                'edit_item' => 'Modifica Categoria Componente',
                'update_item' => 'Aggiorna Categoria Componente',
                'add_new_item' => 'Aggiungi Nuova Categoria Componente',
                'new_item_name' => 'Nome Nuova Categoria Componente',
                'menu_name' => 'Categorie Componenti',
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
        )
    );
}
add_action('init', 'arianna_components_taxonomy');

function arianna_components_post_type() {
    register_post_type('components',
        array(
            'labels' => array(
                'name' => 'Componenti',
                'singular_name' => 'Componente',
                'add_new' => 'Aggiungi Componente',
                'add_new_item' => 'Aggiungi Nuovo Componente',
                'edit_item' => 'Modifica Componente',
                'all_items' => 'Componenti'
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-archive',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
            'show_in_menu' => 'arianna-contents',
            'taxonomies' => array('component_category'),
        )
    );
}
add_action('init', 'arianna_components_post_type');