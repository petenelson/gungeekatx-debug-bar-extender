<?php
/*
Plugin Name: GGA Debug Bar Extender
Plugin URI: http://petenelson.com/
Author URI: http://petenelson.com/
Description: Adds support for your plugin to output to the Debug Bar plugin (http://wordpress.org/extend/plugins/debug-bar/)
Author: Pete Nelson @GunGeekATX
Version: 1.0
*/


class GunGeekATX_DebugBarExtender
{

	private $content = array();
	var $tab_name = '';
	var $visible = true;

	function __construct($tab_name, $action) {
		$this->tab_name = $tab_name;
		if (isset($action) && !has_action($action))
			add_action( $action,  array( $this, 'debug_log' ), 10, 2);
	}


	function debug_log($title, $message = '') {
		$this->content[] = array('title' => $title, 'message' => $message);
	}


	function title() {
		return $this->tab_name;
	}

	function prerender() {}

	function is_visible() {
		return $this->visible;
	}

	function render() {
		foreach ($this->content as $c) {
			echo '<div class="GunGeekATX_DebugPanelExtender_entry"><strong class="GunGeekATX_DebugPanelExtender_title">' . $c['title'] . '</strong> <span class="GunGeekATX_DebugPanelExtender_message">' . $c['message'] . '</span></div>';
		}
	}

}

