<?php
/**
 * Plugin Name: WebP Express
 * Plugin URI: https://www.bitwise-it.dk/software/wordpress/webp-express
 * Description: Serve autogenerated WebP images instead of jpeg/png to browsers that supports WebP. Works on anything (media library images, galleries, theme images etc). Easy setup: Install and forget.
 * Version: 0.1
 * Author: Bjørn Rosell
 * Author URI: http://www.rosell.dk
 * License: GPL2
 */


define( 'WEBPEXPRESS_PLUGIN', __FILE__ );


register_activation_hook( __FILE__, function(){
  include( plugin_dir_path( __FILE__ ) . 'lib/activate.php');
} );

register_deactivation_hook( __FILE__, function(){
  include( plugin_dir_path( __FILE__ ) . 'lib/deactivate.php');
} );

if ( get_option( 'webp-express-message-pending') ) {
  include( plugin_dir_path( __FILE__ ) . 'lib/message.php');

}
if ( get_option( 'webp-express-deactivate' ) ) {
  add_action('admin_init', function() {
    deactivate_plugins( plugin_basename( __FILE__ ) );
  });
  delete_option( 'webp-express-deactivate' );
}

