<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php global $post, $woocommerce, $product;?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked woocommerce_show_messages - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

      
  <section class="product-title">
    <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
    
    <?php $related_artists = get_related_artists(get_the_id());
      if ( ! empty($related_artists) ) {
	$artist = $related_artists[0];
	$artist_link = get_permalink($artist->ID);?>
    <a href="<?php echo $artist_link; ?>"><h2 itemprop="name" class="product_title entry-title"><?php echo get_the_title($artist->ID); ?></h1></a>
    <?php } ?>

    <?php $related_artists = get_related_artists(get_the_id());

      // product-image
      if ( has_post_thumbnail() ) {
	$product_image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
	$product_image_link = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    ?>
    <a href="<?php echo $product_image_link?>" itemprop="image" class="product-image" title="<?php $image_title?>"  rel="prettyPhoto' . $gallery . '">
     <?php the_post_thumbnail( 'medium', array('title' => $product_image_title)); ?>
    </a>
    <?php }
    
      //artist-image
      if ( ! empty($related_artists)) {
	$artist = $related_artists[0]; 
	$artist_image_title = esc_attr( get_the_title( get_post_thumbnail_id($artist_id) ) );
	if( has_post_thumbnail($artist->ID)) {
    ?>
    <a href='<?php echo $artist_link?>' class="artist-image" title="<?php $image_title?>">
     <?php echo get_the_post_thumbnail( $artist->ID, 'medium', array('title' => $artist_image_title)); ?>
    </a> <?php } } ?>
  </section>
  
  <section class="purchase">
    <?php woocommerce_get_template( 'single-product/add-to-cart/simple.php' );
    	woocommerce_get_template( 'single-product/price.php' ); ?>
  </section>
  
  <section class="product-content">
    <?php the_content(); ?>
  </section>
  
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
