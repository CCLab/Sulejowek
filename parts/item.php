<?php

$rodzaj = get_post_meta( get_the_ID(), '_rodzaj', 1 );

if( is_tax('temat') ) {



    /*if( $autorzy = wp_get_post_terms( get_the_ID(), 'autor', array('fields' => 'id=>name') ) ) {

        foreach ( $autorzy as $key => &$term ) {
            $term = '<span>' . $term . '</span>';
        }
        $autorzy =  implode( ', ', $autorzy );
    }*/

    if( $lokalizacje = wp_get_post_terms( get_the_ID(), 'lokalizacja', array('fields' => 'id=>name') ) ) {

        foreach ( $lokalizacje as $key => &$term ) {
            $term = '<a href="' . get_term_link( $key, 'lokalizacja' ) . '">' . $term . '</a>';
        }
        $lokalizacje =  implode( ', ', $lokalizacje );
    }

    //$terms = ($autorzy ? $autorzy . ',<br> ' : '') . $lokalizacje;
    
    $terms = $lokalizacje ? $lokalizacje : '';
    
} else {
    
    if( $tematy = wp_get_post_terms( get_the_ID(), 'temat', array('fields' => 'id=>name') ) ) {

        foreach ( $tematy as $key => &$term ) {
            $term = '<a href="' . get_term_link( $key, 'temat' ) . '">' . $term . '</a>';
        }
        $tematy =  implode( ', ', $tematy );
    }

    $terms = $tematy ? $tematy : '';

}



?>


<div class="item">
    <div class="content typ-<?php echo $rodzaj; ?>" id="relacja-<?php echo get_the_ID(); ?>">
        <?php 
        
        if ( $rodzaj == 2 ) : 

            // Tekst
            if( $tekst = get_post_meta( get_the_ID(), '_text', 1 ) ) {
                
                $tekst = trim( $tekst );
                if (substr( $tekst, -1 ) == '.') {
                    echo apply_filters( 'the_content', '„' . rtrim( $tekst, '.' ) . '”.' );
                } else {
                    echo apply_filters( 'the_content', '„' . $tekst . '”' );                    
                }
            };

        elseif ( $rodzaj == 1 ) : 

            // Zdjęcie
            if( has_post_thumbnail() ) {
                echo '<p>';
                echo wp_get_attachment_image( get_post_thumbnail_id(), 'full' );
                if( $desc = get_post_meta( get_the_id(), '_desc', 1 ) ) {
                    echo '<span class="desc">' . $desc . '</span>';
                }
                echo '</p>';
            };

        elseif ( $rodzaj == 4 ) : 

            // Embed
            if( $url = get_post_meta( get_the_ID(), '_embed', 1 ) ) {

            
                if ( function_exists( 'cmb2_get_oembed' ) ) {
                    $iframe = cmb2_get_oembed( array('url' => $url, 'object_id' => get_the_id()) );
                } else {
                    $iframe = wp_oembed_get( esc_url( $url ) );
                }
                
                preg_match( '/width="(.*?)"/', $iframe, $width);
                preg_match( '/height="(.*?)"/', $iframe, $height);

                if( isset( $width[1], $height[1] ) ) {
                    
                    $padding = $height[1] / $width[1] * 100;
                    
                    $iframe = '<div class="responsive-embed" style="padding-top: ' . $padding . '%">' . $iframe . '</div>';
                }

                echo $iframe;

                if( $desc = get_post_meta( get_the_id(), '_desc', 1 ) ) {
                    echo '<span class="desc">' . $desc . '</span>';
                }
            };

        elseif ( $rodzaj == 3 ) : 

            // Audio
            get_template_part( 'parts/item', 'audio' );

        endif; 
        
        if( $autorzy = wp_get_post_terms( get_the_ID(), 'autor', array('fields' => 'id=>name') ) ) {

        foreach ( $autorzy as $key => &$term ) {
            $term = '<span>' . $term . '</span>';
        }
        echo '<p class="autorzy">' . implode( ', ', $autorzy ) . '</p>';
        echo edit_post_link(__('Edit'));
    }
        
    ?>
    </div>
    <div class="terms"><div><?php echo $terms; ?></div></div>
</div>