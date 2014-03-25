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
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();

$position = ($woocommerce_loop['loop'] - 1) % 15;

  if ( $position >= 0 && $position <= 4) {
    $classes[] = 'line1';
  }elseif ( $position >= 5 && $position <= 9) {
    $classes[] = 'line2';
  }elseif ( $position >= 10 && $position <= 14) {
    $classes[] = 'line3';
  }

  if ( $position == 0 || $position == 3 || $position == 6 || $position == 9 || $position == 12 )
    $classes[] = 'first';
  if ( $position == 2 || $position == 5 || $position == 8 || $position == 11 || $position == 14 )
    $classes[] = 'last';
  
 
  $classes[] = get_categories_as_classes($product, 'product_cat');

?>
<li <?php post_class( $classes ); ?>">

		<a href="<?php the_permalink(); ?>"><?php
      if ( has_post_thumbnail() ) {
        the_post_thumbnail('medium');
      }elseif ( woocommerce_placeholder_img_src() ){
        echo woocommerce_placeholder_img( 'shop_catalog' );
      }
      ?></a>
	<?php ?>

</li>
