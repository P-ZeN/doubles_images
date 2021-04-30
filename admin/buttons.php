<?php

// hooks your functions into the correct filters
function dblimgs_add_mce_button() {
    global $typenow, $pagenow;

    if (empty($typenow) && !empty($_GET['post']) ) {
        $post = get_post( $_GET['post'] );
        $typenow = $post->post_type;
    }

    $curpage = $pagenow . 'post-new.php?post_type=' . $typenow;

        // check user permissions
    if ( !current_user_can( 'edit_posts' ) &&  !current_user_can( 'edit_pages' ) ) {
            return;
    }
    // check if WYSIWYG is enabled
    //if ( 'true' == get_user_option( 'rich_editing' ) ) {
    function mce_show_toolbar( $args ) {
        $args['wordpress_adv_hidden'] = false;
        return $args;
    }
    add_filter( 'tiny_mce_before_init', 'mce_show_toolbar' );
    add_filter( 'mce_external_plugins', 'dblimgs_add_tinymce_plugin' );
    add_filter( 'mce_buttons_2', 'dblimgs_register_mce_button' );
    //}
}
add_action('admin_head', 'dblimgs_add_mce_button');

// register new button in the editor
function dblimgs_register_mce_button( $buttons ) {
    $buttons = array(
        'dblimgs_mce_button',
    );
    return $buttons;
}


// declare a script for the new button
// the script will insert the shortcode on the click event
function dblimgs_add_tinymce_plugin( $plugin_array ) {
    $plugin_array['dblimgs_mce_button'] = DBLIMGS_PLUGIN_URL . 'admin/dblimgs_buttons.js';
    return $plugin_array;
}