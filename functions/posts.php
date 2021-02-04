<?php

// Replace Posts label as Articles in Admin Panel 
function sul_change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Biuletyn';
    $submenu['edit.php'][5][0] = 'Artykuły';
    $submenu['edit.php'][10][0] = 'Dodaj artykuł';
    echo '';
}
add_action( 'admin_menu', 'sul_change_post_menu_label' );

function sul_change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = __('Artykuły', 'biennale');
	$labels->singular_name = __('Artykuł', 'biennale');
	$labels->add_new = 'Dodaj artykuł';
	$labels->add_new_item = 'Dodaj artykuł';
	$labels->edit_item = 'Edytuj artykuł';
	$labels->new_item = 'Artykuł';
	$labels->view_item = 'Zobacz artykuł';
	$labels->search_items = 'Szukaj artykułu';
	$labels->not_found = 'Nie znaleziono artykułu';
	$labels->not_found_in_trash = 'Nie znaleziono artykułu w koszu';

	unregister_taxonomy_for_object_type('category', 'post');
    remove_post_type_support('post','thumbnail');
}
add_action( 'init', 'sul_change_post_object_label' );


add_action( 'cmb2_admin_init', 'sul_posts_ustawienia' );
function sul_posts_ustawienia() {

    $prefix = sul_get_language_prefix();
    
	$cmb = new_cmb2_box( array(
		'id'           => 'sul_biuletyn',
		'title'        => __('Wprowadzenie do biuletynu', 'sul'),
		'object_types' => array( 'options-page' ),
		'option_key'      => $prefix . 'sul_biuletyn', // The option key and admin menu page slug.
		'menu_title'      => __('Wprowadzenie', 'sul'),
        'parent_slug'     => "edit.php",
		'capability'      => 'publish_pages', // Cap required to view options-page.
	) );

    $cmb->add_field( array(
		'name' => __('Nagłówek', 'sul'),
		'id'   => 'title',
		'type' => 'text',
	) );

    $cmb->add_field( array(
		'name' => __('Treść'),
		'id'   => 'content',
		'type' => 'wysiwyg',
		'options' => array(
			'media_buttons' => false,
			'textarea_rows' => get_option('default_post_edit_rows', 10),
			'tabindex' => 4,
			'tinymce' => array(
				'toolbar1' => 'bold,italic,link,|,undo,redo',
				'toolbar2' => false
			),
			'quicktags' => false
		)
    ) );

}

function sul_get_biuletyn_settings() {
    $prefix = sul_get_language_prefix();
    $settings = get_option($prefix . 'sul_biuletyn');
    return $settings ?? false;
}