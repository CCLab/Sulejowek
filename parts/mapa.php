<?php
global $sul_lokalizacje;
if($sul_lokalizacje) : ?>
<section class="sul-mapa">
    <div id="mapa" class="map-container"></div>
    <?php 
        $latlongs = array();
        $current = ( is_tax( 'lokalizacja' ) ) ? get_queried_object()->term_id : false;

        foreach ($sul_lokalizacje as $i => $lokalizacja) {
            $x = get_metadata('term', $lokalizacja->term_id, 'lat', true);
            $y = get_metadata('term', $lokalizacja->term_id, 'lon', true);
            $link = get_term_link($lokalizacja);
            $latlongs[] = array( $x, $y, "<a href='$link'><strong>{$lokalizacja->name}</strong><br />{$lokalizacja->description}<br /><span class=\"more\">Dowiedz się więcej</span></a>", ( $lokalizacja->term_id == $current ) );
            if( $lokalizacja->term_id == $current ) {
                $currentIndex = $i;
            }
        }
    

    if( isset( $currentIndex ) ) {
        $v = $latlongs[$currentIndex];
        unset($latlongs[$currentIndex]);
        $latlongs[] = $v;
        
        $latlongs = array_values($latlongs);
    }
    


    add_action('sul_footer', function() use ( $latlongs ) { ?>
    <script>

        var sulmap = {
            latlongs: <?php echo json_encode($latlongs); ?>,
            primaryIconSRC: '<?php echo get_template_directory_uri() . '/img/primaryIconPin.svg'; ?>',
            secondaryIconSRC: '<?php echo get_template_directory_uri() . '/img/secondaryIconPin.svg'; ?>'
        };
    
    </script>
    <?php }, 40 ); ?>
</section>
<?php endif; ?>