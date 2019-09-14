<?php
function xyz_pagenavi() {

if( is_singular() )
return;

global $wp_query;

/** 如果只有1页，则停止执行 */
if( $wp_query->max_num_pages <= 1 )
return;

$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$max   = intval( $wp_query->max_num_pages );

/** 将当前页添加到数组中 */
if ( $paged >= 1 )
$links[] = $paged;

/** 将当前页前后的页添加到数组中 */
if ( $paged >= 3 ) {
$links[] = $paged - 1;
$links[] = $paged - 2;
}

if ( ( $paged + 2 ) <= $max ) {
$links[] = $paged + 2;
$links[] = $paged + 1;
}

echo '<ul class="uk-pagination uk-flex-center" uk-margin>' . "\n";

    /** 上一页 */
    if ( get_previous_posts_link() )
    printf( '<li>%s</li>' . "\n", get_previous_posts_link($format = '<span uk-pagination-previous></span> ') );

    /** 链接到第一页，如果需要的话加上椭圆 */
    if ( ! in_array( 1, $links ) ) {
    $class = 1 == $paged ? ' class="uk-active"' : '';

    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

    if ( ! in_array( 2, $links ) )
    echo '<li>…</li>';
    }

    /** 链接到当前页面，加上2个页面在任一方向，如果必要的话 */
    sort( $links );
    foreach ( (array) $links as $link ) {
    $class = $paged == $link ? ' class="uk-active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** 链接到最后一页，如果需要的话加上椭圆 */
    if ( ! in_array( $max, $links ) ) {
    if ( ! in_array( $max - 1, $links ) )
    echo '<li>…</li>' . "\n";

    $class = $paged == $max ? ' class="uk-active"' : '';
    printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** 下一页 */
    if ( get_next_posts_link() )
    printf( '<li>%s</li>' . "\n", get_next_posts_link($format = '<span uk-pagination-next="" class="uk-pagination-next uk-icon"></span>  ') );

    echo '</ul>' . "\n";

}
