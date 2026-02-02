<?php

// Create the "Kit" custom post type
function arianna_kits_post_type()
{
    register_post_type("kits", [
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
add_action("init", "arianna_kits_post_type");