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

$position = ($woocommerce_loop['loop'] - 1) % 14;

  if ( $position >= 0 && $position <= 2) {
    $classes[] = 'line1';
  }elseif ( $position >= 3 && $position <= 6) {
    $classes[] = 'line2';
  }elseif ( $position >= 7 && $position <= 10) {
    $classes[] = 'line3';
  }elseif ( $position >= 11 && $position <= 13) {
    $classes[] = 'line4';
  }

  if ( $position >= 3 )
    $classes[] = 'tiny';

  if ( $position == 0 || $position == 3 || $position == 7 || $position == 11 )
    $classes[] = 'first';
  if ( $position == 2 || $position == 6 || $position == 10 || $position == 13 )
    $classes[] = 'last';
  
 
  $classes[] = get_categories_as_classes($product, 'product_cat');

?>
<li <?php post_class( $classes ); ?>">

		<?php
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( array(300, 300) );
      }elseif ( woocommerce_placeholder_img_src() ){
        echo woocommerce_placeholder_img( 'shop_catalog' );
      }
		?>
    <div class="rb-trigger" > 
      <div class="rb-overlay" >
        <span class="rb-close">close</span>    
        <h3><?php the_title(); ?></h3>
        <?php woocommerce_get_template_part('content', 'single-product-cloud'); ?>
      </div>
    </div>
</li>
