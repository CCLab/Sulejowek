<?php get_header(); ?>

<main id="main">

    <header class="sul-term-header adres"><div class="container"><div class="grid">
    <?php
    
		$term = get_queried_object();
        $next = get_adjacent_term( $term->slug, $term->taxonomy, "next" );
        $prev = get_adjacent_term( $term->slug, $term->taxonomy ,"previous" );

    ?>
        <div class="col-12 col-lg-6 offset-lg-3">
            <h1 class="title"><?php echo $term->name; ?></h1>
        </div>
        <div class="description col-8 offset-2 col-lg-6 offset-lg-3">
            <?php echo apply_filters( 'the_content', $term->description ); ?>
        </div>

        <?php if( $next ) : ?>
            <a class="next col-3 offset-2 offset-md-0" href="<?php echo get_term_link($next); ?>">
                <span class="visibly-hidden-small text">
                    <?php _e('Następny adres', 'sul'); ?><span><?php echo $next->name; ?></span>
                    <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
                </span>
            </a>
        <?php endif; ?>
        
        <?php if( $prev ) : ?>
            <a class="prev col-3" href="<?php echo get_term_link($prev); ?>">
                <span class="visibly-hidden-small text">
                    <?php _e('Poprzedni adres', 'sul'); ?><span><?php echo $prev->name; ?></span>
                    <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
                </span>
            </a>
        <?php endif; ?>



    </div></div></header>


    <?php 


    if(have_posts()) :

        /** GALERIA **/

        while(have_posts()) : the_post();

            $rodzaj = get_post_meta( get_the_ID(), '_rodzaj', 1 );

            if ( $rodzaj == 1 ) {

                if( has_post_thumbnail() ) {

                    $id = get_post_thumbnail_id();

                    $zdjecia[ $id ] = array(
                        'id' => $id,
                        'title' => get_post_meta( get_the_ID(), '_desc', 1 )
                    );

                }

            } else {
                $relacje_ids[ ] = get_the_ID();
            }

        endwhile;

        if( isset( $zdjecia ) ) { ?>

            

            <div class="container"><div class="grid"><div class="col-12">
            <?php echo sul_gallery( $zdjecia ); ?>
            </div></div></div>
        <?php }



        /** RESZTA **/

        $nieostatni = false;
    
        ?>


        <div class="sul-archive adres<?php if( !$nieostatni) echo ' ostatni'; ?>">

            <div class="container"><div class="grid align-start">
                <div class="col-12 col-lg-8 sul-archive-main">

                    <?php

                    $ile = 0;
                    $max = 6;
                    while(have_posts()) : the_post();

                        $rodzaj = get_post_meta( get_the_ID(), '_rodzaj', 1 );
                        $autorzyRelacji = wp_get_post_terms( get_the_ID(), 'autor', array('fields' => 'ids') );

                        if( $rodzaj != 1 ) {

                            $ile++;

                            if( $ile == $max + 1 ) echo '<div class="hidden collapsable" id="sul-hide">';

                            get_template_part( 'parts/item', get_post_meta( get_the_ID(), '_rodzaj', 1 ) );
                            
                            
                        }
                    endwhile;

                    if( $ile > $max ) : echo '</div>'; ?>

                    <div class="show-more-wrapper">
                        <button type="button" class="unbutton show-more" data-toggle="collapse" aria-controls="sul-hide" aria-expanded="false" aria-label="<?php echo sprintf(__('Czytaj więcej (jeszcze %s fragmenty)', 'sul'), ( $ile - $max )); ?>">
                            <?php 
                            
                            
                            //echo sprintf(__('Czytaj więcej (jeszcze %s fragmenty)', 'sul'), ( $ile - $max )); 
                            
                            printf( _n( 'Czytaj więcej (jeszcze jeden fragment)', 'Czytaj więcej (jeszcze %1$s fragmenty)', ( $ile - $max ), 'sul' ), number_format_i18n( ( $ile - $max ) ));
                            
                            
                            ?>
                        </button>
                    </div>

                    <?php endif; ?>

                </div>

                <div class="col-12 col-lg-3 offset-lg-1 sul-sidebar">
                    
                    <div class="wrapper info">

                        <?php $content = sul_get_footer_settings(); ?>
                        
                        <?php if( isset( $content['info_title'] ) ) echo '<h3 class="title">' . $content[ 'info_title' ] . '</h3><br />'; ?>
                        <?php if( isset( $content['info_content'] ) ) echo '<div class="content">' . apply_filters( 'the_content', $content[ 'info_content' ] ) . '</div>'; ?>
                        
                    
                    </div>
                    
                    

                <?php   

                    if( isset( $relacje_ids ) && $autorzy = wp_get_object_terms($relacje_ids, 'autor') ) foreach( $autorzy as $autor ) { ?>
                        
                    <div class="wrapper info">

                        <div class="sul-autor">
                            <div class="thumbnail">
                            <?php if( $thumbnail = get_term_meta( $autor->term_id, '_thumbnail_id', 1 ) ) : ?>
                                <?php echo wp_get_attachment_image( $thumbnail, 'thumbnail' ); ?>
                            <?php else: ?>
                                <div class="avatar">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/avatar.svg" />
                                </div>
                            <?php endif; ?>
                            </div>

                            <div class="name"><?php echo $autor->name; ?></div>

                            <div class="bio"><?php echo $autor->description; ?></div>

                        </div>

                        <?php

                        /*while(have_posts()) : the_post();

                            $rodzaj = get_post_meta( get_the_ID(), '_rodzaj', 1 );
                            $autorzyRelacji = wp_get_post_terms( get_the_ID(), 'autor', array('fields' => 'ids') );

                            if( $rodzaj == 3 && isset($autorzyRelacji) && in_array( $autor->term_id, $autorzyRelacji )) { ?>
                                <div class="item"><div class="content">
                                    <?php get_template_part( 'parts/item', 'audio' ); ?>
                                </div></div>
                            <?php }

                        endwhile;*/

                        ?>
                    </div>

                    <?php } ?>

                </div>

            </div></div>

        </div>


        <?php


    endif; ?>

    <footer class="sul-term-header footer adres"><div class="container"><div class="grid justify-space-between">
        <div class="col-12 col-lg-6 offset-lg-3">
            <div class="title szlaczek">&nbsp;</div>
        </div>

        <?php if( $prev ) : ?>
            <a class="prev col-6 col-md-3" href="<?php echo get_term_link($prev); ?>">
                <span class="visibly-hidden-small text">
                    <?php _e('Poprzedni adres', 'sul'); ?><span><?php echo $prev->name; ?></span>
                    <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
                </span>
            </a>
        <?php endif; ?>
        
        <?php if( $next ) : ?>
            <a class="next col-6 col-md-3" href="<?php echo get_term_link($next); ?>">
                <span class="visibly-hidden-small text">
                    <?php _e('Następny adres', 'sul'); ?><span><?php echo $next->name; ?></span>
                    <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
                </span>
            </a>
        <?php endif; ?>
        

    </div></div></footer>
    
    <div class="container adres">
        <?php 
            $lokalizacje = get_terms( array( 'taxonomy' => 'lokalizacja' ) );
        
            if( $lokalizacje ) {
                global $sul_lokalizacje;
                $sul_lokalizacje = $lokalizacje;
                
                get_template_part( 'parts/mapa' );
            }
        ?>
    </div>

</main>

<?php get_footer(); ?>