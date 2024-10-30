<?php namespace JWPLGBBP;
/*
File: admin.php
Path: {wp_plugin_dir}/bible-plus/inc/JWPLGBBP/admin.php
Created: 01.10.17 @ 07:59 EST
Modified: 01.15.17 @ 19:51 EST
Author: Joshua Wieczorek
---
Description: Admin options for plugin.
*/

class Admin {

	// Verses of the day
	private $_vods;

	/**
	 * Class constructor
	 */
	public function __construct()
    {
		// Set verses of the day
		$this->_vods = filter_input(INPUT_POST, 'jwplgbbp-vod', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY) ? filter_input(INPUT_POST, 'jwplgbbp-vod', FILTER_SANITIZE_NUMBER_INT, FILTER_REQUIRE_ARRAY) : get_option('jwplgbbp_vods');
		// Add admin menu pages
		add_action('admin_menu', array($this, 'admin_pages'));
		// Save verses of the day
		$this->_save_vods();
	}

	/**
	 * Create admin pages and add them to the admin menu.
	 * @return null
	 */
	public function admin_pages()
	{
		// Admin home page
		add_menu_page(__('Bible+','jwplgbbp'), __('Bible+','jwplgbbp'), 'administrator', 'bible-plus', array($this, 'render_admin_home_page'), 'dashicons-book', 25);
		// Daily proverb page
		add_submenu_page('bible-plus', __('Daily','jwplgbbp'), __('DailyProverb','jwplgbbp'), 'administrator', 'daily-proverb', array($this, 'render_admin_daily_proverb_page'));
	}

	/**
	 * Render content for main admin page.
	 * @return null
	 */
	public function render_admin_home_page()
	{
		include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'assets/html/admin-home.html.php');
	}

	/**
	 * Render Daily Proverb vereses page.
	 * @return null
	 */
	public function render_admin_daily_proverb_page()
	{
		// Include html template.
		include jwplgbbp_fcreate_path(JWPLGBBP_PATH.'assets/html/vods.html.php');
	}

	/**
	 * Save verses of the day when admin saves them.
	 * @return null
	 */
	private function _save_vods()
	{
		// If verses of the day not saved
		if( !isset( $_POST['jwplgbbp-vod-save'] ) ) :
			// Return and do not save
			return;
		endif;
		// Update verses in database
		update_option('jwplgbbp_vods', $this->_vods);
	}
}
