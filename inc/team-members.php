<?php

function arianna_team_members_taxonomies() {
    register_taxonomy(
        'team_member_department',
        'team_member',
        array(
            'labels' => array(
                'name' => 'Dipartimenti del Membro',
                'singular_name' => 'Dipartimento del Membro',
                'search_items' => 'Cerca Dipartimenti del Team',
                'all_items' => 'Tutti i Dipartimenti del Team',
                'edit_item' => 'Modifica Dipartimento del Team',
                'update_item' => 'Aggiorna Dipartimento del Team',
                'add_new_item' => 'Aggiungi Nuovo Dipartimento del Team',
                'new_item_name' => 'Nome Nuovo Dipartimento del Team',
                'menu_name' => 'Dipartimenti del Team',
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'team-member-departments'),
            'rest_base' => 'team-member-departments',
        )
    );

    register_taxonomy(
        'team_member_year',
        'team_member',
        array(
            'labels' => array(
                'name' => 'Anni di Partecipazione',
                'singular_name' => 'Anno di Partecipazione',
                'search_items' => 'Cerca Anni di Partecipazione',
                'all_items' => 'Tutti gli Anni di Partecipazione',
                'edit_item' => 'Modifica Anno di Partecipazione',
                'update_item' => 'Aggiorna Anno di Partecipazione',
                'add_new_item' => 'Aggiungi Nuovo Anno di Partecipazione',
                'new_item_name' => 'Nome Nuovo Anno di Partecipazione',
                'menu_name' => 'Anni di Partecipazione',
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'team-member-years'),
            'rest_base' => 'team-member-years',
        )
    );
}
add_action('init', 'arianna_team_members_taxonomies');

function arianna_team_members_post_type() {
    register_post_type('team_member',
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
            'taxonomies' => ['team_member_department', 'team_member_year'],
            'show_in_rest' => true, // Per usare l'editor Gutenberg
            'show_in_menu' => 'arianna-contents',
            'rewrite' => array('slug' => 'team-members'),
            'rest_base' => 'team-members',
        )
    );
}
add_action('init', 'arianna_team_members_post_type');

