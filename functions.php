<?php

function custom_init() {
  register_post_type( 'artist', array(
  'label' => __('Artistes'),
    'singular_label' => __('Artiste'),
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes')
  )); 
}
add_action('init', 'custom_init');


/**
* Custom shortcode for the home page depending on woocommerce
* display a cloud of 18 products (albums) 
*/

function products_cloud_shortcode( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '18',
			'columns' 	=> '4',
			'orderby' => 'date',
			'order' => 'desc'
		), $atts));

		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order,
			'meta_query' => array(
				array(
					'key' => '_visibility',
					'value' => array('catalog', 'visible'),
					'compare' => 'IN'
				),
				array(
					'key' => '_featured',
					'value' => 'yes'
				)
			)
		);

		ob_start();

		$products = new WP_Query( $args );

		$woocommerce_loop['columns'] = $columns;

		if ( $products->have_posts() ) : ?>
      <ul class="filter-index">
        <li>categories:</li>
        <li><a href="#">All</a></li>
        <li><a title="classique" href="#">classique</a></li>
        <li><a title="jazz" href="#">jazz</a></li>
        <li><a title="baroque" href="#">baroque</a></li>
        <li><a title="world" href="#">world</a></li>
      </ul>

      <ul class="products rb-grid">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php woocommerce_get_template_part( 'content', 'product-cloud' ); ?>

				<?php endwhile; // end of the loop. ?>

			</ul>

		<?php endif;

		wp_reset_postdata();

		return '<div class="woocommerce product-cloud">' . ob_get_clean() . '</div>';
	}

add_shortcode( 'product_cloud', 'products_cloud_shortcode' );

/**
* custom actions for the product cloud 
*/

add_action( 'woocommerce_before_cloud_item', 'woocommerce_template_loop_product_thumbnail', 10 );


/**
* Custom shortcodes for the home page depending on woocommerce
* display the about area of the page
*/

function about_begin_shortcode( $atts ) {
		ob_start();
		return '<div class="about-area">' . ob_get_clean() ;
	}

add_shortcode( 'about_begin', 'about_begin_shortcode' );

function about_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'about_end', 'about_end_shortcode' );

/**
* Custom shortcode for the home page depending on woocommerce
* display the recent post area
*/

function recent_posts_shortcode( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '4',
			'columns' 	=> '1',
			'orderby' => 'date',
			'order' => 'desc'
		), $atts));

		$args = array(
			'post_type'	=> 'post',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order
		);

		ob_start();

		$products = new WP_Query( $args );


		if ( $products->have_posts() ) : ?>

      <ul class="recent-posts-list">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php get_template_part( 'content', 'short'); ?>

				<?php endwhile; // end of the loop. ?>

			</ul>

		<?php endif;

		wp_reset_postdata();

		return '<div class="recent-posts">' . ob_get_clean() . '</div>';
	}

add_shortcode( 'recent_posts', 'recent_posts_shortcode' );

function get_categories_as_classes($custom_post, $taxonomy_name) {
  $terms = get_the_terms( $custom_post->ID, $taxonomy_name );

  if ($terms && ! is_wp_error($terms)) {
    $term_slugs_arr = array();

    foreach ($terms as $term) {
        $term_slugs_arr[] = $term->slug;
    }

    $terms_slug_str = join( " ", $term_slugs_arr);

  }
  return $terms_slug_str;
}

?>

