<?php
/*
Plugin Name: Bible Plus
Version: 3.6
Plugin URI: https://wordpress.org/plugins/bible-plus/
Author: Joshua Wieczorek
Author URI: http://www.joshuawieczorek.com
Description: Embed the Bible right into your pages and posts via shortcodes.
Text Domain: jwplgbbp
*/

/*
File: index.php
Path: {wp_plugin_dir}/bible-plus/index.php
Created: 12.22.16 @ 13:11 EST
Modified: 09.02.17 @ 15:26 EST
Author: Joshua Wieczorek
---
Description: Core plugin file.
*/

/**
 * Set debug on/off.
 */
defined('JWPLGBBP_DEBUG') || define('JWPLGBBP_DEBUG', true);

/**
 * Set plugin path.
 */
defined('JWPLGBBP_PATH') || define('JWPLGBBP_PATH', dirname(__FILE__).'/');

/**
 * Set plugin url.
 */
defined('JWPLGBBP_URL') || define('JWPLGBBP_URL', plugin_dir_url(__FILE__));

/**
 * Load plugin files.
 */
require 'load.php';

/**
 * Gobally accessible Bible object.
 * @var JWPLGBBP
 */
$JWPLGBBP_Bible = new JWPLGBBP\Bible();

/**
 * Gobally accessible Proverbs object.
 * @var JWPLGBBP
 * @param object $JWPLGBBP_Bible (bible object)
 */
$JWPLGBBP_Proverbs = new JWPLGBBP\Proverbs( $JWPLGBBP_Bible );

/**
 * Instantiate plugin settings.
 */
add_action( 'init' , 'jwplgbbp_init_plugin' );

/**
 * Load plugin's javascripts and stylesheets.
 */
add_action( 'wp_enqueue_scripts', 'jwplgbbp_enqueue_scripts' );

/**
 * Enable shortcodes in text widgets.
 */
add_filter('widget_text','do_shortcode');

/**
 * Set global Bible settings and create cache directory.
 */
register_activation_hook(__FILE__ , array($JWPLGBBP_Bible, 'init'));

/**
 * Set initial Verses of the Day for the Daily Proverbs.
 */
register_activation_hook(__FILE__ , array($JWPLGBBP_Proverbs, 'init'));
