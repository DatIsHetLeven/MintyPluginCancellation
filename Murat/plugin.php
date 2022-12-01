<?php
/*
Plugin Name:  WPBeginner Plugin Tutorial
Plugin URI:   https://www.wpbeginner.com
Description:  A short little description of the plugin. It will be displayed on the Plugins page in WordPress admin area.
Version:      1.0
Author:       WPBeginner
Author URI:   https://www.wpbeginner.com
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wpb-tutorial
Domain Path:  /languages
*/


echo '<h1></h1>';
//add_action();


//TODO ; een nieuwe order status aanmaken
//TODO: de status moet alleen gelden voor half geanullerde bestellingen
//TODO: woocommerce raporten goed zetten
// TODO: Aangeven in de achterkant welke producten geanuleerd zijn.



add_filter("woocommerce_rapport_Statuutsen", "testfunction");


function testfunction (array $data ) : array {
	$data[] = 'nieuwe_status';

	return $data;
}