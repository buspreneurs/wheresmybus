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

  $out = [];
  switch (get_query_var('tracker')) {
  case 'config':
    $out = create_config();
    break;
  case 'location':
    $out['location'] = True;
    break;
  default:
    $out['error'] = True;
    break;
  }
  header('Content-Type: application/json; charset=UTF-8');
  echo json_encode($out);
}

/**
 * Create configuration to return over the API,
 *  that the bus tracker app can use
 */
function create_config() {
  global $post;
  $args = array(
		'post_type' => 'gavern_buses',
		'post_status' => 'publish'
		);
  $query = new WP_Query( $args );
  $out = array( 'endpoint' => get_bloginfo('url').'/tracker/location/' );
  $buses = [];
  while ( $query->have_posts() ) {
    $query->the_post();
    $bus = array("name"=>$post->post_title,"id"=>$post->ID);
    $buses[] = $bus;
  }
  $out["buses"] = $buses;

  wp_reset_postdata();

  return $out;
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