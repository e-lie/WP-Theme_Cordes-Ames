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
 
 // customization (override) of content-product

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
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>

    <?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

    <a href="<?php the_permalink(); ?>" class="thumb">
    <?php
	$size = 'shop_catalog';
	if ( has_post_thumbnail() )
	  the_post_thumbnail("large");
	elseif ( woocommerce_placeholder_img_src() )
	  echo woocommerce_placeholder_img( $size );
    ?>
    </a>

    <section class="content">
    <h3><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h3>
    <div class="post-category"><?php echo get_categories_display($product, 'product_cat'); ?></div>
    <span class="post-date"><?php the_time(__('M j, Y')) ?></span>
    <div class="post-excerpt"><?php the_excerpt(); ?></div>
      <?php
      $related_artists = get_related_artists(get_the_id());

      if ( ! empty($related_artists) ) {
      echo '<ul>' . "\n";
      foreach ( $related_artists as $artist ) {
          setup_postdata( $artist );
          echo '<li><a href="'.get_permalink($artist).'">'.get_the_title($artist).'</a></li>' . "\n";
      }
      echo '</ul>' . "\n"; 
      wp_reset_postdata();
      }
     ?>
    </section>

    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>
