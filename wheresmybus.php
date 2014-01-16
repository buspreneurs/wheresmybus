<?php
/**
 * Plugin Name: Where's My Bus
 * Plugin URI: https://github.com/buspreneurs/wheresmybus
 * Description: StartupBus tracking for en route busses
 * Version: 0.1
 * Author: Gergely Imreh <gergely@imreh.net>
 * Author URI: https://gergely.imreh.net
 * License: BSD
 */


add_action( 'admin_menu', 'wheresmybus_menu' );

function wheresmybus_menu() {
	add_options_page( 'Where\'s My Bus Options', 'Where\'s My Bus', 'manage_options', 'wheresmybus', 'wheresmybus_options' );
}

function wheresmybus_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

?>