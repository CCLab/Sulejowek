<?php get_header(); ?>

<main id="main">

    <header class="sul-term-header temat"><div class="container">

        <?php if(have_posts()) : 
        
            /* Mapa lokalizacji relacji tego tematu */
        
            global $wp_query;
        
            $relacje = $wp_query->posts;
            $relacje_ids = wp_list_pluck( $relacje, 'ID' );
            $lokalizacje = wp_get_object_terms($relacje_ids, 'lokalizacja');
        
            if( $lokalizacje ) {
                global $sul_lokalizacje;
                $sul_lokalizacje = $lokalizacje;
                
                get_template_part( 'parts/mapa' );
            }
        

        endif; ?>
        
        <?php
            $term = get_queried_object();
        ?>
        <div class="grid">

            <div class="col-lg-6 offset-lg-2">

                <div class="wrapper">
                    <h1 class="title"><?php echo $term->name; ?></h1>
                </div>

            </div>

        </div>
    </div></header>

    <div class="sul-archive ostatni">

        <div class="container"><div class="grid align-start">
            <div class="col-12 col-lg-8 sul-archive-main">

                <?php if(have_posts()) :

                    $ile = 0;
                    $max = 6;
                    while(have_posts()) : the_post();
                
                        $ile++;
                        if( $ile == $max + 1 ) echo '<div class="hidden collapsable" id="sul-hide">';
                        
                        get_template_part( 'parts/item' );


                    endwhile;
                    if( $ile > $max ) : echo '</div>'; ?>

                    <div class="show-more-wrapper">
                        <button type="button" class="unbutton show-more" data-toggle="collapse" aria-controls="sul-hide" aria-expanded="false" aria-label="<?php echo sprintf(__('Czytaj więcej (jeszcze %s fragmenty)', 'sul'), ( $ile - $max )); ?>">
                            <?php echo sprintf(__('Czytaj więcej (jeszcze %s fragmenty)', 'sul'), ( $ile - $max )); ?>
                        </button>
                    </div>

                    <?php endif;

                endif; ?>
                    

            </div>

            <div class="col-12 col-lg-3 offset-lg-1 sul-sidebar tematy"><div class="wrapper">

                <?php 


                if( $tematy = wp_get_object_terms( $relacje_ids, 'temat', array( 'fields' => 'id=>name' ) ) ) {


                    foreach ( $tematy as $key => &$temat ) {
                        $temat = '<li><a href="' . get_term_link( $key, 'temat' ) . '">' . $temat . '</a></li>';
                    }
                    $tematy =  implode( '', $tematy );
                    echo '<h2>' . __('Powiązane tematy', 'sul' ) .':</h2> <ul>' . $tematy . '</ul>';
                }


                ?>

            </div></div>

        </div></div>

    </div>

</main>

<?php get_footer(); ?>