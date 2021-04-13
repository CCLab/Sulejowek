<?php

date_default_timezone_set('Europe/Warsaw');

/*** Tłumaczenia ***/
add_action('after_setup_theme','sul_translate_theme');
function sul_translate_theme() {
     load_theme_textdomain( 'sul', get_template_directory() . '/languages' );
}

/** Breakpointy **/
$content_width = 1024;
global $evLargeBreakpoint;
$evLargeBreakpoint = 1024;
global $evMaxWidth;
$evMaxWidth = 1920;

/***** Czyszczenie nagłówka z wordpressowych śmieci *****/
add_action('after_setup_theme', 'sul_usun_z_naglowka');
function sul_usun_z_naglowka () {

    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

    add_filter('the_generator', '__return_false');

    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );

    remove_action('set_comment_cookies', 'wp_set_comment_cookies');

    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    add_filter( 'embed_oembed_discover', '__return_false' );

    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

    //add_filter('rest_enabled', '__return_false');
    add_filter('rest_jsonp_enabled', '__return_false');
}

/*** Style i skrypty ***/
add_action('wp_enqueue_scripts', 'sul_scripts', 50);
function sul_scripts() {

    wp_register_script( 'swiper', get_template_directory_uri() . '/dependencies/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script( 'swiper' );

	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/js/scripts.min.js', null, '0.0.63', true);

    wp_deregister_script( 'jquery' );

}

add_action('wp_enqueue_scripts', 'sul_styles', 1000);
function sul_styles() {

    wp_register_style('normalize', get_template_directory_uri() . '/dependencies/normalize.css', array(), null, null);
	wp_enqueue_style('normalize');

	wp_register_style('style', get_template_directory_uri() . '/style.min.css', array(), '1.0.12', null);
	wp_enqueue_style('style');
    
    /*wp_register_style('audio', 'https://cdn.plyr.io/3.6.2/plyr.css', array(), '3.6.2', null);
	wp_enqueue_style('audio');*/
    
    //wp_register_style('swiper', get_template_directory_uri() . '/css/swiper.min.css', array(), '6.0.4', null);
    //wp_enqueue_style('swiper');
    
    wp_dequeue_style( 'wp-block-library' );
    wp_deregister_style( 'wp-block-library' );
    
    wp_deregister_style( 'mediaelement' );
    
}

/*** Dodawanie Wordpressowych funkcjonalności **/
add_action('after_setup_theme', 'sul_manage_theme_support');
function sul_manage_theme_support () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'gallery', 'caption', 'search-form' ) );
	add_theme_support( 'disable-custom-font-sizes' );
	add_theme_support( 'disable-custom-colors' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-color-palette', array() );
}


function ev_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
}
add_action('init', 'ev_unregister_taxonomy');



/* Linki do profili społecznościowych */

//add_filter('admin_init', 'my_general_settings_register_fields');
 
function my_general_settings_register_fields()
{
    register_setting('general', 'facebook_url', 'esc_url');
    add_settings_field('facebook_url', '<label for="facebook_url">Adres strony na Facebooku</label>' , 'my_general_settings_fields_facebook_url_html', 'general');
    register_setting('general', 'instagram_url', 'esc_url');
    add_settings_field('instagram_url', '<label for="instagram_url">Adres strony na Instagramie</label>' , 'my_general_settings_fields_instagram_url_html', 'general');
}
function my_general_settings_fields_facebook_url_html()
{
    $value = get_option( 'facebook_url', '' );
    echo '<input type="text" id="facebook_url" name="facebook_url" class="regular-text" value="' . $value . '" />';
}
function my_general_settings_fields_instagram_url_html()
{
    $value = get_option( 'instagram_url', '' );
    echo '<input type="text" id="instagram_url" name="instagram_url" class="regular-text" value="' . $value . '" />';
}

// Aktywacja linków nadrzędnych w menu
function sul_nav_classes( $classes, $item ) {
    if( !is_home() && !is_singular( 'post' ) && $item->object == 'page' && $item->object_id == get_option( 'page_for_posts' ) ){
        $classes = array_diff( $classes, array( 'current-menu-item' ) );
    }
    if( is_singular( ) && $item->type == 'post_type_archive' && $item->object == get_post_type() ){
        $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'sul_nav_classes', 10, 2 );

/*** Nawigacja ***/
function sul_nav_menu() {
   register_nav_menus(
        array(
          'menu-glowne' => __( 'Menu główne' )
        )
    );
}
add_action( 'init', 'sul_nav_menu' );