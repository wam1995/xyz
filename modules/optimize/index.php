<?php

CSF::createSection( 'xyz', array(
    'title'  => 'WP优化',
    'fields' => array(

        array(
            'id'      => 'remove_head_links',
            'type'    => 'switcher',
            'title'   => '移除头部代码',
            'label'   => 'WordPress会在页面的头部输出了一些link和meta标签代码，这些代码没什么作用，并且存在安全隐患，建议移除WordPress页面头部中无关紧要的代码。',
            'default' => true
        ),

        array(
            'id'      => 'article_version_switcher',
            'type'    => 'switcher',
            'title'   => '屏蔽文章修订功能',
            'label'   => '文章修订功能会在 Posts 表中插入多条历史数据，Posts 表冗余，屏蔽它可以有效提高数据库效率。',
            'default' => false
        ),

        array(
            'id'      => 'remove_admin_bar',
            'type'    => 'switcher',
            'title'   => '移除admin bar',
            'label'   => 'WordPress用户登陆的情况下会出现Admin Bar，此选项可以帮助你全局移除工具栏，所有人包括管理员都看不到。',
            'default' => false
        ),


        array(
            'id'      => 'disable_xml_rpc',
            'type'    => 'switcher',
            'title'   => '屏蔽XML-RPC',
            'label'   => 'XML-RPC协议用于客户端发布文章，如果你只是在后台发布，可以关闭XML-RPC功能。Gutenberg编辑器需要XML-RPC功能。',
            'default' => false
        ),

        array(
            'id'      => 'disable_gutenberg',
            'type'    => 'switcher',
            'title'   => '禁用古腾堡编辑器',
            'label'   => '古腾堡编辑器是WP5.0以后的新编辑器，如果用不惯可以用这个选项来屏蔽。',
            'default' => false
        ),


        array(
            'id'      => 'disable_trackbacks',
            'type'    => 'switcher',
            'title'   => '屏蔽Trackbacks',
            'label'   => 'Trackbacks协议被滥用，会给博客产生大量垃圾留言，建议彻底关闭Trackbacks。',
            'default' => false
        ),

        array(
            'id'      => 'disable_update',
            'type'    => 'switcher',
            'title'   => '关闭自动升级',
            'label'   => '',
            'default' => false
        ),

        array(
            'id'      => 'disable_privacy',
            'type'    => 'switcher',
            'title'   => '屏蔽后台隐私（GDPR）',
            'label'   => 'GDPR（General Data Protection Regulation）是欧洲的通用数据保护条例，WordPress为了适应该法律，在后台设置很多隐私功能，如果只是在国内运营博客，可以移除后台隐私相关的页面。',
            'default' => false
        ),
        array(
            'id'      => 'emoji_switcher',
            'type'    => 'switcher',
            'title'   => '屏蔽emoji代码',
            'label'   => 'WordPress 为了兼容在一些比较老旧的浏览器能够显示 Emoji 表情图标，而准备的功能。',
            'default' => false
        ),


    )
) );

//屏蔽文章修订
if(xyz('article_version_switcher')){
    define('WP_POST_REVISIONS', false);
    remove_action('pre_post_update', 'wp_save_post_revision' );
    // 自动保存设置为10个小时
    define('AUTOSAVE_INTERVAL', 36000 );
}

//移除admin bar
if(xyz('remove_admin_bar')){
    add_filter('show_admin_bar', '__return_false');
}

//禁用古腾堡
if(xyz('disable_gutenberg')){
    add_filter('use_block_editor_for_post_type', '__return_false');
}

//禁用 XML-RPC 接口
if(xyz('disable_xml_rpc')){
    if(xyz('diable_block_editor')){
        add_filter( 'xmlrpc_enabled', '__return_false' );
        remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
    }
}

if(xyz('disable_trackbacks')){
    if(xyz('disable_xml_rpc')){
        //彻底关闭 pingback
        add_filter('xmlrpc_methods',function($methods){
            $methods['pingback.ping'] = '__return_false';
            $methods['pingback.extensions.getPingbacks'] = '__return_false';
            return $methods;
        });
    }

    //禁用 pingbacks, enclosures, trackbacks
    remove_action( 'do_pings', 'do_all_pings', 10 );

    //去掉 _encloseme 和 do_ping 操作。
    remove_action( 'publish_post','_publish_post_hook',5 );
}

//移除 WP_Head 无关紧要的代码
if(xyz('remove_head_links')){
    remove_action( 'wp_head', 'wp_generator');					//删除 head 中的 WP 版本号
    foreach (['rss2_head', 'commentsrss2_head', 'rss_head', 'rdf_header', 'atom_head', 'comments_atom_head', 'opml_head', 'app_head'] as $action) {
        remove_action( $action, 'the_generator' );
    }
    remove_action( 'wp_head', 'rsd_link' );						//删除 head 中的 RSD LINK
    remove_action( 'wp_head', 'wlwmanifest_link' );				//删除 head 中的 Windows Live Writer 的适配器？
    remove_action( 'wp_head', 'feed_links_extra', 3 );		  	//删除 head 中的 Feed 相关的link
    remove_action( 'wp_head', 'index_rel_link' );				//删除 head 中首页，上级，开始，相连的日志链接
    remove_action( 'wp_head', 'parent_post_rel_link', 10);
    remove_action( 'wp_head', 'start_post_rel_link', 10);
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );	//删除 head 中的 shortlink
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10);	// 删除头部输出 WP RSET API 地址
    remove_action( 'template_redirect',	'wp_shortlink_header', 11);		//禁止短链接 Header 标签。
    remove_action( 'template_redirect',	'rest_output_link_header', 11);	// 禁止输出 Header Link 标签。
}
if(function_exists('edd_version_in_header')){
    remove_action( 'wp_head', 'edd_version_in_header' );

}
if(xyz('disable_trackbacks')){
    if(xyz('disable_xml_rpc')){
        //彻底关闭 pingback
        add_filter('xmlrpc_methods',function($methods){
            $methods['pingback.ping'] = '__return_false';
            $methods['pingback.extensions.getPingbacks'] = '__return_false';
            return $methods;
        });
    }
    //禁用 pingbacks, enclosures, trackbacks
    remove_action( 'do_pings', 'do_all_pings', 10 );
    //去掉 _encloseme 和 do_ping 操作。
    remove_action( 'publish_post','_publish_post_hook',5 );
}

if(xyz('disable_update')){
    add_filter('automatic_updater_disabled', '__return_true');	// 彻底关闭自动更新
    remove_action('init', 'wp_schedule_update_checks');	// 关闭更新检查定时作业
    wp_clear_scheduled_hook('wp_version_check');			// 移除已有的版本检查定时作业
    wp_clear_scheduled_hook('wp_update_plugins');		// 移除已有的插件更新定时作业
    wp_clear_scheduled_hook('wp_update_themes');			// 移除已有的主题更新定时作业
    wp_clear_scheduled_hook('wp_maybe_auto_update');		// 移除已有的自动更新定时作业
    remove_action( 'admin_init', '_maybe_update_core' );		// 移除后台内核更新检查
    remove_action( 'load-plugins.php', 'wp_update_plugins' );	// 移除后台插件更新检查
    remove_action( 'load-update.php', 'wp_update_plugins' );
    remove_action( 'load-update-core.php', 'wp_update_plugins' );
    remove_action( 'admin_init', '_maybe_update_plugins' );
    remove_action( 'load-themes.php', 'wp_update_themes' );		// 移除后台主题更新检查
    remove_action( 'load-update.php', 'wp_update_themes' );
    remove_action( 'load-update-core.php', 'wp_update_themes' );
    remove_action( 'admin_init', '_maybe_update_themes' );
}

if(xyz('disable_privacy')){

    add_action('admin_menu', function (){
        global $menu, $submenu;

        // 移除设置菜单下的隐私子菜单。
        unset($submenu['options-general.php'][45]);

        // 移除工具彩带下的相关页面
        remove_action( 'admin_menu', '_wp_privacy_hook_requests_page' );

        remove_filter( 'wp_privacy_personal_data_erasure_page', 'wp_privacy_process_personal_data_erasure_page', 10, 5 );
        remove_filter( 'wp_privacy_personal_data_export_page', 'wp_privacy_process_personal_data_export_page', 10, 7 );
        remove_filter( 'wp_privacy_personal_data_export_file', 'wp_privacy_generate_personal_data_export_file', 10 );
        remove_filter( 'wp_privacy_personal_data_erased', '_wp_privacy_send_erasure_fulfillment_notification', 10 );

        // Privacy policy text changes check.
        remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'text_change_check' ), 100 );

        // Show a "postbox" with the text suggestions for a privacy policy.
        remove_action( 'edit_form_after_title', array( 'WP_Privacy_Policy_Content', 'notice' ) );

        // Add the suggested policy text from WordPress.
        remove_action( 'admin_init', array( 'WP_Privacy_Policy_Content', 'add_suggested_content' ), 1 );

        // Update the cached policy info when the policy page is updated.
        remove_action( 'post_updated', array( 'WP_Privacy_Policy_Content', '_policy_page_updated' ) );
    },9);
}

// 清除wp所有自带的customize选项
function remove_default_settings_customize( $wp_customize ) {
    //All our sections, settings, and controls will be added here
    $wp_customize->remove_section( 'title_tagline');
    $wp_customize->remove_section( 'colors');
    $wp_customize->remove_section( 'header_image');
    $wp_customize->remove_section( 'background_image');
    $wp_customize->remove_panel( 'nav_menus');
    $wp_customize->remove_section( 'static_front_page');
    $wp_customize->remove_section( 'custom_css');

}
add_action( 'customize_register', 'remove_default_settings_customize',50 );

if(xyz('emoji_switcher')){
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script');
    remove_action( 'admin_print_styles', 'print_emoji_styles');
    remove_action( 'wp_head', 'print_emoji_detection_script', 7);
    remove_action( 'wp_print_styles', 'print_emoji_styles');
    remove_filter( 'the_content_feed', 'wp_staticize_emoji');
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji');
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email');
}
