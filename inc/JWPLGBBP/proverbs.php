<?php namespace JWPLGBBP;
/*
File: proverbs.php
Path: {wp_plugin_dir}/bible-plus/inc/JWPLGBBP/proverbs.php
Created: 01.14.17 @ 08:07 EST
Modified: 09.02.17 @ 15:26 EST
Author: Joshua Wieczorek
---
Description: Daily Proverb controller for
the this plugin.
*/

class Proverbs
{
    // Local Bible Class object
    private $bible;
    // Current day
    private $_day;
    // Verse of the day json
    private $_vod;
    // Shortcode atts
    private $_atts;

    /**
     * Sets the bible, day and vod variables.
     * @param Bible $bible (bible class which from to get the proverb)
     */
    function __construct(Bible $bible)
    {
        // Set bible
        $this->bible    = $bible;
        // Set current day
        $this->_day     = (int) date("d", current_time('timestamp'));
        // Verse of the day option
        $this->_vod     = get_option('jwplgbbp_vods');
        // Render shortcode.
        remove_shortcode('daily-proverb');
        add_shortcode('daily-proverb', [$this, 'render_shortcode']);
    }

    /**
    * Sets settings upon plugin initialization
    */
    public function init()
    {
        // If option is not in database
        if( !$this->_vod && $json=file_get_contents(jwplgbbp_fcreate_path(JWPLGBBP_PATH.'assets/json/vods.json'))) :
            // Update option in database
            update_option('jwplgbbp_vods' , json_decode($json,1));
        // End if option
        endif;
    }

    /**
    * Renders the daily proverb verse
    */
    public function render_shortcode($atts)
    {
        // Shortcode attribute defaults
        $attributes = shortcode_atts( array(
            'passage'       => 'Pr'.$this->_day.':'.$this->_vod[$this->_day],
            'version'       => 'KJV',
            'cnum'          => 'no',
            'vnum'	        => 'no',
            'vpl'	        => 'yes'
        ), $atts );
        // Set attributes to class
        $this->_atts = $attributes;
        // Set attributes
        $this->bible->set_atts($attributes);
        // Set passage
        $this->bible->set_passage($attributes['passage']);
        // Set version
        $this->bible->set_version($attributes['version']);
        // Open Html
        $html  = $this->bible->render($this->_passage_reference());
        // Return verse
        return $html;
    }

    /**
     * Add reference to passage
     * @return string (html string with reference)
     */
    private function _passage_reference()
    {
        // Return reference
        return '<div class="bible-plus-passage-reference">'.__('Proverbs ', 'jwplgbbp').$this->_day.' : '.$this->_vod[$this->_day].' <span class="bible-plus-reference-version">'.strtoupper($this->_atts['version']).'</span>'.'</div>';
    }
}
