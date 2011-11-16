<?php
/*
Plugin Name: Login Email Sync
Plugin URI: http://alessandroraffa.eu/wordpress-plugins/
Description: This plugin simply keeps synced username with email.
Version: 0.9
Author: Alessandro Raffa
Author URI: http://www.alessandroraffa.eu
*/

/*  Copyright 2011  Alessandro Raffa  (email: contact@alessandroraffa.eu)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to 
Free Software Foundation, Inc.,
51 Franklin St, Fifth Floor, 
Boston, MA  02110-1301 USA
or see <http://www.gnu.org/licenses/>.

*/

/** Variables */

$plugin_dir = basename(dirname(__FILE__));
$plugin_text_domain = 'login-email-sync';



/** Functions */

function arit_login_email_sync_install() {
	/* global $wpdb; $this->arit_login_email_sync_table = $wpdb->prefix . 'login_email_sync'; */
	// mysql_query("");
}

function arit_login_email_sync_init() {
	if (function_exists('load_plugin_textdomain')) {
		load_plugin_textdomain( $plugin_text_domain, 'wp-content/plugins/' . $plugin_dir . '/languages', $plugin_dir . '/languages' );
	}
}

function arit_login_email_sync_admin_menu() {
	add_options_page('Login Email Sync', 'Login Email Sync', 8, __FILE__, 'arit_login_email_sync_options_page');
}

function arit_login_email_sync_options_page() {

?>

<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2><?php _e( 'Login Email Sync Options', $plugin_text_domain ); ?></h2>
<p><?php _e( 'Here is where the form would go if I actually had options. ;-)', $plugin_text_domain ); ?></p>
<p><?php _e( 'Options, coming soon...', $plugin_text_domain ); ?></p>
</div>

<?php

}

function arit_login_email_sync_uninstall() {
	// @todo: clean_wp_options
	// @todo: remove_arit_login_email_sync_options
	// @todo: remove_arit_login_email_sync_table
	// @todo: mysql_query("");
}

function arit_login_email_sync_login_text(){
	echo "<p>&nbsp;</p>";
}

function arit_login_email_sync_action( $user_id ) {

	global $wpdb;
	$tmpsql = "";

	$tmpsql = "UPDATE $wpdb->users SET user_login = LCASE(user_email), user_email = LCASE(user_email) WHERE ID =$user_id";
	$login_email_sync = $wpdb->query( $tmpsql );

	if ($login_email_sync !== 0){
		// user_login updated
		return true;
	}
	else {
		// user_login NOT updated... why? ;-)
		return false;
	}

}

/** Hooks */

register_activation_hook( __FILE__, 'arit_login_email_sync_install' );

// @todo: add_filter( 'plugin_action_links', 'arit_login_email_sync_plugin_action_links' );

add_action( 'init', 'arit_login_email_sync_init' );
add_action( 'admin_menu', 'arit_login_email_sync_admin_menu' );
add_action( 'profile_update', 'arit_login_email_sync_action' );

register_deactivation_hook( __FILE__, 'arit_login_email_sync_uninstall' );