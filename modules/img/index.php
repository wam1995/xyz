<?php

    function get_thumbnail_with_size($width = 400, $height = 200)
    {
        return get_img_src_with_size(get_post_thumbnail_id($post->ID), $width, $height);
    }

    function get_img_src_with_size($img_id = '', $width = 400, $height = 200, $echo = 1)
    {

        $timthumb_src = wp_get_attachment_image_src($img_id, 'full');
        $src = $timthumb_src[0];
        $post_img_src = XYZ_PLUGIN_URL . "/img/timthumb.php&#63;src=$src&#38;w=$width&#38;h=$height&#38;zc=1&#38;q=100";
        $post_img = $post_img_src;
        return $post_img;

    }
