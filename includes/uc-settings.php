<?php

add_action( 'admin_menu', 'add_uc_woo_menu' );
function add_uc_woo_menu() {
	add_theme_page(
		'UC Zoom', 		 	// The title to be displayed in the browser window for   this page.
		'UC Zoom',			// The text to be displayed for this menu item
		'administrator',			// Which type of users can see this menu item
		'uc_woo_settings',	// The unique ID - that is, the slug - for this menu item
		'uc_woo_display'		// The name of the function to call when rendering this menu's page
	);
}
function uc_woo_display() {
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title() ?></h2>
		<?php settings_errors(); ?>
		<form method="post" action="options.php">
			<?php
				settings_fields( 'options_group' );     
				do_settings_sections( 'primer_page' ); 
				submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action('admin_init', 'plugin_settings');
function plugin_settings() {
	$optn = array('cursorshade'=>'false');
	if( false == get_option( 'uc_savedb_option_group' ) ) {	
		add_option( 'uc_savedb_option_group', $optn );
	}


	add_settings_section(
		'general_uc_section',
		__( 'Display Options', 'uc-woocommerce-zoom' ),
		'',
		'primer_page'
	);
	add_settings_field(	
		'cursorshade',						// ID used to identify the field throughout the theme
		__( 'Cursor shade', 'uc-woocommerce-zoom' ),							// The label to the left of the option interface element
		'callback_radio',	// The name of the function responsible for rendering the option interface
		'primer_page',				// The page on which this option will be displayed
		'general_uc_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
		    'false' => 'No',		
			'true'  => 'Yes'
		)
	);
	register_setting( 'options_group', 'uc_savedb_option_group', 'sanitize_callback' );
}

    /**
     * Displays a radio for a settings field
     *
     * @param 
     */
    function callback_radio($args) {
    $find = get_option( 'uc_savedb_option_group' );
    $find = $find['cursorshade'];
    print_r($find);
    var_dump($find);    
	$html = '';
    foreach ($args as $key => $value) {    	   	
		$html .= sprintf( '<label><input type="radio" name="uc_savedb_option_group[cursorshade]" value="%1$s"%2$s />"%3$s"</label>', $key, checked( $find, $key, false ), $value );
    }
	echo $html;
    }
   

   	function sanitize_callback( $input ) {
	// Create our array for storing the validated options
	$output = array();	
	// Loop through each of the incoming options
	foreach( $input as $key => $value ) {
		
		// Check to see if the current option has a value. If so, process it.
		if( isset( $input[$key] ) ) {
		
			// Strip all HTML and PHP tags and properly handle quoted strings
			$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );
			
		} // end if
		
	} // end foreach	
	// Return the array processing any additional functions filtered by this action
		return apply_filters( 'sanitize_callback', $output, $input );
	} 

	
//if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function uc_product_zoom_trig(){
	global $post, $woocommerce, $product;

	if( has_post_thumbnail() ){

		$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
		$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
		$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			'title' 			=> $image_title,
			'data-zoom-image' 	=> $image_link,
			'class' 				=> 'my-foto',
			) );

		$attachment_count = count( $product->get_gallery_attachment_ids() );

		if ( $attachment_count > 0 ) {
			$gallery = '[product-zoom]';
		} else {
			$gallery = '';
		}

		return sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="zoomim' . $gallery . '">%s</a>', $image_link, $image_title, $image );
	
	} else {

		return sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce-image-zoom' ) );

	}
}

add_filter( 'woocommerce_single_product_image_html', 'uc_product_zoom_trig' );


function uc_get_option($field, $dbtb, $default = '') {
	$option = get_option($dbtb);
	if ( isset($option[$field]) ) {
		return $option[$field];
	}
	return $default;
}


	if( !function_exists('uc_trigger_zoomimg') ):
	function uc_trigger_zoomimg(){
		?>
			<script>
				 jQuery(function(){
			        jQuery(".my-foto").imagezoomsl({				  
			            cursorshade: <?php echo uc_get_option('cursorshade','uc_savedb_option_group','false'); ?>
			       });
			   }); 
			</script>
	<?php 
	}
	endif;
	add_action('wp_footer','uc_trigger_zoomimg');



	
?>