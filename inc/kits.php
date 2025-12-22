<?php

// Create the "Kit" custom post type
function arianna_kit_post_type()
{
    register_post_type("kit", [
        "labels" => [
            "name" => "Kit",
            "singular_name" => "Kit",
            "add_new" => "Aggiungi Kit",
            "add_new_item" => "Aggiungi Nuovo Kit",
            "edit_item" => "Modifica Kit",
            "all_items" => "Kit",
        ],
        "public" => true,
        "has_archive" => true,
        "menu_icon" => "dashicons-archive",
        "supports" => ["title", "editor", "thumbnail"],
        "show_in_menu" => "arianna-contents",
    ]);
}
add_action("init", "arianna_kit_post_type");

// Create taxonomy for kit components
function arianna_kit_components_taxonomy() {
    $labels = array(
        'name' => 'Relazioni Kit-Componenti',
        'singular_name' => 'Relazione',
    );
    $args = array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => false,
        'show_admin_column' => false,
        'query_var' => true,
        'object_type' => array('kit', 'component'), 
    );
    register_taxonomy('kit_component_relazione', $args['object_type'], $args);
}
add_action('init', 'arianna_kit_components_taxonomy');

// Add meta box for kit components
function arianna_kit_components_metabox() {
    add_meta_box(
        'kit_components_metabox',           // ID univoco del metabox
        'Seleziona Componenti del Kit',     // Titolo
        'arianna_kit_components_render_metabox',    // Funzione di callback per il contenuto
        'kit',                              // Assegna al CPT 'kit'
        'normal',                           // Contesto (dove appare)
        'high'                              // Priorità
    );
}
add_action('add_meta_boxes', 'arianna_kit_components_metabox');

function arianna_kit_components_render_metabox($post) {
    // Aggiungi un campo nonce per la sicurezza
    wp_nonce_field('save_kit_components', 'kit_components_nonce');

    // 1. Recupera tutti i post 'componente'
    $components_query = new WP_Query([
        'post_type'      => 'component',
        'posts_per_page' => -1, // Tutti i componenti
        'orderby'        => 'title',
        'order'          => 'ASC',
        'fields'         => 'ids', // Recupera solo gli ID per efficienza
    ]);
    $all_component_ids = $components_query->posts;

    // 2. Recupera gli Componenti attualmente collegati a questo kit
    $current_terms = wp_get_post_terms($post->ID, 'kit_component_relazione', ['fields' => 'slugs']);

    // Se ci sono termini di giunzione, trova gli ID dei post 'componente' con gli stessi termini
    $selected_component_ids = [];
    if (!empty($current_terms) && !is_wp_error($current_terms)) {
        $related_components_query = new WP_Query([
            'post_type'      => 'component',
            'posts_per_page' => -1,
            'fields'         => 'ids',
            'tax_query'      => [
                [
                    'taxonomy' => 'kit_component_relazione',
                    'field'    => 'slug',
                    'terms'    => $current_terms,
                ],
            ],
        ]);
        $selected_component_ids = $related_components_query->posts;
    }

    echo '<select name="related_components[]" multiple="multiple" style="width: 100%; height: 300px;">';

    if (!empty($all_component_ids)) {
        foreach ($all_component_ids as $component_id) {
            $component_title = get_the_title($component_id);
            $selected = in_array($component_id, $selected_component_ids) ? 'selected' : '';
            echo '<option value="' . esc_attr($component_id) . '" ' . $selected . '>';
            echo esc_html($component_title);
            echo '</option>';
        }
    } else {
        echo '<option disabled>Nessun Componente trovato. Creane uno prima.</option>';
    }
    echo '</select>';

    // Suggerimento per l'utente
    echo '<p class="description">Tieni premuto CTRL (o CMD) per selezionare più componenti.</p>';
}

function arianna_kit_components_save($post_id) {
    // Controlli di sicurezza standard di WordPress
    if (!isset($_POST['kit_components_nonce']) || !wp_verify_nonce($_POST['kit_components_nonce'], 'save_kit_components')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if ('kit' !== get_post_type($post_id)) {
        return;
    }

    // 1. Definisco il termine di giunzione unico (slug e nome)
    $junction_term_slug = 'relazione_' . $post_id;
    $junction_term_name = 'Relazione Kit ID ' . $post_id;

    // Se il termine non esiste, lo creo. Altrimenti, lo recupero.
    $term = term_exists($junction_term_slug, 'kit_component_relazione');
    if (0 === $term || null === $term) {
        $term_result = wp_insert_term(
            $junction_term_name,
            'kit_component_relazione',
            ['slug' => $junction_term_slug]
        );
        if (is_wp_error($term_result)) {
            // Gestione errore
            return; 
        }
    }

    // 2. Assegno il termine di giunzione al Film corrente
    wp_set_post_terms($post_id, [$junction_term_slug], 'kit_component_relazione');

    // 3. Rimuovo il termine da tutti i vecchi attori e lo riassegno solo a quelli selezionati.

    // a) Recupero gli ID degli attori selezionati dall'interfaccia
    $selected_component_ids = isset($_POST['related_components']) ? array_map('intval', (array) $_POST['related_components']) : [];

    // b) Rimuovo il termine di giunzione da tutti gli Attori che prima erano collegati
    // Questo è il passo che rende la relazione dinamica.
    $old_components_query = new WP_Query([
        'post_type'      => 'component',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'kit_component_relazione',
                'field'    => 'slug',
                'terms'    => [$junction_term_slug],
            ],
        ],
        'fields'         => 'ids',
    ]);

    foreach ($old_components_query->posts as $old_component_id) {
        // Se il componente non è nella nuova lista, rimuovo il termine
        if (!in_array($old_component_id, $selected_component_ids)) {
            wp_remove_object_terms($old_component_id, $junction_term_slug, 'kit_component_relazione');
        }
    }

    // c) Assegno il termine a tutti gli attori selezionati (anche quelli già assegnati, non fa danno)
    foreach ($selected_component_ids as $component_id) {
        wp_set_post_terms($component_id, [$junction_term_slug], 'kit_component_relazione', true); // 'true' per appendere
    }
}
add_action('save_post', 'arianna_kit_components_save');