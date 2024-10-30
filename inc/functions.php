<?php
/*
File: functions.php
Path: {wp_plugin_dir}/bible-plus/inc/functions.php
Created: 12.22.16 @ 13:15 EST
Modified: 01.16.17 @ 15:31 EST
Author: Joshua Wieczorek
---
Description: Contains plugin's misc functions.
*/

/**
 * Setup Plugin
 */
if( !function_exists( 'jwplgbbp_init_plugin' ) ) :
    /**
     * Initializes the plugin on WordPress'
     * 'init' hook. Adds the proverbs query var
     * and initializes the admin class if is
     * admin.
     * @return null
     */
    function jwplgbbp_init_plugin()
    {
        // Load textdomain
        // load_plugin_textdomain('jwplgbbp', false, jwplgbbp_fcreate_path(JWPLGBBP_PATH.'lang/') );
        // If admin
        if( is_admin() ) :
            // Instantiate admin options
            $JWPLGBBP_Admin = new JWPLGBBP\Admin;
        endif;
    }
// End function call
endif;

/**
 * Load plugin's javascript and css file(s)
 */
if( !function_exists( 'jwplgbbp_enqueue_scripts' ) ) :
    /**
     * Injects plugin specific javascrips and
     * stylesheets.
     * @return null
     */
    function jwplgbbp_enqueue_scripts()
    {
        // Primary css file
    	wp_enqueue_style('jwplgbbp-css', JWPLGBBP_URL.'assets/css/jwplg-bible-plus.css', false);
    }
// End function call
endif;

/**
 * Load plugin's javascript and css file(s)
 */
if( !function_exists( 'jwplgbbp_debug' ) ) :
    /**
     * Turns on PHP's errors if debugging is on.
     * @return null
     */
    function jwplgbbp_debug()
    {
        // If debug is on
        if(JWPLGBBP_DEBUG) :
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        // End if debug
        endif;
    }
// End function call
endif;

// Run debugging
jwplgbbp_debug();
