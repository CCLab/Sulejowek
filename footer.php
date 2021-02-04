<footer class="sul-footer">
    
    <?php $content = sul_get_footer_settings(); ?>
    
    <div class="sul-contactus">
        <div class="container"><div class="grid">
            
            <div class="col-12 col-lg-6 left">
                <div class="wrapper">
                    <?php if( isset( $content['email_title'] ) ) echo '<h3 class="title">' . $content[ 'email_title' ] . '</h3>'; ?>
                    <?php if( isset( $content['email_content'] ) ) echo apply_filters( 'the_content', $content[ 'email_content' ] ); ?>
                </div>
            </div>
            
            <div class="col-12 col-lg-6 right">
                <div class="wrapper">
                    <?php if( isset( $content['newsletter_title'] ) ) echo '<h3 class="title">' . $content[ 'newsletter_title' ] . '</h3>'; ?>
                    <?php if( isset( $content['newsletter_content'] ) ) echo apply_filters( 'the_content', $content[ 'newsletter_content' ] ); ?>
                    <div class="sul-newsletter">
                    <?php if (function_exists('lg_newsletter_signup')) {
                        lg_newsletter_signup();
                    } ?>
                    </div>
                </div>
            </div>
            
        </div></div>
    </div>

    <?php if (isset( $content['logotypy'] )) : ?>
    
    <div class="sul-logotypy">
        <div class="container"><div class="grid">
            
            <?php if( isset( $content[ 'logotypy_title' ] ) ) : ?>
            
                <div class="col-12">
                    <h3 class="title"><?php echo $content[ 'logotypy_title' ]; ?></h3>
                </div>
            
            <?php endif; ?>
            
            <?php foreach( $content['logotypy'] as $key => $logotyp ) :
                
                //$offset = ( $key % 2 == 0 ) ? 'offset-lg-1' : 'offset-lg-2';
                $offset = '';
                
                if( !isset( $logotyp['img_id'] ) ) continue; ?>
    
                <div class="col-12 col-lg-3 <?php echo $offset; ?> logo">
                    
                    <?php if( isset( $logotyp['permalink'] ) ) echo '<a href="' . $logotyp['permalink'] . '">'; ?>

                    <div class="img"><?php echo wp_get_attachment_image( $logotyp['img_id'], 'logo'); ?></div>
                    <?php echo $logotyp['desc'] ? apply_filters( 'the_content', $logotyp['desc'] ) : '' ?>

                    <?php if( isset( $logotyp['permalink'] ) ) echo '</a>'; ?>

                </div>
            
            <?php endforeach; ?>
            
        </div></div>
    </div>
    
    <?php endif; ?>

    <div class="sul-contactus sul-text-columns sul-logotypy mkidn">
        <div class="container"><div class="grid align-center">
            
            <div class="col-12 col-lg-3 logo">
                <div class="wrapper">
                    <?php if( isset( $content['mkidn_logo'] ) ) {

                        if( isset( $content['mkidn_url'] ) ) echo '<a href="' . $content['mkidn_url'] . '">'; ?>

                        <div class="img"><?php echo wp_get_attachment_image( $content['mkidn_logo_id'], 'logo'); ?></div>

                        <?php if( isset( $content['mkidn_url'] ) ) echo '</a>';
                    } ?>
                </div>
            </div>
            
            <div class="col-12 col-lg-9 right">
                <div class="wrapper">
                    <?php if( isset( $content['mkidn_tekst'] ) ) echo apply_filters( 'the_content', $content[ 'mkidn_tekst' ] ); ?>
                </div>
            </div>
            
        </div></div>
    </div>
    
    <div class="sul-contactus sul-text-columns">
        <div class="container"><div class="grid">
            
            <div class="col-12 col-lg-6 left">
                <div class="wrapper">
                    <?php if( isset( $content['left_column'] ) ) echo apply_filters( 'the_content', $content[ 'left_column' ] ); ?>
                </div>
            </div>
            
            <div class="col-12 col-lg-6 right">
                <div class="wrapper">
                    <?php if( isset( $content['right_column'] ) ) echo apply_filters( 'the_content', $content[ 'right_column' ] ); ?>
                </div>
            </div>
            
        </div></div>
    </div>
    
</footer>



<template id="playertml">
    <section class="player audio">
        <div class="wrapper">
        
            <button class="playpause unbutton" aria-pressed="false">
                <span class="visibly-hidden"><?php _e('Włącz dźwięk', 'zs'); ?></span>
            </button>

            <div class="progressbar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">

                <div class="progress"></div>

                <div class="visibly-hidden">0%</div>

            </div>

            <div class="time">
                <span class="current">00:00</span>
                /
                <span class="duration">00:00</span>
            </div>

        </div>
    </section>
</template>
<?php do_action( 'sul_footer' ); ?>
<?php wp_footer(); ?>

<?php 

/*

        //Ten skrypt zamienia nazwy plików zapisane w post meta na post thumbnails 
        $relacje_img = get_posts( array(
            'posts_per_page' => -1,
            'post_type' => [ 'relacja' ],
            'fields'   => 'ids',
            'meta_query' => array(
                array(
                    'key' => '_rodzaj',
                    'value' => 1,
                    'compare'   => '=',
                    'type'  => 'NUMERIC'
                ),
                array(
                    'key'     => '_img',
                    'compare' => 'EXISTS'
                )
            )
        ));
        if( $relacje_img ) {

            foreach( $relacje_img as $relacja ) {
                $imgname = get_post_meta( $relacja, '_img', 1 );
                $attid = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '" . $imgname . "'" );
                
                if( $attid ) {
                    set_post_thumbnail( $relacja, $attid );
                } else {
                    echo $imgname;
                }
            }

        }
*/
?>

</body>
</html>