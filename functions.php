<?php

// =========== THEME SUPPORT ===========
function arianna_theme_support() {
    // Adds dynamic title tag support
    add_theme_support('title-tag');

    add_theme_support('post-thumbnails');
}

add_action('after_setup_theme', 'arianna_theme_support');

// =========== THEME INITIALIZATION ===========
function arianna_create_downloads_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'downloads_log';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        file_name varchar(255) NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'arianna_create_downloads_table');

add_action('after_setup_theme', 'arianna_create_downloads_table');


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

    if(is_front_page() || is_404()) {
        wp_enqueue_style('arianna-front-page-style', get_template_directory_uri() . '/assets/css/styleIndex.css', array(), $version, 'all');
    }

    if(is_page('team')) {
        wp_enqueue_style('arianna-team-page-style', get_template_directory_uri() . '/assets/css/styleTeam.css', array(), $version, 'all');
    }

    if(is_page('gallery')) {
        wp_enqueue_style('arianna-gallery-page-style', get_template_directory_uri() . '/assets/css/styleGallery.css', array(), $version, 'all');
    }

    if(is_page('news')) {
        wp_enqueue_style('arianna-news-page-style', get_template_directory_uri() . '/assets/css/styleAggiornamenti.css', array(), $version, 'all');
    }

    if(is_page('download')) {
        wp_enqueue_style('arianna-download-page-style', get_template_directory_uri() . '/assets/css/styleDownload.css', array(), $version, 'all');
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

function arianna_create_gallery_image_post_type() {
    register_post_type('gallery_images',
        array(
            'labels' => array(
                'name' => 'Immagini della Galleria',
                'singular_name' => 'Immagine',
                'add_new' => 'Aggiungi Immagine',
                'add_new_item' => 'Aggiungi Nuova Immagine',
                'edit_item' => 'Modifica Immagine',
                'all_items' => 'Immagini della Galleria'
            ),
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true, // Per usare l'editor Gutenberg
            'show_in_menu' => 'arianna-contents',
        )
    );
}
add_action('init', 'arianna_create_gallery_image_post_type');

// Aggiungi il meta box
function arianna_add_gallery_image_meta_post() {
    add_meta_box(
        'image_orientation',
        'Orientamento Immagine',
        'arianna_show_image_orientation_metabox',
        'gallery_images',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'arianna_add_gallery_image_meta_post');

// Mostra il contenuto del meta box
function arianna_show_image_orientation_metabox($post) {
    // Recupera il valore salvato
    $valore = get_post_meta($post->ID, '_image_orientation', true);
    
    // Nonce per sicurezza
    wp_nonce_field('save_image_orientation', 'image_orientation_nonce');
    
    ?>
    <label for="image_orientation">Seleziona orientamento:</label>
    <select name="image_orientation" id="image_orientation" style="width: 100%; margin-top: 10px;">
        <option value="landscape" <?php selected($valore, 'landscape'); ?>>Orizzontale</option>
        <option value="portrait" <?php selected($valore, 'portrait'); ?>>Verticale</option>
    </select>
    <?php
}

// Salva il valore quando si salva il post
function arianna_save_gallery_image_post($post_id) {
    // Verifica nonce
    if (!isset($_POST['image_orientation_nonce']) || !wp_verify_nonce($_POST['image_orientation_nonce'], 'save_image_orientation')) {
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
    if (isset($_POST['image_orientation'])) {
        update_post_meta($post_id, '_image_orientation', sanitize_text_field($_POST['image_orientation']));
    }
}
add_action('save_post', 'arianna_save_gallery_image_post');


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


function arianna_add_menu_download_page() {
    add_menu_page(
        'Log Download',
        'Log Download',
        'manage_options',
        'downloads',
        'arianna_downloads_page',
        'dashicons-download',
        30
    );
}
add_action('admin_menu', 'arianna_add_menu_download_page');

function arianna_downloads_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'downloads_log';
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC");
    
    ?>
    <div class="wrap">
        <h1>Log Download</h1>
        <p>
            <a href="<?php echo admin_url('admin.php?page=downloads&esporta_csv=1'); ?>" 
               class="button button-primary">
                <span class="dashicons dashicons-download" style="margin-top: 3px;"></span> 
                Esporta in CSV
            </a>
        </p>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>File</th>
                    <th>Data Download</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results) : ?>
                    <?php foreach ($results as $row) : ?>
                        <tr>
                            <td>#<?php echo $row->id; ?></td>
                            <td><a href="mailto:<?php echo esc_html($row->email); ?>"><?php echo esc_html($row->email); ?></a></td>
                            <td><?php echo esc_html($row->file_name); ?></td>
                            <td><?php echo $row->date; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="4">Nessun download registrato</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function arianna_manage_download_form() {
    if (isset($_POST['download_email']) && isset($_POST['file_id'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'download_emails';
        
        $email = sanitize_email($_POST['download_email']);
        $file_id = sanitize_text_field($_POST['file_id']);
        
        if (is_email($email)) {
            // Salva nel database
            $wpdb->insert(
                $table_name,
                array(
                    'email' => $email,
                    'file_name' => $file_id
                )
            );
            
            // Avvia il download
            $file_path = get_attached_file($file_id);
            
            if (file_exists($file_path)) {
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            }
        }
    }
}
add_action('init', 'arianna_manage_download_form');

function arianna_export_downloads_log_csv() {
    // Verifica che sia la pagina giusta e che l'utente abbia i permessi
    if (isset($_GET['esporta_csv']) && current_user_can('manage_options')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'downloads_log';
        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC", ARRAY_A);
        
        // Imposta gli header per il download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=download-emails-' . date('Y-m-d') . '.csv');
        
        // Crea l'output
        $output = fopen('php://output', 'w');
        
        // Aggiungi BOM per Excel (per caratteri accentati)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Intestazioni colonne
        fputcsv($output, array('ID', 'Email', 'File', 'Data Download'), ';');
        
        // Dati
        if ($results) {
            foreach ($results as $row) {
                fputcsv($output, array(
                    $row['id'],
                    $row['email'],
                    $row['file_name'],
                    $row['date']
                ), ';');
            }
        }
        
        fclose($output);
        exit;
    }
}
add_action('admin_init', 'arianna_export_downloads_log_csv');