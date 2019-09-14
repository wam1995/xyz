<?php

/*
 * Plugin Name: 小宇宙
 * Plugin URI: https://www.joytheme.com/
 * Description: JOYtheme 推出的 WordPress 整合型插件, .
 * Author: JOYtheme
 * Author URI: https://www.joytheme.com/
 * Version: 0.0.1
 */

define('XYZ_PLUGIN_FILE', __FILE__);
define('XYZ_PLUGIN_BASE_NAME', plugin_basename( __FILE__ ));
define('XYZ_PLUGIN_BASE_URL', plugin_dir_url( __FILE__ ) );
define('XYZ_PLUGIN_ROOT_PATH', plugin_dir_path( __FILE__ ) );

include 'lib/index.php';
include 'modules/index.php';

