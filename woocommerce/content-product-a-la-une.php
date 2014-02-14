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
$classes[] = "a-la-une";

?>
<section <?php post_class( $classes ); ?>">

		<?php
		

  
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( array(300, 300) );
      }elseif ( woocommerce_placeholder_img_src() ){
        echo woocommerce_placeholder_img( 'shop_catalog' );
      }
		?>
      <h2>A la une</h2>
      
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis id turpis risus. Sed mollis condimentum turpis, nec ultricies libero sollicitudin id. Curabitur sodales risus vitae odio consequat tempor. Curabitur sapien nibh, luctus sit amet erat ut, accumsan egestas ligula. Phasellus a vehicula lorem. In a enim aliquet lectus imperdiet ultrices. Sed pulvinar erat nec lobortis blandit. Quisque congue orci ut interdum imperdiet. Pellentesque eu semper tortor. </p>

</section>
