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


<?php // woocommerce_template_single_title equivalent ?>
    <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>

<?php // woocommerce_show_product_sale_flash  equivalent ?>
  <?php if ($product->is_on_sale()) : ?>
    <?php echo apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__( 'Sale!', 'woocommerce' ).'</span>', $post, $product); ?>
  <?php endif; ?>

<?php // woocommerce_template_single_images equivalent ?>
    <?php woocommerce_get_template_part( 'product', 'image' ); ?>

    <?php $related_artists = get_related_artists(get_the_id());
    if ( ! empty($related_artists) ) {
      $artist = $related_artists[0]; 
      woocommerce_get_template( 'product-artist-image.php', array( 'artist_id' => $artist->ID ) );
    } ?>


	<div class="summary entry-summary">


<?php // woocommerce_template_single_price equivalent ?>
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
	  <p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
	    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
    	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
    </div>   

<?php // woocommerce_template_single_excerpt equivalent ?>
    <?php if ( $post->post_excerpt ){ ?>
    <div itemprop="description">
      <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
    </div><?php } ?>
    
<?php // woocommerce_template_single_add_to_cart equivalent ?>
    <?php woocommerce_get_template_part( 'add-to-cart', 'simple' ); ?>

<?php // woocommerce_template_single_meta equivalent ?>
    <div class="product_meta">
      <?php do_action( 'woocommerce_product_meta_start' ); ?>
      <?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option( 'woocommerce_enable_sku' ) == 'yes' && $product->get_sku() ) : ?>
        <span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span>.</span>
      <?php endif; ?>
      <?php
        $size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
        echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
      ?>
      <?php
        $size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
        echo $product->get_tags( ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', $size, 'woocommerce' ) . ' ', '.</span>' );
      ?>
      <?php do_action( 'woocommerce_product_meta_end' ); ?>
    </div>

<?php // woocommerce_template_single_sharing equivalent ?>
    <?php do_action('woocommerce_share'); // Sharing plugins can hook into here ?>

	</div><!-- .summary -->

<?php // woocommerce_output_product_data_tabs equivalent ?>
		<?php woocommerce_get_template( 'single-product-tabs.php' ); ?>

<?php // woocommerce_output_related_products equivalent ?>
		<?php woocommerce_get_template( 'single-product-related.php', array(
				'posts_per_page'  => '4',
				'orderby'    => 'date',
				'columns'    => '3'
			) ); ?>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
