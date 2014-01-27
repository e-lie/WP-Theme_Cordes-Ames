<?php

    /*
        Template Name: Archive Getter
    */

    global $wp_query;

    if (htmlspecialchars(trim($_POST['cea_t'])) == 'product') {
      $post_type = 'product';
      $taxonomy_name = 'product_cat';
    }elseif (htmlspecialchars(trim($_POST['cea_t'])) == 'artist') {
      $post_type = 'artist';
      $taxonomy_name = 'genre';
    }
      
    $year = htmlspecialchars(trim($_POST['cea_y']));
    $month = htmlspecialchars(trim($_POST['cea_m']));
    $cat_id = htmlspecialchars(trim($_POST['cea_c']));
    $page = htmlspecialchars(trim($_POST['cea_p']));
    $orderby = htmlspecialchars(trim($_POST['cea_o']));
    
    if( $orderby == 'name' ){
      $order = 'ASC';
    }else{
      $order = 'DESC';
    }
    
    $args = array ( 'year' => $year, 'monthnum' => $month, 'posts_per_page' => '12', 'paged' => $page, 'post_type' => $post_type, 'orderby' => $orderby, 'order' => $order);
    
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
		
					<?php woocommerce_get_template_part( 'content' , $post_type ); ?>
	    <?php 
	        endwhile; else:
	        
	        	echo "<li>Pas de contenu pour ces critères.</li>";
	        
	        endif; 
	    ?>
      </ul>

      <?php get_template_part('pagination-ajax'); ?>

