<?php

function arianna_components_taxonomy() {
    register_taxonomy(
        'component_category',
        'component',
        array(
            'labels' => array(
                'name' => 'Categorie Componente',
                'singular_name' => 'Categoria Componente',
                'search_items' => 'Cerca Categorie Componente',
                'all_items' => 'Tutte le Categorie Componente',
                'edit_item' => 'Modifica Categoria Componente',
                'update_item' => 'Aggiorna Categoria Componente',
                'add_new_item' => 'Aggiungi Nuova Categoria Componente',
                'new_item_name' => 'Nome Nuova Categoria Componente',
                'menu_name' => 'Categorie Componente',
            ),
            'hierarchical' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'rewrite' => array('slug' => 'component-categories'),
            'rest_base' => 'component-categories',
        )
    );
}
add_action('init', 'arianna_components_taxonomy');

function arianna_components_post_type() {
    register_post_type('component',
        array(
            'labels' => [
                'name' => 'Componenti',
                'singular_name' => 'Componente',
                'add_new' => 'Aggiungi Componente',
                'add_new_item' => 'Aggiungi Nuovo Componente',
                'edit_item' => 'Modifica Componente',
                'all_items' => 'Componenti'
            ],
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-hammer',
            'supports' => ['title', 'editor', 'thumbnail', 'comments', 'excerpt'],
            'show_in_rest' => true,
            'show_in_menu' => true,
            'menu_position' => 42,
            'taxonomies' => ['component_category'],
            'rewrite' => ['slug' => 'components'],
            'rest_base' => 'components',
        )
    );
}
add_action('init', 'arianna_components_post_type');

function arianna_components_add_meta_boxes() {
    add_meta_box(
        'component_attachments',
        'Allegati Componente',
        'arianna_components_render_attachments_meta_box',
        'component',
        'normal',
        'high'
    );

    add_meta_box(
        'component_info',
        'Aggiuntive',
        'arianna_components_render_info_meta_box',
        'component',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'arianna_components_add_meta_boxes');

function arianna_components_show_meta_rest() {
    register_rest_field('component', 'version', array(
        'get_callback' => function ($data) {
            return get_post_meta($data['id'], '_component_version', true);
        },
    ));

    register_rest_field('component', 'attachments', array(
        'get_callback' => function ($data) {
            return get_post_meta($data['id'], '_attachments', true);
        },
    ));
}
add_action('rest_api_init', 'arianna_components_show_meta_rest');

function arianna_components_render_info_meta_box($post) {
    $version = get_post_meta($post->ID, '_component_version', true);
    ?>
    <label for="component_version">Versione:</label>
    <input type="text" id="component_version" name="component_version" value="<?php echo esc_attr($version); ?>" class="widefat">
    <?php
}

function arianna_components_save_info($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['component_version'])) {
        update_post_meta($post_id, '_component_version', sanitize_text_field($_POST['component_version']));
    }
}
add_action('save_post', 'arianna_components_save_info');

function arianna_components_render_attachments_meta_box($post) {
    $files = get_post_meta($post->ID, '_attachments', true) ?: [];
    wp_nonce_field('salva_attachments_nonce', 'attachments_nonce');
    ?>
    <div id="wrapper-allegati">
        <table class="widefat" id="tabella-allegati">
            <thead>
                <tr>
                    <th>File</th>
                    <th>Descrizione</th>
                    <th style="width: 50px;">Download</th>
                    <th style="width: 50px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($files as $index => $file) : ?>
                <tr>
                    <td>
                        <input type="hidden" name="attachments[<?php echo $index; ?>][file_id]" value="<?php echo esc_attr($file['file_id']); ?>" class="file-id">
                        <span class="file-url"><?php echo basename(wp_get_attachment_url($file['file_id'])); ?></span>
                        <button type="button" class="button select-file">Cambia File</button>
                    </td>
                    <td><input type="text" name="attachments[<?php echo $index; ?>][desc]" value="<?php echo esc_attr($file['desc']); ?>" class="large-text"></td>
                    <td style="text-align: center;"><strong><?php echo intval($file['count']); ?></strong></td>
                    <td><button type="button" class="button remove-row">×</button></td>
                    <input type="hidden" name="attachments[<?php echo $index; ?>][count]" value="<?php echo intval($file['count']); ?>">
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><button type="button" class="button button-primary" id="add-file-row">Aggiungi Nuovo File</button></p>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#wrapper-allegati').on('click', '.select-file', function(e) {
            e.preventDefault();
            var btn = $(this), row = btn.closest('tr');
            var frame = wp.media({ title: 'Seleziona File', button: { text: 'Usa questo file' }, multiple: false });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                row.find('.file-id').val(attachment.id);
                row.find('.file-url').text(attachment.filename);
            }).open();
        });

        $('#add-file-row').on('click', function() {
            var index = $('#tabella-allegati tbody tr').length;
            var newRow = `<tr>
                <td>
                    <input type="hidden" name="attachments[${index}][file_id]" value="" class="file-id">
                    <span class="file-url">Nessun file selezionato</span>
                    <button type="button" class="button select-file">Seleziona File</button>
                </td>
                <td><input type="text" name="attachments[${index}][desc]" value="" class="large-text"></td>
                <td style="text-align: center;">0</td>
                <td><button type="button" class="button remove-row">×</button></td>
                <input type="hidden" name="attachments[${index}][count]" value="0">
            </tr>`;
            $('#tabella-allegati tbody').append(newRow);
        });

        $('#tabella-allegati').on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
        });
    });
    </script>
    <?php
}

function arianna_components_save_attachments($post_id) {
    if (!isset($_POST['attachments_nonce']) || !wp_verify_nonce($_POST['attachments_nonce'], 'salva_attachments_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['attachments']) && is_array($_POST['attachments'])) {
        $sanitized_data = [];
        foreach ($_POST['attachments'] as $item) {
            if (!empty($item['file_id'])) {
                $sanitized_data[] = [
                    'file_id' => intval($item['file_id']),
                    'desc'    => sanitize_text_field($item['desc']),
                    'count'   => intval($item['count'])
                ];
            }
        }
        update_post_meta($post_id, '_attachments', $sanitized_data);
    } else {
        delete_post_meta($post_id, '_attachments');
    }
}
add_action('save_post', 'arianna_components_save_attachments');

function arianna_components_download_attachment() {
    if (isset($_GET['file_id']) && isset($_GET['component_id'])) {
        $file_id = intval($_GET['file_id']);
        $post_id = intval($_GET['component_id']);

        $files = get_post_meta($post_id, '_attachments', true);

        foreach ($files as &$file) {
            if ($file['file_id'] == $file_id) {
                if(!isset($file['count'])) {
                    $file['count'] = 0;
                }
                $file['count']++;
                break;
            }
        }

        update_post_meta($post_id, '_attachments', $files);

        wp_redirect(wp_get_attachment_url($file_id));
        exit;
    }
}
add_action('template_redirect', 'arianna_components_download_attachment');

function arianna_components_get_download_count($component_id) {
    $downloads = 0;
    $files = get_post_meta($component_id, '_attachments', true);
    foreach ($files as $file) {
        $downloads += intval($file['count']);
    }
    return $downloads;
}