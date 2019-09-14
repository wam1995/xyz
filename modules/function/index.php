<?php
/**
 * xyz_strimwidth( ) 函数
 * 功能：字符串截取，并去除字符串中的html和php标签
 * @Param string $str			要截取的原始字符串
 * @Param int $len				截取的长度
 * @Param string $suffix		字符串结尾的标识
 * @Return string					处理后的字符串
 */
function xyz_strimwidth( $str, $len, $start = 0, $suffix = '……' ) {
    $str = str_replace(array(' ', '　','&nbsp;', '\r\n'), '', strip_tags( $str ));
    if ( $len>mb_strlen( $str ) ) {
        return mb_substr( $str, $start, $len );
    }
    return mb_substr($str, $start, $len) . $suffix;
}

/**
 * xyz_menu_with_walker( ) 函数
 * 功能：挂载walker以后调用WordPress菜单的li
 * @Param string $str			要截取的原始字符串
 * @Param int $len				截取的长度
 * @Param string $suffix		字符串结尾的标识
 * @Return string					处理后的字符串
 */
function xyz_menu_with_walker($location,$walker){
    if ( function_exists( 'wp_nav_menu' ) && has_nav_menu($location) ) {
        wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => $location, 'walker'   => $walker, 'depth'=>2 ) );
    } else {
        echo '<li><a href="'.get_bloginfo('url').'/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>';
    }

}

/**
 * xyz_menu( ) 函数
 * 功能：直接调用WordPress菜单的li
 * @Param string $str			要截取的原始字符串
 * @Param int $len				截取的长度
 * @Param string $suffix		字符串结尾的标识
 * @Return string					处理后的字符串
 */
function xyz_menu($location){
    if ( function_exists( 'wp_nav_menu' ) && has_nav_menu($location) ) {
        wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => $location, 'depth'=>2 ) );
    } else {
        echo '<li><a href="'.get_bloginfo('url').'/wp-admin/nav-menus.php">请到[后台->外观->菜单]中设置菜单。</a></li>';
    }

}
function wpstorm_menu_cat(){
    return false;
}

/**
 * 管理员判断
 * */
function xyz_is_administrator() {
    // wp_get_current_user函数仅限在主题的functions.php中使用
    $currentUser = wp_get_current_user();
    if(!empty($currentUser->roles) && in_array('administrator', $currentUser->roles))
        return 1;  // 是管理员
    else
        return 0;  // 非管理员
}

