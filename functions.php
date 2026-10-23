
<?php
/**
 * Appverse Child Theme functions.
 */

/* ACTION 1: Enqueue parent and child styles. */
function appverse_child_enqueue_styles() {
    wp_enqueue_style(
        'appverse-parent-style',
        get_parent_theme_file_uri('style.css'),
        array(),
        wp_get_theme(get_template())->get('Version')
    );

    wp_enqueue_style(
        'appverse-child-style',
        get_stylesheet_uri(),
        array('appverse-parent-style'),
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'appverse_child_enqueue_styles');


/* ACTION 2: Add theme support. */
function appverse_child_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'appverse_child_setup');


/* ACTION 3: Register the custom role. */
function appverse_register_content_assistant() {
    if (!get_role('content_assistant')) {
        add_role(
            'content_assistant',
            'Content Assistant',
            array(
                'read'                 => true,
                'edit_posts'           => true,
                'edit_published_posts' => true,
                'upload_files'         => true,
            )
        );
    }
}
add_action('init', 'appverse_register_content_assistant');


/* ACTION 4: Display a footer message. */
function appverse_child_footer_message() {
    echo '<p class="appverse-footer-note">';
    echo esc_html('Developed for the Appverse WordPress Task 3.');
    echo '</p>';
}
add_action('wp_footer', 'appverse_child_footer_message');


/* ACTION 5: Display an admin notice. */
function appverse_child_admin_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }

    echo '<div class="notice notice-success is-dismissible">';
    echo '<p>' . esc_html('Appverse Child Theme is active.') . '</p>';
    echo '</div>';
}
add_action('admin_notices', 'appverse_child_admin_notice');


/* FILTER 1: Set excerpt length. */
function appverse_child_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'appverse_child_excerpt_length', 999);


/* FILTER 2: Customize the homepage document title. */
function appverse_child_document_title($title) {
    if (is_front_page()) {
        $title['title'] = 'Appverse WordPress Task 3';
    }

    return $title;
}
add_filter('document_title_parts', 'appverse_child_document_title');


/* FILTER 3: Add a custom body CSS class. */
function appverse_child_body_class($classes) {
    $classes[] = 'appverse-custom-site';
    return $classes;
}
add_filter('body_class', 'appverse_child_body_class');
