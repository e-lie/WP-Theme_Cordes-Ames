<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

		<!-- #content Starts -->
		<?php woo_content_before(); ?>
	    <div id="content" class="col-full archive-product">

	        <!-- #main Starts -->
	        <?php woo_main_before(); ?>
	        <div id="main" class="col-left">

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php do_action( 'woocommerce_archive_description' );
          $ajax_request_type = 'product';
          $post_type = 'product';
          $taxonomy_name = 'product_cat';
          $archive_type = 'yearly';
          include(locate_template( 'product-filtering.php' )); ?>


		<?php if ( have_posts() ) : ?>
			<?php
          woocommerce_show_messages();
			?>

      <div id="archive-wrapper">
      

      <?php woocommerce_get_template( 'loop/result-count.php' ); ?>

      <?php get_template_part('pagination-ajax'); ?>

			<ul class="products list">

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>
				    <?php if ( has_term('albums', 'product_cat', $post) ) : ?>

					<?php woocommerce_get_template_part( 'content', 'product' ); ?>

				    <?php endif; ?>
				<?php endwhile; // end of the loop. ?>

			</ul>

      <?php woocommerce_get_template( 'loop/result-count.php' ); ?>
      <?php get_template_part('pagination-ajax'); ?>

			</div><!-- /#archive-wrapper -->

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php woocommerce_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>


			</div><!-- /#main -->
	        <?php woo_main_after(); ?>

	    </div><!-- /#content -->
		<?php woo_content_after(); ?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
	?>

<?php get_footer('shop'); ?>
