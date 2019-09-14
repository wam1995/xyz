<?php
/**
 * 获取框架image图片地址
 * */

function uk_src_srcset($img_id='',$size=''){

    if($img_id){
        $img_src    = wp_get_attachment_image_src($img_id,$size);
        $img_srcset = wp_get_attachment_image_srcset($img_id,$size);
        echo 'data-src="'.$img_src[0].'" data-srcset="'.$img_srcset.'" src="'.$img_src[0].'" srcset="'.$img_srcset.'"';
    }else{
        echo 'src="'.get_bloginfo('url').'/wp-content/plugins/xyz/modules/img/noimg.jpg"';
    }

}
function uk_bg_src_srcset($img_id='',$size='',$add_style='background-size:cover;background-position:center'){
    if($img_id){
        $img_src    = wp_get_attachment_image_src($img_id,$size);
        $img_srcset = wp_get_attachment_image_srcset($img_id,$size);
        echo 'data-src="'.$img_src[0].'" data-srcset="'.$img_srcset.'" style="background-image: url(\''.$img_src[0].'\' );'.$add_style.'"';
    }else{
        echo "style=\"background-image: url('".get_bloginfo('url')."/wp-content/plugins/xyz/modules/img/noimg.jpg');$add_style\"";
    }
}
