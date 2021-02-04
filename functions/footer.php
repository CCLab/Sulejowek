<?php

add_action( 'cmb2_admin_init', 'sul_stopka_ustawienia' );
function sul_stopka_ustawienia() {

    $prefix = sul_get_language_prefix();
    
	$cmb = new_cmb2_box( array(
		'id'           => 'sul_footer',
		'title'        => __('Ustawienia stopki i innych treści', 'sul'),
		'object_types' => array( 'options-page' ),
		'option_key'      => $prefix . 'sul_footer', // The option key and admin menu page slug.
		'menu_title'      => __('Stopka i inne', 'sul'),
		//'parent_slug'     => "edit.php?post_type=kontakt", // Make options page a submenu item of the themes menu.
		'capability'      => 'publish_pages', // Cap required to view options-page.
        'icon_url'        => 'dashicons-download',
        'position'        => 20,
        'vertical_tabs' => true, // Set vertical tabs, default false
        'tabs' => array(
            array(
                'id'    => 'info',
                'title' => 'Info o projekcie',
                'fields' => array(
                    'info_title',
                    'info_content'
                ),
            ),
            array(
                'id'    => 'info_main',
                'title' => 'Info na stronie głównej',
                'fields' => array(
                    'info_main'
                ),
            ),
            array(
                'id'    => 'email',
                //'icon' => 'dashicons-email',
                'title' => 'Email',
                'fields' => array(
                    'email_title',
                    'email_content'
                ),
            ),
            array(
                'id'    => 'newsletter',
                //'icon' => 'dashicons-email',
                'title' => __('Newsletter'),
                'fields' => array(
                    'newsletter_title',
                    'newsletter_content'
                ),
            ),
            array(
                'id'    => 'logotypy',
                //'icon' => 'dashicons-admin-site',
                'title' => __('Logotypy', 'sul'),
                'fields' => array(
                    'logotypy_title',
                    'logotypy'
                ),
            ),
            array(
                'id'    => 'mkidn',
                //'icon' => 'dashicons-admin-site',
                'title' => __('MKiDN', 'sul'),
                'fields' => array(
                    'mkidn_logo',
                    'mkidn_tekst',
                    'mkidn_url'
                ),
            ),
            array(
                'id'    => 'columns',
                //'icon' => 'dashicons-admin-site',
                'title' => __('Teksty w stopce', 'sul'),
                'fields' => array(
                    'left_column',
                    'right_column'
                ),
            ),
        )
	) );

    /* Info pod kafelkami */

    $cmb->add_field( array(
		'name' => __('Info pod kafelkami na stronie głównej', 'sul'),
		'id'   => 'info_main',
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

    /* Info w sidebarze w archiwum */

    $cmb->add_field( array(
		'name' => __('Info o projekcie', 'sul'),
		'id'   => 'info_title',
		'type' => 'text',
	) );

    $cmb->add_field( array(
		'name' => __('Email'),
		'id'   => 'info_content',
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
    
    
    /* Info w stopce */
    $cmb->add_field( array(
		'name' => __('Nagłówek', 'sul'),
		'id'   => 'email_title',
		'type' => 'text',
	) );

    $cmb->add_field( array(
		'name' => __('Email'),
		'id'   => 'email_content',
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
    
    /* Newsletter */
    $cmb->add_field( array(
		'name' => __('Nagłówek', 'sul'),
		'id'   => 'newsletter_title',
		'type' => 'text',
	) );

    $cmb->add_field( array(
		'name' => __('Email'),
		'id'   => 'newsletter_content',
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
    
    
    /* Logotypy */
    $cmb->add_field( array(
		'name' => __('Nagłówek', 'sul'),
		'id'   => 'logotypy_title',
		'type' => 'text',
	) );
	
    $group_field_id = $cmb->add_field( array(
		'id'          => 'logotypy',
		'type'        => 'group',
		'repeatable'  => true,
		'options'     => array(
			'group_title'       => __( 'Logotyo {#}', 'greenzoo' ), // since version 1.1.4, {#} gets replaced by row number
			'add_button'        => __( 'Dodaj logotyp', 'greenzoo' ),
			'remove_button'     => __( 'Usuń logotyp', 'greenzoo' ),
			'sortable'          => true,
			'closed'         => false, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Logotyp',
		'id'   => 'img',
		'type' => 'file',
        'options' => array(
            'url' => false,
        ),
		'preview_size' => array( 200, 200 ),
        'query_args' => array(
            'type' => array(
                'image/png',
                'image/svg',
                'image/svg+xml'
            ),
        ),
		'text' => array(
			'add_upload_file_text' => 'Wybierz lub wyślij plik na serwer',
			'remove_image_text' => 'Usuń grafikę',
			'file_text' => 'Plik:',
			'file_download_text' => 'Pobierz',
			'remove_text' => 'Usuń',
		)
	) );
    $cmb->add_group_field( $group_field_id, array(
		'name' => __('Opis', 'sul'),
		'id'   => 'desc',
		'type' => 'textarea_small',
	) );
	$cmb->add_group_field( $group_field_id, array(
		'name' => 'Odnośnik',
		'id'   => 'permalink',
		'type' => 'text_url',
	) );
    
    
    
    /* Kolumny tekstowe w stopce */

    $cmb->add_field( array(
		'name' => __('Lewa kolumna', 'sul'),
		'id'   => 'left_column',
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
    
    $cmb->add_field( array(
		'name' => __('Prawa kolumna', 'sul'),
		'id'   => 'right_column',
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
    
    /* MKiDN */
    $cmb->add_field( array(
		'name' => 'Logotyp',
		'id'   => 'mkidn_logo',
		'type' => 'file',
        'options' => array(
            'url' => false,
        ),
		'preview_size' => array( 200, 200 ),
        'query_args' => array(
            'type' => array(
                'image/png',
                'image/svg',
                'image/svg+xml'
            ),
        ),
		'text' => array(
			'add_upload_file_text' => 'Wybierz lub wyślij plik na serwer',
			'remove_image_text' => 'Usuń grafikę',
			'file_text' => 'Plik:',
			'file_download_text' => 'Pobierz',
			'remove_text' => 'Usuń',
		)
	) );
    
    $cmb->add_field( array(
		'name' => 'Odnośnik',
		'id'   => 'mkidn_url',
		'type' => 'text_url',
	) );
    
    $cmb->add_field( array(
		'name' => __('Tekst', 'sul'),
		'id'   => 'mkidn_tekst',
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

function sul_get_footer_settings() {
    $prefix = sul_get_language_prefix();
    $settings = get_option($prefix . 'sul_footer');
    return $settings ?? false;
}