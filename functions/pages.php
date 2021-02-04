<?php /*** Strony ***/

add_action('init', 'everspace_remove_page_thumbnails');
function everspace_remove_page_thumbnails() {
	remove_post_type_support( 'page', 'page-attributes' );
	remove_post_type_support( 'page', 'custom-fields' );
	//remove_post_type_support( 'page', 'editor' );
	remove_post_type_support( 'page', 'author' );
	add_post_type_support( 'post', 'excerpt' );
    remove_post_type_support( 'page', 'thumbnail' );
}


add_filter( 'tiny_mce_before_init', 'tiny_mce_remove_unused_formats', 10, 2 );
function tiny_mce_remove_unused_formats( $initFormats, $editor_id ) {
	if ( strpos($editor_id, 'sekcjecontent') === false ){
		return $initFormats;
	}
	$initFormats['block_formats'] = 'Śródtytuł=h3';
	return $initFormats;
}
add_filter('mce_buttons', 'myformatTinyMCE' );
function myformatTinyMCE($in) {

	$in=array('styleselect,formatselect,bold,italic,link,unlink,bullist,numlist');
	return $in;

}

add_action( 'cmb2_admin_init', 'sul_page_metaboxes' );
function sul_page_metaboxes() {
    /* Sidebar */
    $cmb = new_cmb2_box(array(
            'title'        => __( 'Sidebar', 'sul' ),
            'id'           => 'page_sidebar',
			'object_types' => array( 'page' ),
			'context'      => 'normal',
            'show_names'   => true
		)
	);
    
	$cmb->add_field( array(
		'id'      => '_side_title',
		'name'    => __( 'Nagłówek', 'sul' ),
		'type'    => 'text',

	) );

    $cmb->add_field(array
    (
		'name' => __( 'Treść', 'sul' ),
		'id'   => '_side_content',
		'type' => 'wysiwyg',
		'options' => array(
			'media_buttons' => false,
			'textarea_rows' => get_option('default_post_edit_rows', 10),
			'tabindex' => 4,
			'tinymce' => array(
				'toolbar1' => 'bold,italic,|,undo,redo',
				'toolbar2' => false
			),
			'quicktags' => false
		),
    ));
}