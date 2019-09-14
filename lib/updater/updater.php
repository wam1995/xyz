<?php
add_action( 'init', 'github_plugin_updater_test_init' );
function github_plugin_updater_test_init() {

include_once 'updater.php';

define( 'WP_GITHUB_FORCE_UPDATE', true );

if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

$config = array(
'slug' => XYZ_PLUGIN_BASE_NAME,
'proper_folder_name' => 'xyz',
'api_url' => 'https://api.github.com/repos/wowwwai/xyz',
'raw_url' => 'https://raw.github.com/wowwwai/xyz/master',
'github_url' => 'https://github.com/wowwwai/xyz',
'zip_url' => 'https://github.com/wowwwai/xyz/archive/master.zip',
'sslverify' => true,
'requires' => '5.0',
'tested' => '5.0',
'readme' => 'README.md',
);

new WP_PlugGIt( $config );

}

}
