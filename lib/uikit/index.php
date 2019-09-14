<?php

function xyz_enqueue_uikit(){
    wp_enqueue_style('theme',get_bloginfo('url')."/wp-content/plugins/xyz/lib/uikit/static/css/theme.css", array(), false, 'all');
    wp_enqueue_script('uikit.min',get_bloginfo('url')."/wp-content/plugins/xyz/lib/uikit/static/js/uikit.min.js", array() , false , false );
}

include "element/MenuWalker.php";
include "element/pagenav.php";
include "element/uk-img.php";
include "element/commentlist.php";
include "element/breadcrumbs.php";