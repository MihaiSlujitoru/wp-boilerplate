<?php
/**
Plugin Name: TCM - CPT
Description: Custom Post Type Plugin
Author: The Creative Momentum
Version: 1.0
Author URI: https://www.thecreativemomentum.com/
*/

define('TCM_PLUGIN_FILE', __FILE__);
define('TCM_PLUGIN_DIR', dirname(TCM_PLUGIN_FILE));
define('TCM_PLUGIN_BASENAME', plugin_basename(TCM_PLUGIN_FILE));


require_once(TCM_PLUGIN_DIR . '/inc/class-functions.php');