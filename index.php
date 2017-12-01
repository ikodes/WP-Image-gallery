<?php
/*
Plugin Name: PhotoSwip Gallery
Description: Multiple Image Upload Gallery With Different Layout.
Author:      Jitendra
Author URI:  https://github.com/jiitendrayadav
Text Domain: https://github.com/jiitendrayadav
Domain Path: /En
Version: 0.1.0
*/

define("WEBLIZAR_SLGF_PLUGIN_URL", plugin_dir_url(__FILE__));

define("WEBLIZAR_SLGF_TEXT_DOMAIN","weblizar_image_gallery" );

define ("PSG_PLUGIN_PATH",plugin_dir_path(__FILE__));

include_once PSG_PLUGIN_PATH.'simple-lightbox-gallery.php';
