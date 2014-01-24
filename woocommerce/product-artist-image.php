<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global  $woocommerce, $product;

?>
<div class="images artist">

	<?php
		if ( has_post_thumbnail() ) {

			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id($artist_id) ) );
			$image_link  		= get_permalink($artist_id );
			$image       		= get_the_post_thumbnail( $artist_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo ( 
      sprintf( '<a href="%s" class="woocommerce-main-image" title="%s">%s</a>',
      $image_link, $image_title, $image) );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $artist_id );

		}
	?>

	<?php //do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
