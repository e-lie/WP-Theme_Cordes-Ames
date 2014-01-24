<?php
/*
Template Name: Artists archive
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header('shop'); ?>

		<!-- #content Starts -->
		<?php woo_content_before(); ?>
	    <div id="content" class="col-full archive-product">

	        <!-- #main Starts -->
	        <?php woo_main_before(); ?>
	        <div id="main" class="col-left">

			<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

		<?php do_action( 'woocommerce_archive_description' );
          $ajax_request_type = 'artist';
          $post_type = 'artist';
          $taxonomy_name = 'genre';
          $archive_type = 'yearly';
          include(locate_template( 'product-filtering.php' ));
          $the_query = new WP_Query( array( 'posts_per_page' => '12', 'post_type' => 'artist' ) ); ?>


		<?php if ( $the_query->have_posts() ) : ?>
			<?php
          woocommerce_show_messages();
			?>
       <a id="mode" class="" href="javascript: void(0);">mode</a> 

      <div id="archive-wrapper">

      <?php woocommerce_get_template( 'loop/result-count.php' ); ?>

      <?php get_template_part('pagination-ajax'); ?>

			<ul class="products list">

				<?php woocommerce_product_subcategories(); ?>

				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'artist' ); ?>

				<?php endwhile; // end of the loop. ?>

      </ul>

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
