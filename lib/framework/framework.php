<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.

require_once plugin_dir_path(__FILE__) . 'classes/setup.class.php';
    $prefix = 'xyz';

    CSF::createOptions( $prefix, array(
        'framework_title'         => '小宇宙 <small> by JOYTHEME</small>',
        'framework_class'         => '',
        'menu_title'              => '小宇宙',
        'menu_slug'               => 'xyz',
        'menu_type'               => 'menu',
        'menu_capability'         => 'manage_options',
        'menu_icon'               =>  XYZ_PLUGIN_BASE_URL.'/modules/img/yellow.png',
        'menu_position'           =>  null,
        'menu_hidden'             =>  false,
        'menu_parent'             =>  '',
        'show_sub_menu'           => true,
        'show_network_menu'       => true,
        'show_in_customizer'      => false,
        'show_search'             => false,
        'show_reset_all'          => false,
        'show_reset_section'      => false,
        'show_footer'             => false,
        'show_all_options'        => false,
        'sticky_header'           => false,
        'save_defaults'           => true,
        'ajax_save'               => true,
        'admin_bar_menu_icon'     => 'dashicons-hammer',
        'admin_bar_menu_priority' => 80,
        'database'                => '',
        'transient_time'          => 0,
        'contextual_help'         => array(),
        'contextual_help_sidebar' => '',
        'enqueue_webfont'         => true,
        'async_webfont'           => false,
        'output_css'              => true,
        'theme'                   => 'light',
        'class'                   => '',
        'defaults'                => array(),
    ) );


if ( ! function_exists( 'xyz' ) ) {
    function xyz( $option = '', $default = null ) {
        $options = get_option( 'xyz' );
        return ( isset( $options[$option] ) ) ? $options[$option] : $default;
    }
}