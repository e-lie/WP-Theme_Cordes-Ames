<?php

    /*
        Template Name: Archive Getter
    */

    global $wp_query;

    if (htmlspecialchars(trim($_POST['cea_t'])) == 'product') {
      $post_type = 'product';
      $taxonomy_name = 'product_cat';
    }
    $year = htmlspecialchars(trim($_POST['cea_y']));
    $month = htmlspecialchars(trim($_POST['cea_m']));
    $cat_id = htmlspecialchars(trim($_POST['cea_c']));
    $page = htmlspecialchars(trim($_POST['cea_p']));
    
    $args = array ( 'year' => $year, 'monthnum' => $month, 'posts_per_page' => '12', 'paged' => $page, 'post_type' => $post_type, 'orderby' => 'popularity');

    if ( $cat_id != -1 ){
      $cat_name = get_term( $cat_id, $taxonomy_name )->slug; 
      $args[$taxonomy_name] = $cat_name;
    }

    query_posts( $args );
    
?>

      <?php woocommerce_get_template( 'loop/result-count.php' ); ?>

      <?php get_template_part('pagination-ajax'); ?>

			<ul class="products list">
	    <?php    
	        if (have_posts()) : while (have_posts()) : the_post(); ?>
          
					<?php woocommerce_get_template_part( 'content', 'product' ); ?>
	    <?php 
	        endwhile; else:
	        
	        	echo "<li>Pas de contenu pour ces critères.</li>";
	        
	        endif; 
	    ?>
      </ul>

      <?php get_template_part('pagination-ajax'); ?>

