<?php

if( $media_id = get_post_meta( get_the_ID(), '_audio_id', 1 ) ) {

    echo '<p>';
    if( $desc = get_post_meta( get_the_id(), '_desc', 1 ) ) {
        echo '<span class="desc">' . $desc . '</span>';
    }

    $media_url = wp_get_attachment_url( $media_id );
    
    $mime = get_post_mime_type( $media_id );

    if(strstr($mime, "video/")){
        $video = wp_video_shortcode( array(
            'src' => $media_url,
            'preload'   => 'metadata',
            'class' => 'sul-media',
        ) );
        echo preg_replace('/\<[\/]{0,1}div[^\>]*\>/i', '', $video);
    } else {
        $audio = wp_audio_shortcode( array(
            'src' => $media_url,
            'preload'   => 'metadata',
            'class' => 'sul-media',
        ) );
        echo $audio;        
    }
    

    echo '</p>';
};