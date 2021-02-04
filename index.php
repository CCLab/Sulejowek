<?php get_header(); ?>

<main id="main">

    <?php 
    
    $intro = sul_get_biuletyn_settings( 'sul_biuletyn' );
    
    if( $intro['title'] ) : ?>
        
        <header class="sul-term-header biuletyn"><div class="container">

            <div class="grid">

                <div class="col-lg-6 offset-lg-2">

                    <div class="wrapper">
                        <h1 class="title"><?php echo $intro['title']; ?></h1>
                    </div>

                </div>

            </div>
        </div></header>

    <?php endif; ?>
    
    <div class="sul-archive ostatni biuletyn">

        <div class="container"><div class="grid align-start">
            <div class="col-12 col-lg-6 offset-lg-2 sul-archive-main">
                
                <?php if( $intro['content'] ) : ?>
                
                    <div class="item intro"><div class="wrapper">
                
                        <div class="content">
                            <?php echo apply_filters( 'the_content', $intro['content'] ); ?>
                        </div>

                        <div class="sul-newsletter">
                            <?php if (function_exists('lg_newsletter_signup')) {
                                lg_newsletter_signup();
                            } ?>
                        </div>

                    </div></div>
                
                <?php endif; ?>

                <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
                
                    <article class="item">
                        

                        <div class="date terms"><div><?php echo wp_date( 'j F', get_post_time()); ?></div></div>
                        
                        <div class="content">
                
                        <?php the_title( '<h2>', '</h2>'); ?>

                        <?php the_content(); ?>

                        </div>
                
                    </article>

                <?php endwhile; endif;?>
                

            </div>

        
            <div class="col-12 col-lg-3 offset-lg-1 sul-sidebar"><div class="wrapper">

                <h2><?php _e( 'Archiwum', 'sul'); ?>:</h2>
                <br />
                
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>

            </div></div>
            

        </div></div>

    </div>

</main>

<?php 
global $wp_query;
global $paged;
$max_num_pages = $wp_query->max_num_pages;

$next_href = next_posts( $max_num_pages, 0 );
$prev_href = get_previous_posts_page_link( );

$cols = 2;
$offset = '';   

?>

<div class="sul-term-header footer adres"><div class="container"><div class="grid">

    <?php if( $next_href ) : ?>
        <a class="next col-3" href="<?php echo $next_href; ?>">
            <span class="visibly-hidden-small text">
                <span><?php _e('Następne edycje biuletynu', 'sul'); ?></span>
            </span>
        </a>
    <?php 

    $cols--;

    endif; ?>

    <?php if( $paged && $paged > 1 && $prev_href ) : ?>
        <a class="prev col-3" href="<?php echo $prev_href; ?>">
            <span class="visibly-hidden-small text">
                <span><?php _e('Poprzednie edycje biuletynu', 'sul'); ?></span>
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