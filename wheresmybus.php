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


/* API endpoint */
add_action( 'init', 'add_endpoint');

function add_endpoint() {
  add_rewrite_endpoint( 'tracker', EP_ROOT );
}

add_action( 'template_redirect', 'template_redirect' );
function template_redirect() {
  global $wp_query;

  if(!isset( $wp_query->query['tracker'] )) {
    return $templates;
  }

  $out = [ "error" => False ];
  switch (get_query_var('tracker')) {
  case 'config':
    $out['config'] = True;
    break;
  case 'location':
    $out['location'] = True;
    break;
  default:
    $out['error'] = True;
    break;
  }
  echo json_encode($out);

}

/************/


/* Admin interface */
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