<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();

$position = ($woocommerce_loop['loop'] - 1) % 18;

  if ( $position >= 0 && $position <= 3) {
    $classes[] = 'line1';
  }elseif ( $position >= 4 && $position <= 8) {
    $classes[] = 'line2';
  }elseif ( $position >= 9 && $position <= 13) {
    $classes[] = 'line3';
  }elseif ( $position >= 14 && $position <= 17) {
    $classes[] = 'line4';
  }

  if ( $position >= 3 )
    $classes[] = 'tiny';

  if ( $position == 0 || $position == 4 || $position == 9 || $position == 14 )
    $classes[] = 'first';
  if ( $position == 3 || $position == 8 || $position == 13 || $position == 17 )
    $classes[] = 'last';
  
 
  $classes[] = get_categories_as_classes($product, 'product_cat');

?>
<li <?php post_class( $classes ); ?>">

		<?php
			/**
			 * custom hook : woocommerce_before_cloud_item
			 *
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_cloud_item' );
		?>
    <div class="caption">
      <?php
        /**
         * custom hook : woocommerce_before_cloud_item
         *
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_cloud_item' );
      ?>
    </div>
  
    <div class="rb-overlay" >
      <span class="rb-close">close</span>    
      <h3><?php the_title(); ?></h3>
    </div>
</li>
