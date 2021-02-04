<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php 
	$fb_image = get_theme_mod( 'facebook_thumb' );
	if ( is_singular() && has_post_thumbnail() && !is_front_page() ) { ?>
	<meta property="og:image" content="<?php echo get_the_post_thumbnail_url($post, 'large' ) ?>">
	<?php } else if (!empty($fb_image)) { ?>
	<meta property="og:image" content="<?php echo $fb_image; ?>" />
	<?php }

	?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(''); ?>>


<a href="#main"><span class="screen-reader-text"><?php _e('Przejdź do treści', 'zs'); ?></span></a>

<header class="sul-header"><div class="container"><div class="wrapper">

    <a href="#menu" id="menu-button" class="menu-button"><span class="visibly-hidden">Menu</span></a>
    
    <a href="<?php echo get_bloginfo('wpurl'); ?>" class="brand">
        <span class="name"><?php bloginfo( 'name' ); ?></span>
        <span class="line"></span>
        <span class="tag-line"> <?php bloginfo( 'description' ); ?></span>
    </a>
    
    <?php wp_nav_menu( array(
        'theme_location'    => 'menu-glowne',
        'depth'             => 1,
        'container'         => '',
        'container_id'      => 'sul-nav',
        'menu_class'        => 'menu',
    ) ); ?>

</div></div></header>