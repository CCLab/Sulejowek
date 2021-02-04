<?php
/* Language prefix */
function sul_get_language_prefix() {
    $prefix = '';
    if( function_exists( 'pll_default_language' ) ) {
        $default = pll_default_language('slug');
        global $polylang;
        if( !is_object($polylang) ) return '';
        $current = (is_admin() && !wp_doing_ajax()) ? $polylang->pref_lang->slug : pll_current_language('slug');
        if($current && $current !== $default ) $prefix = $current . '_';   
    }
    return $prefix;
}
function sul_highlight( $string, $word ) {
    $p = preg_quote($word, '/');  // The pattern to match
    
    $p = $word;

    $string = preg_replace(
        "/($p)/i",
        '<mark>$1</mark>', 
        $string
    );
    
    return $string;
}