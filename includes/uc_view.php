<?php 

if( !function_exists('uc_product_zoom_trig') ):
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
endif;
add_filter( 'woocommerce_single_product_image_html', 'uc_product_zoom_trig' );


if( !function_exists('uc_trigger_zoomimg') ):
	function uc_trigger_zoomimg(){
		?>
			<script>
				 jQuery(function($){
			        $(".my-foto").imagezoomsl({	
			        	innerzoom: <?php echo get_db_option('innerzoom','general_uc_section','false');?>,			  
			            cursorshade: <?php echo get_db_option('cursorshade','general_uc_section','true');?>,
			            magnifierpos: <?php echo get_db_option('magnifierpos','general_uc_section','right');?>,
			            zoomstart: <?php echo get_db_option('zoomstart','general_uc_section','2');?>,
			            magnifycursor: '<?php echo get_db_option('magnifycursor','general_uc_section','crosshair');?>',
			            cursorshadecolor: '<?php echo get_db_option('cursorshadecolor','general_uc_section','#cecece');?>',
			            cursorshadeopacity: <?php echo get_db_option('cursorshadeopacity','general_uc_section','0.3');?>,			             			
			       });
			    }); 
			</script>
	<?php 
	}
endif;
add_action('wp_footer','uc_trigger_zoomimg');


function get_db_option($field, $dbtb, $default = '') {
	$option = get_option($dbtb);
	if ( isset($option[$field]) ) {
		return $option[$field];
	}
	return $default;
}

 ?>