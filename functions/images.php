<?php
/*** Open Graph ***/
add_action( 'customize_register', 'everspace_theme_customizer' );
function everspace_theme_customizer( $wp_customize ) {

	$wp_customize->add_setting( 'facebook_thumb', array(
		'capability'     => 'edit_theme_options',
		'type'           => 'theme_mod',
		'transport'   => 'postMessage'
	) );

	$wp_customize->add_control( 
		new WP_Customize_Image_Control( $wp_customize, 'facebook_thumb', array(
			'label'    => 'Miniaturka dla Facebooka',
			'section'  => 'title_tagline',
			'settings' => 'facebook_thumb',
		) )
   	);

    $wp_customize->add_setting( 'logo', array(
		'capability'     => 'edit_theme_options',
		'type'           => 'theme_mod',
		'transport'   => 'postMessage'
	) );
	$wp_customize->add_control( 
		new WP_Customize_Media_Control( $wp_customize, 'logo', array(
		    'mime_type' => 'image',
			'label'    => 'Logo',
			'section'  => 'title_tagline',
			'settings' => 'logo',
		) )
   	);
}

/*** Grafiki i ich rozmiary ***/
// Obrazki
add_action('after_setup_theme', 'everspace_images');
function everspace_images() {
	add_filter('max_srcset_image_width', function($max_srcset_image_width, $size_array){
		return 3000;
	}, 10, 2);
	if (function_exists('add_theme_support'))
	{

		add_image_size( 'medium', 850, '', true );
		add_image_size( 'large', 780, '', true );
		add_image_size( 'small', 683, '', true );
		add_image_size( 'base64', 3, '', true );

	}
}

// Funkcja dodaje wpis meta do obrazka zawierający string base64 z kilkupikselowym placeholderem
add_filter( 'wp_generate_attachment_metadata', 'everspace_img_placeholder_for_attachment', 10, 2 );
function everspace_img_placeholder_for_attachment($attmeta, $attachment_ID)
{
	$mime = get_post_mime_type( $attachment_ID );

	if( strpos($mime, 'image') === 0 && strpos($mime, 'svg') === FALSE )
	{

		$lgurl = dirname(get_attached_file( $attachment_ID ));
		$lgpath = $lgurl . '/' . $attmeta['sizes']['base64']['file'];

		$lgdata = file_get_contents($lgpath);
		if($lgdata)
		{
			$base64 = 'data:' . $mime . ';base64,' . base64_encode($lgdata);
			update_post_meta( $attachment_ID, '_base64', $base64 );			
		}
	}
	return $attmeta;
}


// finds the greatest common factor between two numbers
if(!function_exists('gmp_gcd')) {
	function gmp_gcd($num1, $num2) {
	   while ($num2 != 0){
		 $t = $num1 % $num2;
		 $num1 = $num2;
		 $num2 = $t;
	   }
	   return $num1;
	}
}
// Pokazuje img tag dla pełnoekranowego obrazka z object-fit: cover //
function everspace_mebel_swiper_image_width($imgID = false) {
	if($imgID) {

		$imageSRC = wp_get_attachment_image_src($imgID, 'medium');
		$aspect_ratio = $imageSRC[1]/$imageSRC[2];
		return ceil(25/$aspect_ratio) . 'vh';
	}
}
// Funkcja pozwala pobrać do srcset pliki większe niż nominalna wielkość w pikselach //
/* Ta funkcja nie jest już potrzebna */
function everspace_image_max_size($id, $sizes) {

  $mnoznik = 5;
  while ($mnoznik > 0) {
	$src =  wp_get_attachment_image_src($id, array($sizes[0]*$mnoznik, $sizes[1]*$mnoznik));
	if($src[3]) { // is intermediate
		break;
	}
	$mnoznik--;
  }
  return array($sizes[0]*$mnoznik, $sizes[1]*$mnoznik);
}

function everspace_fullscreen_sizes_attr($imgID = false) {
	if($imgID) {
		$imageSRC = wp_get_attachment_image_src($imgID, 'full');
		if($imageSRC) :
			$gcd = gmp_gcd($imageSRC[1], $imageSRC[2]);
			if($gcd == 0) {$gcd = 1;}
			$aspect_width = $imageSRC[1]/$gcd;
			$aspect_height = $imageSRC[2]/$gcd;
			$aspect_ratio = $aspect_width/$aspect_height;


			$sizes = '(min-aspect-ratio:' . $aspect_width . '/' . $aspect_height .') 100vw, ' . ceil($aspect_ratio*100) . 'vh"';
            return $sizes;
		endif;
	}
}