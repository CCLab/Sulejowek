<?php

// Dodanie cpt Spektakle, Warsztaty i Wydarzenia //
add_action( 'init', 'sul_register_post_type_relacja', 10 );
function sul_register_post_type_relacja() {

	$cpts = array(
		'relacja' => array(
			'label'	=> __( 'Relacja', 'sul' ),
			'labels' => array(
				'name'                  => __( 'Relacje', 'sul' ),
				'singular_name'         => __( 'Relacja', 'sul' ),
				'menu_name'             => __( 'Relacje', 'sul' ),
				'name_admin_bar'        => __( 'Relacje', 'sul' ),
			),
			'menu_icon' => 'dashicons-groups',
            'has_archive' => false
		)
	);

	$args = array(
		'supports'              => array( 'title', 'thumbnail' ),
		'public'                => true,
		'publicly_queryable'	=> false,
		'show_in_nav_menus'		=> false,
		'menu_position'         => 10,
		'show_in_rest' 			=> false
	);

    foreach($cpts as $slug => $cpt) {
        register_post_type( $slug, $cpt + $args );
    }

	$taxes = array(
		'autor' => array(
			'labels' => array(
				'name'                       => __('Autorzy', 'sul'),
				'singular_name'              => __('Autor', 'sul'),
				'menu_name'                  => __('Autorzy', 'sul'),
			),
            'public' => false,
            'show_ui'   => true
		),
		'temat' => array(
			'labels' => array(
				'name'                       => __('Tematy', 'sul'),
				'singular_name'              => __('Temat', 'sul'),
				'menu_name'                  => __('Tematy', 'sul'),
			)
		),
		'lokalizacja' => array(
			'labels' => array(
				'name'                       => __('Adresy', 'sul'),
				'singular_name'              => __('Adres', 'sul'),
				'menu_name'                  => __('Adresy', 'sul'),
			)
		),
	);

	$args = array(
		'hierarchical'               => false,
		'public'                     => true,
		'show_admin_column'          => true,
		'show_tagcloud'              => false,
        //'show_ui'                    => false,
		/*'capabilities'				 => array(
			'edit_terms' => 'manage_options',
			'manage_terms'	=> 'manage_options',
			'delete_terms'	=> 'manage_options',
			'assign_terms'	=> 'edit_posts'
		)*/
	);

	foreach($taxes as $slug => $tax) {
		register_taxonomy( $slug, array_keys($cpts), $tax + $args );
	}

}

function rudr_posts_taxonomy_filter() {
	global $typenow; // this variable stores the current custom post type
	if( $typenow == 'relacja' ){ // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
		$taxonomy_names = array('autor', 'lokalizacja');
		foreach ($taxonomy_names as $single_taxonomy) {
			$current_taxonomy = isset( $_GET[$single_taxonomy] ) ? $_GET[$single_taxonomy] : '';
			$taxonomy_object = get_taxonomy( $single_taxonomy );
			$taxonomy_name = strtolower( $taxonomy_object->labels->name );
			$taxonomy_terms = get_terms( $single_taxonomy );
			if(count($taxonomy_terms) > 0) {
				echo "<select name='$single_taxonomy' id='$single_taxonomy' class='postform'>";
				echo "<option value=''>All $taxonomy_name</option>";
				foreach ($taxonomy_terms as $single_term) {
					echo '<option value='. $single_term->slug, $current_taxonomy == $single_term->slug ? ' selected="selected"' : '','>' . $single_term->name .' (' . $single_term->count .')</option>'; 
				}
				echo "</select>";
			}
		}
	}
}
 
add_action( 'restrict_manage_posts', 'rudr_posts_taxonomy_filter' );

/* Zablokuj dostęp do pojedynczych tekstów */
add_action( 'wp', 'sul_ukryj_relacje' );
function sul_ukryj_relacje() {
    if( is_singular( 'relacja' ) ) {
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        die();
    }
}


/* Autorzy */
add_action( 'cmb2_admin_init', 'autorzy_metabox' ); 
function autorzy_metabox() {

    $cmb = new_cmb2_box( array( 
 		'id'               => 'autor_meta', 
 		'title'            => __( 'Zdjęcia', 'sul' ),
 		'object_types'     => array( 'term' ),
 		'taxonomies'       => array( 'autor' ),
 		'new_term_section' => true,
 	) );

    /* Thumbnail */
	$cmb->add_field( array(
		'id'      => '_thumbnail',
		'name'    => __( 'Zdjęcie', 'sul' ),
		'type'    => 'file',
		'options' => array(
			'url' => false,
		),
		'text' => array(
			'add_upload_file_text' => 'Add Image'
		),
        'query_args' => array(
            'type' => array(
                'image/jpeg'
            ),
        ),
        'column' => array(
            'position' => 3,
            'name'     => __( 'Zdjęcie', 'sul' ),
        ),
	) );
    
    $cmb->add_field(array
    (
		'name' => __( 'IMG', 'sul' ),
		'id'   => '_id',
		'type' => 'text',
        'column' => array(
            'position' => 10,
            'name'     => __( 'ID', 'sul' ),
        ),
		
    ));

}

add_filter('manage_edit-autor_columns', function ( $columns ) 
{
    if( isset( $columns['slug'] ) )
        unset( $columns['slug'] );

    return $columns;
} );



/* Adresy/Miejsca/Lokalizacje */

add_action( 'cmb2_admin_init', 'lokalizacje_metabox' ); 
function lokalizacje_metabox() {


    $cmb = new_cmb2_box( array( 
 		'id'               => 'lokalizacja_meta', 
 		'title'            => __( 'Współrzędne', 'sul' ),
 		'object_types'     => array( 'term' ),
 		'taxonomies'       => array( 'lokalizacja' ),
 		'new_term_section' => true,
 	) );


    /* Współrzędne geograficzne */
	$cmb->add_field( array(
        'before_row'      => '<p><strong>Współrzędne geograficzne</strong></p>',
		'id'      => 'lat',
		'name'    => __( 'Latitude', 'sul' ),
		'type'    => 'text_small',
	) );
	$cmb->add_field( array(
        'after_row'      => '<p><small>Odpowiednie dane można znaleźć na tej stronie: <a target="_blank" href="https://www.latlong.net/">latlong.net</a></small></p>',
		'id'      => 'lon',
		'name'    => __( 'Longitude', 'sul' ),
		'type'    => 'text_small',
	) );

}


/*** Style i skrypty ***/
add_action('wp_enqueue_scripts', 'sul_leaflet_scripts', 30);
function sul_leaflet_scripts() {

    wp_register_script( 'leaflet', get_template_directory_uri() . '/dependencies/leaflet.js', array(), '1.7.1', true);
    wp_enqueue_script( 'leaflet' );

}

add_action('wp_enqueue_scripts', 'sul_leaflet_styles', 40);
function sul_leaflet_styles()
{

	wp_register_style('leaflet', get_template_directory_uri() . '/dependencies/leaflet.css', array(), '1.7.1', null);
	wp_enqueue_style('leaflet');

}


/* Typ relacji */
add_filter( 'cmb2_show_on', 'sul_cmb_relacje_metabox_filter', 10, 3 );
function sul_cmb_relacje_metabox_filter( $display, $meta_box, $cmb ) {

    
	if ( !isset( $meta_box['show_on']['key'] ) || 'rodzaj' != $meta_box['show_on']['key'] ) {
		return $display;
	}

    $format = get_post_meta( $cmb->object_id(), '_rodzaj', 1 );

    
    if( (int) $format == (int) $meta_box['show_on']['value'] ) return $display;

    return false;
}

add_action( 'cmb2_admin_init', 'sul_relacje_metaboxes' );
function sul_relacje_metaboxes() {
	$cmb = new_cmb2_box(array(
			'id'           => 'rodzaj_relacji',
            'remove_box_wrap' => true,
			'object_types' => array( 'relacja' ),
			'context'      => 'after_title',
		)
	);
    
    $cmb->add_field(array
    (
        'id'      => '_rodzaj',
        'name'        => 'Rodzaj relacji',
        'description'   => 'Zaktualizuj żeby zobaczyć zmiany.',
        'type'    => 'select',
        'default'          => 2,
        'options'          => array(
            1   => 'Zdjęcie',
            2   => 'Tekst',
            3   => 'Nagranie audio/video',
            4   => 'Film z internetu',
        ),
        'column' => array(
            'position' => 3,
            'name'     => __( 'Rodzaj', 'sul' ),
        ),
    ));


    /* Zdjęcie */
    $cmb = new_cmb2_box(array(
            'title'        => __( 'Zdjęcie', 'sul' ),
            'id'           => 'zdjecie_relacja',
			'object_types' => array( 'relacja' ),
			'context'      => 'normal',
            'show_names'   => true,
			'show_on'      => array(
				'key'       => 'rodzaj',
				'value'     => 1
			),
		)
	);

	$cmb->add_field( array(
		'id'      => '_thumbnail',
		'name'    => __( 'Zdjęcie', 'sul' ),
		'type'    => 'file',
		'options' => array(
			'url' => false,
		),
        'query_args' => array(
            'type' => array(
                'image/jpeg'
            ),
        ),
        'column' => array(
            'position' => 10,
            'name'     => __( 'Zdjęcie', 'sul' ),
        ),
	) );
    /*$cmb->add_field(array
    (
		'name' => __( 'Thumbnail', 'sul' ),
		'id'   => '_thumbnail',
		'type' => 'textarea_small',
		
    ));
    $cmb->add_field(array
    (
		'name' => __( 'Thumbnail_id', 'sul' ),
		'id'   => '_thumbnail_id',
		'type' => 'textarea_small',
		
    ));*/

    $cmb->add_field(array
    (
		'name' => __( 'Podpis pod zdjęciem', 'sul' ),
        'description'   => 'Ten tekst wyświetli sie na stronie pod zdjęciem',
		'id'   => '_desc',
		'type' => 'wysiwyg',
		'type' => 'textarea_small',
    ));
    
    /* Tekst */
    $cmb = new_cmb2_box(array(
            'title'        => __( 'Tekst', 'sul' ),
            'id'           => 'tekst_relacja',
			'object_types' => array( 'relacja' ),
			'context'      => 'normal',
            'show_names'   => false,
			'show_on'      => array(
				'key'       => 'rodzaj',
				'value'     => 2
			),
            'column' => array(
                'position' => 2,
                'name'     => __( 'Opis', 'sul' ),
            ),
		)
	);
    
    $cmb->add_field(array
    (
		'name' => __( 'Tekst', 'sul' ),
		'id'   => '_text',
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

    /* Audio/Video */
    $cmb = new_cmb2_box(array(
            'title'        => __( 'Nagranie audio/video', 'sul' ),
            'id'           => 'audio_relacja',
			'object_types' => array( 'relacja' ),
			'context'      => 'normal',
            'show_names'   => false,
			'show_on'      => array(
				'key'       => 'rodzaj',
				'value'     => 3
			),
		)
	);
    
	$cmb->add_field( array(
		'id'      => '_audio',
		'name'    => __( 'Nagranie audio/video', 'sul' ),
		'type'    => 'file',
		'options' => array(
			'url' => false,
		),
        'query_args' => array(
            'type' => array(
                'audio/mpeg',
                'video/mp4'
            ),
        ),

	) );

    $cmb->add_field(array
    (
		'name' => __( 'Podpis', 'sul' ),
		'id'   => '_desc',
		'type' => 'textarea_small',
		'after_row' => 'nazwa_pliku_audio'
    ));
    
    /* Video */
    $cmb = new_cmb2_box(array(
            'title'        => __( 'Film z internetu', 'sul' ),
            'id'           => 'embed_relacja',
			'object_types' => array( 'relacja' ),
			'context'      => 'normal',
            'show_names'   => true,
			'show_on'      => array(
				'key'       => 'rodzaj',
				'value'     => 4
			),
		)
	);
    
	$cmb->add_field( array(
		'id'      => '_embed',
		'name'    => __( 'Adres url filmu', 'sul' ),
		'type'    => 'oembed',
        'after_row' => 'nazwa_pliku_video'
	) );

    $cmb->add_field(array
    (
		'name' => __( 'Podpis', 'sul' ),
		'id'   => '_desc',
		'type' => 'textarea_small',
    ));

}

function nazwa_pliku_audio( $field_args, $field ) {
    if( $file_name = get_post_meta( $field->object_id, '_img', 1 ) ) {
        echo 'Nazwa pliku do załączenia: ' . $file_name . '.mp3';
    }
}

function nazwa_pliku_video( $field_args, $field ) {
    if( $file_name = get_post_meta( $field->object_id, '_img', 1 ) ) {
        echo 'Nazwa pliku do załączenia: ' . $file_name . '.mp4';
    }
}


function sul_relacja_query( $query ) {

	if( $query->is_main_query() && !$query->is_feed() && !is_admin() && $query->is_tax( ) ) {

		$query->set( 'posts_per_page', -1);
        $query->set( 'post_type', array( 'relacja' ));
		$query->set( 'meta_key', '_rodzaj' );
        $query->set( 'meta_compare', 'EXISTS' );
        
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );

    }
}
add_action( 'pre_get_posts', 'sul_relacja_query' );


/* Następny / poprzedni term w taksonomii */
function get_adjacent_term( $slug, $taxonomy, $type ){
    global $wpdb;
    $p = $wpdb->prefix;

    if ($type=="next"){
        $operater=" > ";
        $orderby=" ORDER BY tt.`term_id` ASC ";
    } else {
        $operater=" < ";
        $orderby=" ORDER BY tt.`term_id` DESC ";
    }
    $query="SELECT *,(SELECT `term_id` FROM {$p}terms WHERE `slug`='$slug') AS given_term_id,
        (SELECT parent FROM {$p}term_taxonomy WHERE `term_id`=given_term_id) AS parent_id
        FROM  `{$p}terms` t
        INNER JOIN `{$p}term_taxonomy` tt ON (`t`.`term_id` = `tt`.`term_id`)
        HAVING  tt.taxonomy='$taxonomy' AND tt.`parent`=parent_id AND tt.`term_id` $operater given_term_id $orderby LIMIT 1";
    
    $term = $wpdb->get_row($query);
    
    if( !$term ) :
        $term = get_terms(
            array(
                'taxonomy' => $taxonomy,
                'orderby' => 'term_id',
                'number'    => 1,
                'order' => ( $type=="next" ) ? 'ASC' : 'DESC',
            )
        );
        if( $term ) $term = $term[0];
    endif;
    
    return $term;
}

/* $next_category =  get_adjacent_category($slug,$taxonomy,"next");
$previous_category =  get_adjacent_category($slug,$taxonomy,"previous"); */

/* Galeria */
function sul_gallery( $zdjecia ) {

    if( !$zdjecia ) return false;
    
    $ids = array_map(function ($zdjecie) { return $zdjecie['id']; }, $zdjecia);
    
    $posts = get_posts(array('include' => $ids,'post_type' => 'attachment'));
    
    if( $posts ) :

    $output = '';
    

    foreach($posts as $img){
        $output .= '<figure class="swiper-slide">' . wp_get_attachment_image( $img->ID, 'full' ); 
        $output .=  '<figcaption>' . apply_filters( 'the_content', $zdjecia[ $img->ID ][ 'title' ] ) . '</figcaption>';
        $output .=  '</figure>';
    }
    
    $output = '<div class="sul-gallery"><div class="swiper-container">'
        . '<div class="swiper-wrapper">' 
        . $output
        . '</div>
        </div>
        <div class="swiper-button-prev"><svg viewBox="0 0 29.7 135.8"><use xlink:href="' . get_template_directory_uri() . '/img/szlaczek-short-pion-lg.svg#swiperArrow" /></svg></div>
        <div class="swiper-button-next"><svg viewBox="0 0 29.7 135.8"><use xlink:href="' . get_template_directory_uri() . '/img/szlaczek-short-pion-lg.svg#swiperArrow" /></svg></div>
        <div class="container pagination"><div class="swiper-pagination"></div></div>
    </div>';
    
    endif;
    
    return $output;
}