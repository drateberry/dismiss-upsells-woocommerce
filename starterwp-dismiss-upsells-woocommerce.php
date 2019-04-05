<?php
/*
Plugin Name: Dismiss Suggestions for Automattic Plugins
Plugin URI: https://starterwp.com
Description: Remove suggestions and upsells added by Automattic plugins. This includes WooCommerce Marketplace suggestions and Jetpack upsells.
Version: 1.1
Author: Starter WP
Author URI: https://starterwp.com
Text Domain: starterwp-dismiss-upsells-woocommerce

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

//Add update library
if ( ! defined( 'YOUR_REPO_URL' ) ) {
	define( 'YOUR_REPO_URL', 'https://starterwp.com/update/' );
}
if ( ! defined( 'YOUR_PLUGIN_UNIQUE' ) ) {
	define( 'YOUR_PLUGIN_UNIQUE', 'gqaxsrb5SdDlNVHP' );
}
if ( ! defined( 'YOUR_PLUGIN_VER' ) ) {
	define( 'YOUR_PLUGIN_VER', '1.0.0' );
}

add_action( 'plugins_loaded', 'rkv_load_updater' );

function rkv_load_updater() {

	if ( ! class_exists( 'RKV_Remote_Updater' ) ) {
		include( 'lib/RKV_Remote_Updater.php' );
	}
}

add_action( 'admin_init', 'rkv_remote_update' );

function rkv_remote_update() {

	// ensure the class exists before running
	if ( ! class_exists( 'RKV_Remote_Updater' ) ) {
		return;
	}

	$updater = new RKV_Remote_Updater( YOUR_REPO_URL, __FILE__, array(
		'unique'    => YOUR_PLUGIN_UNIQUE,
		'version'   => YOUR_PLUGIN_VER,
		)
	);
}

//Remove WooCommerce Marketplace suggestions
add_filter('woocommerce_allow_marketplace_suggestions', '__return_false');

//Remove Jetpack upsells
add_filter('jetpack_show_promotions', '__return_false');

?>