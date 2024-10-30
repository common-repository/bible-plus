<?php namespace JWPLGBBP;
/*
File: bible.php
Path: {wp_plugin_dir}/bible-plus/inc/JWPLGBBP/bible.php
Created: 12.22.16 @ 13:15 EST
Modified: 09.02.17 @ 15:26 EST
Author: Joshua Wieczorek
---
Description: Contains plugin's bible class.
This class gets and returns the bible
passages in html.
*/

class Bible
{
    // Bible api url
    private $_api_url;
    // Cache directory
    private $_cache_dir;
    // Set cache file extention
    private $_cache_ext;
    // Shortcode attributes
    private $_atts;
    // Bible passage
    private $_passage;
    // Bible version
    private $_version;
    // Css classes
    private $_css_classes;
    // No bible error
    private $_no_bible_error;
    // Passage reference
    private $_passage_reference_ext;

    /**
     * Sets defaults for many of this class'
     * variables.
     */
    public function __construct()
    {
        // Default api url
        $this->_api_url         = 'https://getbible.net/json?passage=';
        // Default cache directory
        $this->_cache_dir       = ABSPATH.'wp-content'.DIRECTORY_SEPARATOR.'bible-plus-cache'.DIRECTORY_SEPARATOR;
        // Default cache file extention
        $this->_cache_ext       = 'jwbbp';
        // Shortcode attributes
        $this->_atts            = array();
        // Set passage by default
        $this->_passage         = 'Jn3:16';
        // Set version by default
        $this->_version         = 'KJV';
        // Set no bible error
        $this->_no_bible_error  = __('Something went wrong with the bible. Please make sure that you are requesting a valid passage! If this problem presits please contact joshuawiecorek@outlook.com','jwplgbbp');
        // Set passage reference ext
        $this->_passage_reference_ext = '';
        // Set css classes
        $this->set_css_classes();
        // Add Bible shortcode.
        remove_shortcode('bible');
        add_shortcode('bible', [$this, 'render_shortcode']);
    }

    /**
     * Initiate the plugin
     */
    public function init()
    {
        // Create cache directory
        $this->_create_cache_dir();
    }

    /**
     * Sets the api url.
     * @param string $url (api url to use)
     */
    public function set_api_url($url='')
    {
        if( $url != '' ) :
            $this->_api_url = $url;
        endif;
    }

    /**
     * Sets the cache directory
     */
    public function set_cache_dir($dir='')
    {
        if( $dir != '' ) :
            $this->_cache_dir = $dir;
        endif;
    }

    /**
     * Sets the cache file extention
     */
    public function set_cache_ext($ext='')
    {
        if( $ext != '' ) :
            $this->_cache_ext = $ext;
        endif;
    }

    /**
     * Sets the shortcode attributes
     */
    public function set_atts($atts=array())
    {
        $this->_atts = $atts;
    }

    /**
     * Sets the desired passage
     */
    public function set_passage($passage='')
    {
        if( $passage != '' ) :
            $this->_passage = $passage;
        endif;
    }

    /**
     * Sets the desired version
     */
    public function set_version($version='')
    {
        if( $version != '' ) :
            $this->_version = $version;
        endif;
    }

    /**
     * Sets the cache directory
     */
    public function set_css_classes($classes=array())
    {
        // Set css classes and defaults
        $this->_css_classes = array(
            'container'     => isset($classes['container']) ? $classes['container'] : 'bible-plus-verse-container',
            'chapter-title' => isset($classes['chapter-title']) ? $classes['chapter-title'] : 'bible-plus-chapter-title',
            'verse'         => isset($classes['verse']) ? $classes['verse'] : 'bible-plus-verse',
            'verse-number'  => isset($classes['verse-number']) ? $classes['verse-number'] : 'bible-plus-verse-number'
        );
    }

    /**
     * Shortcode function
     */
    public function render_shortcode($atts)
    {
        // Shortcode attribute defaults
        $attributes = shortcode_atts( array(
            'passage'       => 'jn3:16',
            'version'       => 'KJV',
            'cnum'          => 'yes',
            'vnum'	        => 'yes',
            'vpl'	        => 'yes'
        ), $atts );
        // Set Bible Class shortcode attributes
        $this->set_atts($attributes);
        // Set Bible Class passage
        $this->set_passage($attributes['passage']);
        // Set Bible Class version
        $this->set_version($attributes['version']);
        // Return rendered bible
        return $this->render();
    }

    /**
     * Render html to screen
     */
    public function render($reference='')
    {
        // If reference passed set it
        $this->_passage_reference_ext = ($reference!='') ? $reference : $this->_passage_reference_ext;
        // Get json and extract into array
        if($bible = json_decode($this->_get_bible_json(), 1)) :
            // Return PHP template with array
            return $this->_render_php($bible);
        endif;
        // Else return error occurred
        return $this->_no_bible_error;

    }

    /**
     * Gets the bible
     */
    private function _get_bible_json()
    {
        // If cache exists
        if($this->_cache_exists() && $json=file_get_contents($this->_cache_path())) :
            // Return json
            return $json;
        // If no cache exists
        else :
            // Make the curl reuquest and get json
            $json = $this->_curl_request();
            // Clean json
            $clean_json = $this->_clean_json_response($json);
            // If is valid json
            if($clean_json) :
                // Cache json
                $this->_cache_json($clean_json);
            endif;
            // Return json
            return $clean_json;
        endif;
    }

    /**
     * Create full api request url
     */
    private function _api_request_url()
    {
        // Return full api url
        return $this->_api_url.$this->_passage.'&v='.$this->_version;
    }

    /**
     * Create filename
     */
    private function _filename()
    {
        // Convert to lowercase
        $filename   = strtolower($this->_passage);
        // Replace empty spaces
        $filename   = str_replace(' ','',$filename);
        // Replace colons with underscores
        $filename   = str_replace(';','_',$filename);
        // Replace semicolon with period
        $filename   = str_replace(':','.',$filename);
        // Return filename
        return $filename;
    }

    /**
     * Create CURL request and return json from response
     */
    private function _curl_request()
    {
        // Curl response
        $response = wp_remote_get($this->_api_request_url());
        // Return response body trimmed
        return is_array($response) ? trim($response['body'],'();') : null;
    }

    /**
     * Create cache directory
     */
    private function _create_cache_dir()
    {
        // If cache directory does not exists
        if(!file_exists($this->_cache_dir)) :
            // Create cache directory
            mkdir($this->_cache_dir, 0777, true);
        endif;
    }

    /**
     * Create full cache path
     */
    private function _cache_path()
    {
        // Return cache directory and filename
        return $this->_cache_dir.$this->_filename().'-'.$this->_version.'.'.$this->_cache_ext;
    }

    /**
     * See if cache file exists
     */
    private function _cache_exists()
    {
        // Return true if file exists otherwise false
        return (file_exists($this->_cache_path())) ? true : false;
    }

    /**
     * Cache json into file
     */
    private function _cache_json($json='')
    {
        // Crate file and put json in it
        file_put_contents($this->_cache_path(), $json);
    }

    /**
     * Cleans json response
     */
    private function _clean_json_response($json='')
    {
        // Create array out of json
        $array  = json_decode($json, 1);

        // If valid response type
        if(!isset($array['type'])) :
            return null;
        endif;

        // Switch resonse type
        switch( $array['type'] )
        {
            case 'book':
                // Clean for book
                $new_array = $this->_clean_books($array);
                break;
            case 'chapter':
                // Clean for chapter
                $new_array = $this->_clean_chapters($array);
                break;
            case 'verse':
                // Clean for verse
                $new_array = $this->_clean_verses($array);
                break;
        }
        // Return json
        return json_encode($new_array);
    }

    /**
     * Clean JSON for book
     */
    private function _clean_books($array=array())
    {
        // Iniate the book array
        $b_array = array();
        // Loop through the book's chapters
        foreach($array['book'] as $ch_num => $data) :
            // Set the chapter number to the verse array
            $b_array[$ch_num] = $this->_extract_verses($data['chapter']);
        endforeach;
        // Return the book array
        return $b_array;
    }

    /**
     * Clean JSON for chapter
     */
    private function _clean_chapters($array=array())
    {
        // Initiate the chapter array
        $c_array = array();
        // Set the chapter number and assign the verses
        $c_array[$array['chapter_nr']] = $this->_extract_verses($array['chapter']);
        // Return the chapter
        return $c_array;
    }

    /**
     * Clean JSON for verse
     */
    private function _clean_verses($array=array())
    {
        // Iniate the book array
        $v_array = array();
        // Loop through the book's chapters
        foreach($array['book'] as $data) :
            // Set the chapter number to the verse array
            $v_array[$data['chapter_nr']] = $this->_extract_verses($data['chapter']);
        endforeach;
        // Return the book array
        return $v_array;
    }

    /**
     * Extract verses
     */
     private function _extract_verses($array=array())
     {
         // Initiate verse array varialbe
         $v_array = array();
         // Loop through verses
         foreach($array as $key => $data) :
             // Set the verse number to the verse text
             $v_array[$key] = $data['verse'];
         endforeach;
         // Return the verse array
         return $v_array;
     }

    /**
     * Render html php template
     */
     private function _render_php($bible=array())
     {
         // Open html
         $html  = '<div class="'.$this->_css_classes['container'].'">';
         // PHP template
         $html .= $this->_php_template($bible);
         // Action to add content to bottom inside container
         $html .= $this->_passage_reference_ext;
         // Add attribution
         //$html .= '<div class="bible-plus-powered-by" style="font-size:11px;"><a href="https://bible-plus.org" target="_blank"><em>Powered by Bible Plus+</em></a></div>';
         // Close html
         $html .= '</div>';
         // Remove any value in _passage_reference_ext
         $this->_passage_reference_ext = '';
         // Return html
         return $html;
     }

    /**
     * Render html php template
     */
    private function _php_template($bible=array())
    {
        // Set verse html dom element
        $verse_element = ($this->_atts['vpl'] === 'yes') ? 'p' : 'span';
        // Open html
        $html = '';
        // Loop through bible chapters
        foreach($bible as $chapter => $verses) :
            // Show title if chapter numbers are on
            $html .= $this->_php_chapter_title($chapter);
            // Render verses
            $html .= $this->_php_render_verses($verses, $verse_element);
        // End loop through chapters
        endforeach;
        // Return html
        return $html;
    }

    /**
     * Render chapter title for php template
     */
    private function _php_chapter_title($chapter_number)
    {
        // If chapter numbers
        if( $this->_atts['cnum'] == 'yes' ) :
            return '<h4 class="'.$this->_css_classes['chapter-title'].'">'.__('Chapter', 'jwplgbbp').' '.$chapter_number.'</h4>' ;
        // End chapter numbers
        endif;
    }

    /**
     * Render verses for php template
     */
    private function _php_render_verses($verses, $ele)
    {
        // Instantiate html
        $html = '';
        // Loop through verses
        foreach( $verses as $number => $text ) :
            // Open html
            $html .= '<'.$ele.' class="'.$this->_css_classes['verse'].'">';
            // Show verse number
            $html .= $this->_php_verse_number($number);
            // Verse text
            $html .= $text;
            // Close html
            $html .= '</' . $ele . '>';
        // End verse loop
        endforeach;
        // Return html
        return $html;
    }

    /**
     * Render verse number for php template
     */
    private function _php_verse_number($verse_number)
    {
        // If verse numbers
        if( $this->_atts['vnum'] == 'yes' ) :
            return '<span class="'.$this->_css_classes['verse-number'].'"><small>'.$verse_number.'</small></span> ';
        // End verse numbers
        endif;
    }
}
