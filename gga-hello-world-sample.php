<?php
/*
Plugin Name: GGA Hello World Sample
Description: A sample plugin to show how to incoroprate the GGA Debug Bar Extender
Author: Pete Nelson @GunGeekATX
*/


// This will be the action we call to log to our Debug Bar tab
define('GGA_DEBUG_ACTION', 'gga_hello_world_debug');


// Hook into the Debug Bar's filter to add a new tab
add_filter( 'debug_bar_panels', 'gga_hello_world_sample_panel_insert' );
function gga_hello_world_sample_panel_insert( $panels ) 
{
	// Pass in the new Debug Bar tab name and the do_action you want to call
	if (class_exists('GunGeekATX_DebugBarExtender'))
		$panels[] = new GunGeekATX_DebugBarExtender('GGA Hello World', GGA_DEBUG_ACTION);

	return $panels;
}

// init code for our sample plugin
add_action('init', 'gga_hello_world_init');
function gga_hello_world_init()
{

	// log that the init was called
	$start = microtime();
	do_action(GGA_DEBUG_ACTION, 'init started');

	// .. snip, any other init code here

	// log out how the init code took
	do_action(GGA_DEBUG_ACTION, 'init ended', 'elsapsed ms ' . number_format((microtime() - $start) * 1000, 2));

}


// shortcode handler for our sample plugin
add_shortcode('gga_hello_world', 'gga_hello_world_shortcode_handler');
function gga_hello_world_shortcode_handler($atts)
{
	// dump the shortcode attributes to the Debug Bar
	do_action(GGA_DEBUG_ACTION, 'passed atts', var_export($atts, true));	

	extract( shortcode_atts( array(
		'repeat' => 1,
		'wrapper' => 'div'
	), $atts ) );


	$repeat = (int)$repeat;
	$wrapper = filter_var($wrapper, FILTER_SANITIZE_STRING);
	do_action(GGA_DEBUG_ACTION, 'filtered wrapper', $wrapper);	


	$html = '';

	for ($i = 0; $i < $repeat; $i++)
		$html .= '<' . $wrapper . '>Hello world</' . $wrapper . '>';

	return $html;
}





