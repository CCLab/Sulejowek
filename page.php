<?php get_header(); ?>

<main id="main">

    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

    <article class="singular">
    
    <header class="sul-term-header"><div class="container">

        <div class="grid">

            <div class="col-lg-6 offset-lg-2">

                <div class="wrapper">
                    <h1 class="title"><?php the_title(); ?></h1>
                </div>

            </div>

        </div>
    </div></header>
    
    <div class="sul-archive ostatni biuletyn">

        <div class="container"><div class="grid align-start">
            <div class="col-12 col-lg-6 offset-lg-2 sul-archive-main">
                
                <div class="item"><div class="wrapper">
                    
                    <div class="content">

                        <?php the_content(); ?>

                    </div>
                    
                </div></div>
                    

            </div>

            <?php 

            $sidebartitle = get_post_meta( get_the_ID(), '_side_title', 1 );
            $sidebarcontent = get_post_meta( get_the_ID(), '_side_content', 1 );
            
            if( $sidebartitle || $sidebarcontent ) : ?>
            
            <div class="col-12 col-lg-3 offset-lg-1 sul-sidebar"><div class="wrapper sul-page-sidebar">

                <?php if( $sidebartitle ) echo '<h2>' . $sidebartitle . '</h2>'; ?>
                
                <?php if( $sidebarcontent ) echo apply_filters( 'the_content', $sidebarcontent ); ?>

            </div></div>
            
            <?php endif; ?>

        </div></div>

    </div>
    
    </article>
    
    <?php endwhile;

    endif;?>

</main>


<?php get_footer(); ?>
