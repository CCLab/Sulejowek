<?php 
/* Template Name: Wyniki wyszukiwania Adresów */

$word = $_GET[ 'szukaj' ] ?? null;

get_header(); ?>

<main id="main">

<header class="wyszukiwarka"><div class="container">

    <div class="grid">

        <div class="col-lg-6">

            <div class="wrapper">
                <form method="get" action="<?php echo get_permalink(); ?>">
                    <input type="text" class="search-field unbutton" name="szukaj" placeholder="<?php _e( 'Wpisz fragment adresu', 'sul' ); ?>" value="<?php echo $word; ?>">
                    <input type="submit" class="search-button unbutton" value="<?php _e( 'Szukaj', 'sul' ); ?>">
                </form>
            </div>

        </div>

    </div>
</div></header>


<?php 

    global $paged;
    $perpage = 10;
    $ktora = ($paged == 0) ? 1 : $paged;
    $offset = ($ktora-1) * $perpage;
    $count = 0;

    $args = array(
        'taxonomy'  => 'lokalizacja',
        'orderby'   => 'description',
        'order'     => 'ASC',
        'number'    => $perpage,
        'offset'    => $offset,
    );

    if( $word ) : 


        $args[ 'fields' ] = 'ids';
        $args[ 'number' ] = 0;


        $first_query_ids = get_terms( $args + [ 'description__like' => $word ] );
        $second_query_ids = get_terms( $args + [ 'name__like' => $word, 'exclude' => $first_query_ids ] );
        $ids = array_merge( $first_query_ids, $second_query_ids );
    
        $args[ 'number' ] = $perpage;
        unset( $args[ 'fields' ] );
        
        $query = get_terms( $args + [ 'include' => $ids ] );

        foreach($query as $term) { 

            $term->name = sul_highlight( $term->name, $word );
            $term->description = sul_highlight( $term->description, $word );
        }

        $count = count( $ids );

    else :

        $query = get_terms( $args );
        $count = wp_count_terms( array('lokalizacja'), 'hide_empty=true' );

    endif; 

    
    if( $query ) : ?>

        <div class="sul-adresy container">

            <?php 
    
            foreach($query as $term) : 
            
                $relacja_img = get_posts( array(
                    'orderby' => 'rand',
                    'posts_per_page' => 1,
                    'post_type' => [ 'relacja' ],
                    'fields'   => 'ids',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'lokalizacja',
                            'field'    => 'slug',
                            'terms'    => $term->slug,
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

                    $img_id = $relacja_img[0];

                }
            
            ?>

                <figure class="sul-tile"><a href="<?php echo get_term_link( $term ); ?>" class="wrapper">

                    <?php if( isset( $img_id ) ) echo get_the_post_thumbnail( $img_id, 'full' ); ?>
                    <div class="adres"><span><?php echo $term->description; ?></span></div>
                    <div class="title"><span><?php echo $term->name; ?></span></div>

                </a></figure>

            <?php endforeach; ?>

        </div>
            
    <?php endif; ?>
    
</main>


<?php 


$max_num_pages = ceil($count / $perpage);

$next_href = next_posts( $max_num_pages, 0 );
$prev_href = get_previous_posts_page_link( );

$cols = 2;
$offset = '';   

?>

<div class="sul-term-header footer adres search"><div class="container"><div class="grid">

    <?php if( $next_href ) : ?>
        <a class="next col-3" href="<?php echo $next_href; ?>">
            <span class="visibly-hidden-small text">
                <span><?php _e('Następna strona', 'sul'); ?></span>
                <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
            </span>
        </a>
    <?php 

    $cols--;

    endif; ?>

    <?php if( $paged && $paged > 1 && $prev_href ) : ?>
        <a class="prev col-3" href="<?php echo $prev_href; ?>">
            <span class="visibly-hidden-small text">
                <span><?php _e('Poprzednia strona', 'sul'); ?></span>
                <svg viewBox="0 0 86.3 50.5"><use xlink:href="<?php echo get_template_directory_uri(); ?>/img/arrow-lg.svg#Arrow" /></svg>
            </span>
        </a>
    <?php 

    $cols--;
    $offset = 'offset-lg-3';
    
    endif; ?>

    <div class="col-12 col-lg-<?php echo 6 + $cols * 3; ?> <?php echo $offset; ?>">
        <div class="title szlaczek width-<?php echo $cols; ?>">&nbsp;</div>
    </div>
    
</div></div></div> 

<?php get_footer(); ?>