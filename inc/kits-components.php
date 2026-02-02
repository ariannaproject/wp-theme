<?php

/**
 * Create a custom table to manage many-to-many relationships between Kits and Components
 */
function arianna_kits_components_create_relation_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kits_components_relations';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id bigint(20) NOT NULL AUTO_INCREMENT,
        kit_id bigint(20) NOT NULL,
        component_id bigint(20) NOT NULL,
        PRIMARY KEY  (id),
        KEY kit_id (kit_id),
        KEY component_id (component_id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
add_action( 'after_setup_theme', 'arianna_kits_components_create_relation_table' );


/**
 * Show a meta box to select Components for a Kit
 */
function arianna_kits_components_metabox() {
    add_meta_box(
        'kit_components_metabox',                   // Unique ID of the metabox
        'Select Kit Components',                    // Title
        'arianna_kits_components_render_metabox',    // Callback function for content
        'kits',                                      // Assign to CPT 'kits'
        'normal',                                   // Context (where it appears)
        'high'                                      // Priority
    );
}
add_action('add_meta_boxes', 'arianna_kits_components_metabox');


/**
 * Render the meta box content
 */
function arianna_kits_components_render_metabox($post) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kits_components_relations';

    // Get all components available
    $components = get_posts(['post_type' => 'components', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC']);

    // Get currently linked components
    $linked = $wpdb->get_col($wpdb->prepare(
        "SELECT component_id FROM $table_name WHERE kit_id = %d",
        $post->ID
    ));

    // Sicurezza: Nonce field
    wp_nonce_field('save_relation_nonce', 'relation_nonce');

    echo '<div style="max-height:200px; overflow-y:auto; border:1px solid #ddd; padding:10px;">';
    foreach ($components as $component) {
        $checked = in_array($component->ID, $linked) ? 'checked' : '';
        echo "<label><input type='checkbox' name='components_selected[]' value='{$component->ID}' $checked> {$component->post_title}</label><br>";
    }
    echo '</div>';
}


/**
 * Save the selected Components when the Kit is saved
 */
function arianna_kits_components_save($post_id) {
    // Security checks
    if (!isset($_POST['relation_nonce']) || !wp_verify_nonce($_POST['relation_nonce'], 'save_relation_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    global $wpdb;
    $table_name = $wpdb->prefix . 'kits_components_relations';

    // Delete existing relations
    $wpdb->delete($table_name, ['kit_id' => $post_id], ['%d']);

    // Insert new relations
    if (isset($_POST['components_selected']) && is_array($_POST['components_selected'])) {
        foreach ($_POST['components_selected'] as $component_id) {
            $wpdb->insert(
                $table_name,
                ['kit_id' => $post_id, 'component_id' => intval($component_id)],
                ['%d', '%d']
            );
        }
    }
}
add_action('save_post_kits', 'arianna_kits_components_save');


/**
 * Retrieve Components linked to a specific Kit
 */
function arianna_kits_components_get($kit_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kits_components_relations';

    $component_ids = $wpdb->get_col($wpdb->prepare(
        "SELECT component_id FROM $table_name WHERE kit_id = %d",
        $kit_id
    ));

    if (empty($component_ids)) {
        return [];
    }

    $components = get_posts([
        'post_type' => 'components',
        'post__in' => $component_ids,
        'orderby' => 'post__in'
    ]);

    return $components;
}