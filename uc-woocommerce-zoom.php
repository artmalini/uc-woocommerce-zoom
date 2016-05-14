<?php
/**
 * Plugin Name:       UC Woocommerce Zoom
 * Plugin URI:        https://github.com/artmalini/uc-woocommerce-zoom.git
 * Description:       Plugin for woocommerce product zoom.
 * Version:           1.1
 * Author:            Artem Makhinya
 * Author URI:        https://github.com/artmalini/uc-woocommerce-zoom.git
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       uc-woocommerce-zoom
 * Domain Path:       /languages
 */

/**
 * Define Path 
 */

define( 'UC_W_ZOOM', WP_CONTENT_URL. '/plugins/uc-woocommerce-zoom' );



/**
 * Require Files
 */

require_once dirname( __FILE__ ) . '/includes/uc_registration.php';
require_once dirname( __FILE__ ) . '/uc_settings.php';
require_once dirname( __FILE__ ) . '/includes/uc_view.php';

/**
 * Adding scripts
 */

if( !function_exists('uc_adding_scripts') ):
	function uc_adding_scripts() {		
		wp_enqueue_script('uc-zoomsl', UC_W_ZOOM.'/js/zoomsl-3.0.min.js', array('jquery'),'3.0', false);
	}
endif;
add_action( 'wp_enqueue_scripts', 'uc_adding_scripts' ); 


?>