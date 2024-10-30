<?php
/*
File: load.php
Path: {wp_plugin_dir}/bible-plus/load.php
Created: 01.15.17 @ 08:35 EST
Modified: 01.15.17 @ 12:39 EST
Author: Joshua Wieczorek
---
Description: Loads plugin's dependencies.
*/

/**
 * Create file path to load files
 */
if( !function_exists( 'jwplgbbp_fcreate_path' ) ) :
    /**
     * Creates a load path for files. It replaces the
     * forward slash with the actual directory
     * seperator.
     * @param  string $path (path to create)
     * @return string       (file path)
     */
    function jwplgbbp_fcreate_path($path='')
    {
        // Return path
        return str_replace('/',DIRECTORY_SEPARATOR,$path);
    }
// End function call
endif;

// Load Bible class
include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'inc/JWPLGBBP/bible.php');
// Load Daily Proverbs class
include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'inc/JWPLGBBP/proverbs.php');
// Load misc functions file
include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'inc/functions.php');
// Load admin
include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'inc/JWPLGBBP/admin.php');
