<?php
/**
 * Notify administrators when a post of a specific type is created or updated.
 */

function arianna_notify_admins( $post_id, $post, $update ) {

    $post_types = ['kit', 'component', 'post'];

    // Ignore autosave and revisions
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( wp_is_post_revision( $post_id ) ) return;

    // Check if the post type is one of the specified types
    if ( ! in_array( $post->post_type, $post_types ) ) return;

    // Check that the post is published
    if ( $post->post_status !== 'publish' ) return;

    // Get all administrators
    $admins = get_users( [ 'role' => 'administrator' ] );
    $emails = array_map( fn( $u ) => $u->user_email, $admins );

    if ( empty( $emails ) ) return;

    // Get user info
    $user = wp_get_current_user();

    // Prepare email
    $action       = $update ? 'modificato' : 'creato';
    $post_title   = get_the_title( $post_id );
    $post_link    = get_permalink( $post_id );
    $edit_link    = get_edit_post_link( $post_id, 'raw' );

    $subject = "[Arianna] - {$action} {$post_title}";

    $body = "Ciao,<br><br>";
    $body .= "L'utente \"{$user->display_name}\" ha {$action} un post.<br><br>";
    $body .= "Titolo: {$post_title}<br>";
    $body .= "Visualizza: <a href=\"{$post_link}\">{$post_link}</a><br>";
    $body .= "Modifica: <a href=\"{$edit_link}\">{$edit_link}</a><br><br>";
    $body .= "-- Arianna Project";

    $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

    wp_mail( $emails, $subject, $body, $headers );
}

add_action( 'save_post', 'arianna_notify_admins', 10, 3 );