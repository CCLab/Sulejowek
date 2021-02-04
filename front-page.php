<?php get_header(); ?>

<main id="main" class="front-page">


<?php 

    
$lokalizacje = get_terms( array( 'taxonomy' => 'lokalizacja' ) );

/** Adresy **/

if( $lokalizacje ) : 

    shuffle( $lokalizacje );

    $exclude = [];
    $slides = [];

    foreach( $lokalizacje as $key => $lokalizacja ) :

        $relacja_img = get_posts( array(
            'orderby' => 'rand',
            'posts_per_page' => 1,
            'post_type' => [ 'relacja' ],
            'post__not_in'  => $exclude,
            'fields'   => 'ids',
            'tax_query' => array(
                array(
                    'taxonomy' => 'lokalizacja',
                    'field'    => 'slug',
                    'terms'    => $lokalizacja->slug,
                ),
            ),
            'meta_query' => array(
                array(
                    'key' => '_rodzaj',
                    'value' => 1,
                    'compare'   => '=',
                    'type'  => 'NUMERIC'

                ),
                array(
                    'key'     => '_thumbnail_id',
                    'compare' => 'EXISTS'
                )
            )
        ));
        if( $relacja_img ) {

            $id = $relacja_img[0];
            $exclude[] = $id;

            $autor = implode( ', ', wp_get_post_terms( $id, 'autor', array( 'fields' => 'names' ) ) );

            $slides[] = array(
                'img' => get_the_post_thumbnail( $id, 'full' ),
                'title' => $lokalizacja->name,
                'autor' => $autor,
                'adres' => $lokalizacja->description,
                'permalink' => get_term_link( $lokalizacja->term_id, 'lokalizacja' )
            );
            
            if( count( $slides ) == 5 ) break;

        }
    

    endforeach;

endif;

if( $slides ) : 
    $slides = $slides + [false, false, false, false, false];
    
    $layout = 'layout-' . rand( 1, 4 );
    
    ?>

    

    <div class="container front">
        <div class="sul-gallery front-page"><div class="swiper-container">
            <div class="swiper-wrapper <?php echo $layout; ?>">

                <?php foreach( $slides as $slide ) : 

                    if( $slide ) { ?>
                        <figure class="swiper-slide sul-tile"><a href="<?php echo $slide[ 'permalink' ]; ?>" class="wrapper">

                            <?php echo $slide[ 'img' ]; ?>
                            <div class="adres"><span><?php echo $slide[ 'adres' ]; ?></span></div>
                            <div class="title"><span><?php echo $slide[ 'title' ]; ?></span></div>
                            <?php if(false) : ?><div class="autor"><span><?php echo $slide[ 'autor' ]; ?></span></div><?php endif; ?>

                        </a></figure>
                    <?php } else { ?>

                        <div class="tile"></div>

                    <?php } ?>

                <?php endforeach; ?>

            </div>
            </div>
            <div class="swiper-button-prev hide-it"></div>
            <div class="swiper-button-next hide-it"></div>
            <div class="container pagination hide-it"><div class="swiper-pagination"></div></div>
            <div class="front-test"></div>
        </div>
    </div>
    
<?php endif; ?>

    
    
    
<?php 
/* Info */
$content = sul_get_footer_settings();

if( $content && isset( $content[ 'info_main' ] ) ) : ?>
    <div class="container front"><div class="grid"><div class="col-12 col-lg-10 offset-lg-1">
        <div class="sul-random-relacja sul-intro-text">

            <div class="content">
                
                <?php echo apply_filters( 'the_content', $content[ 'info_main' ]); ?>
                
            </div>

        </div>
    </div></div></div>
    
<?php endif; ?>
    
    
    

<div class="container front">
    <div class="wrapper">
    <?php 


        if( $lokalizacje ) {
            global $sul_lokalizacje;
            $sul_lokalizacje = $lokalizacje;

            get_template_part( 'parts/mapa' );
        }
    ?>
    </div>
</div>

    
<?php 
    
/* Przypadkowa relacja */

$relacja = get_posts( array( 
    'orderby' => 'rand',
    'posts_per_page' => '1',
    'post_type' => [ 'relacja' ],
    'meta_key' => '_rodzaj',
    'meta_value' => 2,
    'meta_compare' => '=',
    'tax_query' => array(
        array(
            'taxonomy' => 'temat',
            'operator'  => 'EXISTS'
        )
    )
) );

if( $relacja ) : ?>
    <div class="container front"><div class="grid"><div class="col-12 col-lg-10 offset-lg-1">
        <div class="sul-random-relacja">

        <?php 
        $relacja = $relacja[0];
        $tematy = wp_get_post_terms( $relacja->ID, 'temat', [ 'fields' => 'id=>name' ] );

            
        $id = array_rand( $tematy );
        $name = $tematy[$id];

        echo '<a href="' . get_term_link( $id ) . '" class="temat">';
            
        echo '#' . $name;

        echo '<div class="content">';
        echo apply_filters( 'the_content', '„' . get_post_meta( $relacja->ID, '_text', 1 ) . '”' );
        echo '</div>';
            
        echo '</a>';

        echo '<div class="terms">';
            
        if( $autorzy = wp_get_post_terms( $relacja->ID, 'autor', array('fields' => 'id=>name') ) ) {

            foreach ( $autorzy as $key => &$term ) {
                $term = '<span class="autor">' . $term . '</span>';
            }
            echo implode( ', ', $autorzy );
        }

        echo ' ';

        if( $lokalizacjeRelacji = wp_get_post_terms( $relacja->ID, 'lokalizacja', array('fields' => 'id=>name') ) ) {

            foreach ( $lokalizacjeRelacji as $key => &$term ) {
                $term = '<a class="adres" href="' . get_term_link( $key, 'lokalizacja' ) . '">' . $term . '</a>';
            }
            echo implode( ', ', $lokalizacjeRelacji );
        }
            
        echo '</div>';
            
            ?>
        </div>
    </div></div></div>
    
<?php endif; ?>
    
    
<?php 

// TEMATY

$terms = get_terms( array(
    'taxonomy' => 'temat',
    'fields'    => 'id=>name',
    //'number'    => 16
) );

if( $terms ) :
    
    $random_term_ids = array_rand( $terms, 16 );
    
    $i = 0;
    
    $lists = [ 1=>array(), 2=>array(), 3=>array(), 4=>array() ];
    foreach( $random_term_ids as $key ) {
        
        if( $i < 4 ) $i++; else $i = 1;
        $lists[$i][] = [ 'id' => $key, 'name' => $terms[$key] ];
    }
    ?>
    <div class="container front"><div class="grid">
    <?php 
        
    foreach( $lists as $list ) : ?>
        <ul class="col-6 col-lg-3 sul-tab-tematy">

            <?php foreach( $list as $term ) {
                
                echo '<li><a href="' . get_term_link( $term['id'], 'temat' ) . '">#' . $term['name'] . '</a></li>';
            } ?>
            
        </ul>
    <?php 
    endforeach; ?>
    </div></div>
<?php endif; ?>
    
</main>
<?php get_footer(); ?>