<?php
/* functions.php : Thème Cordes&Âmes */

// add_action('wp_head', 'show_template');
// function show_template() {
//     global $template;
//     print_r($template);
// }

// {{{ ----------------- Custom post type and Custom taxonomy declaration

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

function custom_init() {
  register_post_type( 'artist', array(
  'label' => __('Artistes'),
    'singular_label' => __('Artiste'),
    'public' => true,
    'has_archive' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes')
  )); 

	$labels = array(
		'name'              => _x( 'Genres', 'taxonomy general name' ),
		'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher par genres' ),
		'all_items'         => __( 'Tous les genres' ),
		'edit_item'         => __( 'Edit Genre' ),
		'update_item'       => __( 'Mettre à jour le genre' ),
		'add_new_item'      => __( 'Ajouter genre' ),
		'new_item_name'     => __( 'Nouveau genre' ),
		'menu_name'         => __( 'Genre' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'genre' ),
	);
  
  register_taxonomy( 'genre', array( 'artist' ), $args );
  
  register_post_type( 'annonce', array(
    'label' => __('Annonces'),
    'singular_label' => __('Annonce'),
    'public' => true,
    'has_archive' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'trackbacks', 'revisions', 'page-attributes')
  )); 

	$labels = array(
		'name'              => _x( 'Types', 'taxonomy general name' ),
		'singular_name'     => _x( 'Type', 'taxonomy singular name' ),
		'search_items'      => __( 'Rechercher par type' ),
		'all_items'         => __( 'Tous les types' ),
		'edit_item'         => __( 'Editer le type ' ),
		'update_item'       => __( 'Mettre à jour le type' ),
		'add_new_item'      => __( 'Ajouter type' ),
		'new_item_name'     => __( 'Nouveau type' ),
		'menu_name'         => __( 'Type' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'type' ),
	);
  
  register_taxonomy( 'type', array( 'annonce' ), $args );
}
add_action('init', 'custom_init');

// }}}

// {{{ ------------------ hooks customization (particularly woocommerce actions)

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// }}}

// {{{ ------------------ theme parameter definition ------------

//}}}

// {{{ customization of woocommerce functions

	function woocommerce_product_custom_tabs( $tabs = array() ) {
		global $product, $post;

		// Description tab - shows product content
		if ( $post->post_content )
			$tabs['description'] = array(
				'title'    => __( 'Description', 'woocommerce' ),
				'priority' => 10,
				'callback' => 'woocommerce_product_description_tab'
			);

		// Additional information tab - shows attributes
		if ( $product->has_attributes() || ( get_option( 'woocommerce_enable_dimension_product_attributes' ) == 'yes' && ( $product->has_dimensions() || $product->has_weight() ) ) )
			$tabs['additional_information'] = array(
				'title'    => __( 'Additional Information', 'woocommerce' ),
				'priority' => 20,
				'callback' => 'woocommerce_product_additional_information_tab'
			);

		// Reviews tab - shows comments
		if ( comments_open() )
			$tabs['reviews'] = array(
				'title'    => sprintf( __( 'Reviews (%d)', 'woocommerce' ), get_comments_number( $post->ID ) ),
				'priority' => 30,
				'callback' => 'comments_template'
			);

		return $tabs;
	}

	
	
// {{{ ------------------ Custom shortcodes declaration

/**
* custom actions for the product cloud 
*/

add_action( 'woocommerce_before_cloud_item', 'woocommerce_template_loop_product_thumbnail', 10 );

//----------------------------------- HOME SHORTCODES -----------------------------------------------

function music_shortcode( $atts ) {

  global $woocommerce_loop;

  extract(shortcode_atts(array(
    'per_page' 	=> '15',
    'columns' 	=> '3',
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
      'compare' => 'IN' ),
    array(
      'key' => '_featured',
      'value' => 'yes'
	 ) ) );
  
	ob_start();
	
	$products = new WP_Query( $args );
	
	$woocommerce_loop['columns'] = $columns; ?>

  
      <div class="cloud-wrapper" style="">

	<ul class="products rb-grid">

	  <?php  while ( $products->have_posts() ) : $products->the_post(); ?>

	    <?php woocommerce_get_template_part( 'content', 'product-cloud' ); ?>

	  <?php endwhile; // end of the loop. ?>

	</ul>
      </div>

      <?php wp_reset_postdata();

  return '<div class="woocommerce product-cloud">' . ob_get_clean() . '</div>';
}

add_shortcode( 'music', 'music_shortcode' );

function a_la_une_1_shortcode ( $atts ) {
		ob_start();
		return '<section class="a-la-une"><h2> à la une...</h2><section class="column1">'.ob_get_clean();
	}

add_shortcode( 'a_la_une_1', 'a_la_une_1_shortcode' );

function a_la_une_2_shortcode ( $atts ) {
		ob_start();
		return 	'</section><section class="column2">'.ob_get_clean();
	}

add_shortcode( 'a_la_une_2', 'a_la_une_2_shortcode' );

function a_la_une_3_shortcode ( $atts ) {
		ob_start();
		return '</section><section class="column3">'.ob_get_clean();
	}

add_shortcode( 'a_la_une_3', 'a_la_une_3_shortcode' );


function a_la_une_4_shortcode ( $atts ) {
		ob_start();
		
		return '</section></section>'.ob_get_clean();
	}

add_shortcode( 'a_la_une_4', 'a_la_une_4_shortcode' );


/**
* Custom shortcodes for the home page 
* display the about area of the page
*/

function about_begin_shortcode( $atts ) {
		ob_start();
		return '<div class="about-area">
                <a href="'.$atts['title_link'].'"><h2>' . $atts['title'] . '</h2></a>' . ob_get_clean() ;
	}

add_shortcode( 'about_begin', 'about_begin_shortcode' );

function about_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'about_end', 'about_end_shortcode' ); 

	    //-------------------------------------------------------------------------

/**
* Custom shortcode for the home page depending on woocommerce
* display the recent post area
*/

function recent_posts_shortcode( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '5',
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

      <a href="#"><h2><?php echo $atts['title'] ?></h2></a>
  
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


/**
* Custom shortcode for the home page depending on woocommerce
* display the recent post area
*/

function bon_coin_shortcode( $atts ) {

		global $woocommerce_loop;

		extract(shortcode_atts(array(
			'per_page' 	=> '5',
			'columns' 	=> '1',
			'orderby' => 'date',
			'order' => 'desc'
		), $atts));

		$args = array(
			'post_type'	=> 'annonce',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'orderby' => $orderby,
			'order' => $order
		);

		ob_start();

		$products = new WP_Query( $args );


		if ( $products->have_posts() ) : ?>

      <a href="#"><h2><?php echo $atts['title'] ?></h2></a>
  
      <ul class="annonces-list">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>

					<?php get_template_part( 'content', 'short'); ?>

				<?php endwhile; // end of the loop. ?>

			</ul>

		<?php endif;

		wp_reset_postdata();

		return '<div class="bon-coin">' . ob_get_clean() . '</div>';
	}

add_shortcode( 'bon_coin', 'bon_coin_shortcode' );

// ----------------------------------SINGLE PRODUCT SHORTCODES --------------------------------------------

/**
* Custom shortcodes for the single product page
* separation for the description part of the content 
*/

function purchase_shortcode( $atts ) {
		ob_start();
		  
//     woocommerce_get_template( 'single-product/add-to-cart/simple.php' );
//     woocommerce_get_template( 'single-product/price.php' );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    do_action( 'woocommerce_single_product_summary' );
  
  
      return '<section class="purchase">'.ob_get_clean().'</section>';
}

add_shortcode( 'purchase', 'purchase_shortcode' );
	    
	    //-------------------------------------------------------------------------

function product_title_shortcode( $atts ) {
    ob_start();?>
    <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
    
    <?php $related_artists = get_related_artists(get_the_id());
      if ( ! empty($related_artists) ) {
	$artist = $related_artists[0];
	$artist_link = get_permalink($artist->ID);?>
    <a href="<?php echo $artist_link; ?>"><h2 itemprop="name" class="product_title entry-title"><?php echo get_the_title($artist->ID); ?></h1></a>
    <?php } 
  
      return '<section class="product-title">'.ob_get_clean().'</section>';
}

add_shortcode( 'product_title', 'product_title_shortcode' );

	    //-------------------------------------------------------------------------

function product_images_shortcode( $atts ) {

    extract(shortcode_atts(array(
		      'type' 	=> 'product',
			'shape' 	=> 'circle',
		), $atts));
		
    
    ob_start();?>
    <?php $related_artists = get_related_artists(get_the_id());

      // product-image
      if ( has_post_thumbnail() ) {
      if ( $type == 'product' ) {
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
    <a href='<?php echo $artist_link?>' class="artist-image <?php if($shape == 'circle') { echo('circle');} ?>" title="<?php $image_title?>">
     <?php echo get_the_post_thumbnail( $artist->ID, 'medium', array('title' => $artist_image_title)); ?>
    </a> <?php } 
    }elseif( $type == 'artist' ){
      $product_image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
      $product_image_link = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
    ?>
    <a href="<?php echo $product_image_link?>" itemprop="image" class="product-image" title="<?php $image_title?>"  rel="prettyPhoto' . $gallery . '">
     <?php the_post_thumbnail( 'medium', array('title' => $product_image_title)); ?>
    </a><?php
    } }
  
      return '<section class="product-images">'.ob_get_clean().'</section>';
}

add_shortcode( 'product_images', 'product_images_shortcode' );

	    //-------------------------------------------------------------------------

function desc_begin_shortcode( $atts ) {
		return '<h2>Présentation</h2><div class="description">';
	}

add_shortcode( 'desc_begin', 'desc_begin_shortcode' );

function desc_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'desc_end', 'desc_end_shortcode' );

function bloc_begin_shortcode( $atts ) {
		extract(shortcode_atts(array(
		      'title' 	=> ''
		), $atts));
		return '<h2>'.$atts['title'].'</h2><div class="description">';
	}

add_shortcode( 'bloc_begin', 'bloc_begin_shortcode' );

function bloc_end_shortcode( $atts ) {
		
		return '<div class="extenseur"></div></div>' ;
}

add_shortcode( 'bloc_end', 'bloc_end_shortcode' );

//------------------------------------------

function albums_begin_shortcode( $atts ) {
		return '<h2>Présentation</h2><div class="description">';
	}

add_shortcode( 'albums_begin', 'albums_begin_shortcode' );

function albums_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'albums_end', 'albums_end_shortcode' );




	    //-------------------------------------------------------------------------

function songs_list_begin_shortcode( $atts ) {
		return '<div class="songs-list">';
	}

add_shortcode( 'songs_list_begin', 'songs_list_begin_shortcode' );

function songs_list_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'songs_list_end', 'songs_list_end_shortcode' );

	    //-------------------------------------------------------------------------

function listening_begin_shortcode( $atts ) {
		return '<div class="listening">';
	}

add_shortcode( 'listening_begin', 'listening_begin_shortcode' );

function listening_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'listening_end', 'listening_end_shortcode' );


	    //-------------------------------------------------------------------------


function gallery_begin_shortcode( $atts ) {
		return '<h2>Galerie</h2><div class="gallery">';
	}

add_shortcode( 'gallery_begin', 'gallery_begin_shortcode' );

function gallery_end_shortcode( $atts ) {

		return '</div>' ;
}

add_shortcode( 'gallery_end', 'gallery_end_shortcode' );

	    //-------------------------------------------------------------------------


// }}}

// {{{ ------------------------ Utilitary functions

function get_subcategories_as_array($taxonomy_name, $parent_id){
  $music_categories = get_terms('product_cat');
  $cat_names = array();
  foreach ( $music_categories as $cat ){
    if( $cat->parent == $parent_id ){
      $cat_names[] = $cat->slug;
    }
  }
  return $cat_names;
}

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

function get_categories_display($custom_post, $taxonomy_name) {
  $terms = get_the_terms( $custom_post->ID, $taxonomy_name );

  if ($terms && ! is_wp_error($terms)) {
    $term_slugs_arr = array();

    foreach ($terms as $term) {
        $term_slugs_arr[] = $term->slug;
    }

    $terms_slug_str = join( ", ", $term_slugs_arr);

  }
  return $terms_slug_str;
}

function get_related_artists ($product_id) {
  $related_artists_ids = rpt_get_object_relation($product_id, 'artist');
  if ( ! empty($related_artists_ids) ) {
      $related_artists = get_posts( array(
          'post_type' => 'artist',
          'post_status'
 => 'publish',
          'posts_per_page' => 5,
          'post__in' => $related_artists_ids,
          'orderby' => 'post_date',
          'order' => 'DESC',
      ) );
  }
  return $related_artists;
}


function custom_post_wp_get_archives($args = '') {
	global $wpdb, $wp_locale;

	$defaults = array(
		'type' => 'monthly', 'limit' => '',
		'format' => 'html', 'before' => '',
		'after' => '', 'show_post_count' => false,
		'echo' => 1, 'order' => 'DESC',
    'post_type' => 'post'
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	if ( '' == $type )
		$type = 'monthly';

	if ( '' != $limit ) {
		$limit = absint($limit);
		$limit = ' LIMIT '.$limit;
	}

	$order = strtoupper( $order );
	if ( $order !== 'ASC' )
		$order = 'DESC';

	// this is what will separate dates on weekly archive links
	$archive_week_separator = '&#8211;';

	// over-ride general date format ? 0 = no: use the date format set in Options, 1 = yes: over-ride
	$archive_date_format_over_ride = 0;

	// options for daily archive (only if you over-ride the general date format)
	$archive_day_date_format = 'Y/m/d';

	// options for weekly archive (only if you over-ride the general date format)
	$archive_week_start_date_format = 'Y/m/d';
	$archive_week_end_date_format	= 'Y/m/d';

	if ( !$archive_date_format_over_ride ) {
		$archive_day_date_format = get_option('date_format');
		$archive_week_start_date_format = get_option('date_format');
		$archive_week_end_date_format = get_option('date_format');
	}

	$where = apply_filters( 'getarchives_where', "WHERE post_type = '".$post_type."' AND post_status = 'publish'", $r );
	$join = apply_filters( 'getarchives_join', '', $r );
	$output = '';

	$last_changed = wp_cache_get( 'last_changed', 'posts' );
	if ( ! $last_changed ) {
		$last_changed = microtime();
		wp_cache_set( 'last_changed', $last_changed, 'posts' );
	}

	if ( 'monthly' == $type ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$afterafter = $after;
			foreach ( (array) $results as $result ) {
				$url = get_month_link( $result->year, $result->month );
				/* translators: 1: month name, 2: 4-digit year */
				$text = sprintf(__('%1$s %2$d'), $wp_locale->get_month($result->month), $result->year);
				if ( $show_post_count )
					$after = '&nbsp;('.$result->posts.')' . $afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ('yearly' == $type) {
		$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$afterafter = $after;
			foreach ( (array) $results as $result) {
				$url = get_year_link($result->year);
				$text = sprintf('%d', $result->year);
				if ($show_post_count)
					$after = '&nbsp;('.$result->posts.')' . $afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ( 'daily' == $type ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			$cache[ $key ] = $results;
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$afterafter = $after;
			foreach ( (array) $results as $result ) {
				$url	= get_day_link($result->year, $result->month, $result->dayofmonth);
				$date = sprintf('%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth);
				$text = mysql2date($archive_day_date_format, $date);
				if ($show_post_count)
					$after = '&nbsp;('.$result->posts.')'.$afterafter;
				$output .= get_archives_link($url, $text, $format, $before, $after);
			}
		}
	} elseif ( 'weekly' == $type ) {
		$week = _wp_mysql_week( '`post_date`' );
		$query = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		$arc_w_last = '';
		$afterafter = $after;
		if ( $results ) {
				foreach ( (array) $results as $result ) {
					if ( $result->week != $arc_w_last ) {
						$arc_year = $result->yr;
						$arc_w_last = $result->week;
						$arc_week = get_weekstartend($result->yyyymmdd, get_option('start_of_week'));
						$arc_week_start = date_i18n($archive_week_start_date_format, $arc_week['start']);
						$arc_week_end = date_i18n($archive_week_end_date_format, $arc_week['end']);
						$url  = sprintf('%1$s/%2$s%3$sm%4$s%5$s%6$sw%7$s%8$d', home_url(), '', '?', '=', $arc_year, '&amp;', '=', $result->week);
						$text = $arc_week_start . $archive_week_separator . $arc_week_end;
						if ($show_post_count)
							$after = '&nbsp;('.$result->posts.')'.$afterafter;
						$output .= get_archives_link($url, $text, $format, $before, $after);
					}
				}
		}
	} elseif ( ( 'postbypost' == $type ) || ('alpha' == $type) ) {
		$orderby = ('alpha' == $type) ? 'post_title ASC ' : 'post_date DESC ';
		$query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			foreach ( (array) $results as $result ) {
				if ( $result->post_date != '0000-00-00 00:00:00' ) {
					$url  = get_permalink( $result );
					if ( $result->post_title )
						$text = strip_tags( apply_filters( 'the_title', $result->post_title, $result->ID ) );
					else
						$text = $result->ID;
					$output .= get_archives_link($url, $text, $format, $before, $after);
				}
			}
		}
	}
	if ( $echo )
		echo $output;
	else
		return $output;
}

// }}}

?>

