<?php

/***** Settings *****/
require_once get_template_directory() . '/functions/settings.php';

/***** Helpers *****/
require_once get_template_directory() . '/functions/helpers.php';

/***** Komentarze *****/
require_once get_template_directory() . '/functions/comments.php';

/***** Obrazki, media *****/
require_once get_template_directory() . '/functions/images.php';

/***** Posts *****/
require_once get_template_directory() . '/functions/posts.php';

/***** Strony *****/
require_once get_template_directory() . '/functions/pages.php';

/***** Relacje *****/
require_once get_template_directory() . '/functions/relacje.php';

/***** Stopka *****/
require_once get_template_directory() . '/functions/footer.php';

/***** Strona główna *****/
require_once get_template_directory() . '/functions/front.php';

function custom_dump($anything){
  add_action('shutdown', function () use ($anything) {
    echo "<pre style='position: absolute; z-index: 100; left: 30px; bottom: 30px; right: 30px; background-color: white;'>";
    var_dump($anything);
    echo "</pre>";
  });
}

function my_filter_post_exists() {
	return 0;
}
add_filter( 'wp_import_existing_post', 'my_filter_post_exists', 10, 0 );

add_action('wp_footer', 'grid_helper');
function grid_helper() {
	if ( isset($_GET['show-grid']) ) :
	?>

	
	<div class="helper-grid container"><div class="grid">
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
		<div class="col-1 col-md-1 col-lg-1">
		</div>
	</div></div>
    <style>
        .helper-grid {
        	position: fixed;
        	top: 0;
        	left: 0;
        	height: 100%;
			right: 0;
			z-index: 999;
			background-color: aliceblue;
			opacity: .2;
			pointer-events: none;
        }
        .helper-grid .grid {
        	height: 100%;
        }
        .helper-grid [class*="col-"] {
        	background-color: #768576;
        	background-clip: content-box;
        }

        /*.helper-grid [class*="col-"]:nth-child(odd) {
            background-color: pink;
        }*/
    </style>
<?php 
	endif;
}