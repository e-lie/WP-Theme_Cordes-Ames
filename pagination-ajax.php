<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<nav class="woo-pagination pagination">
  <?php
    $links = paginate_links( array(
      'format' 		=> '%#%',
      'current' 		=> max( 1, get_query_var('paged') ),
      'total' 		=> $wp_query->max_num_pages,
      'prev_text' 	=> '&larr;',
      'next_text' 	=> '&rarr;',
      'type'			=> 'list',
      'end_size'		=> 3,
      'mid_size'		=> 3
    ) );
   echo( $links );
   ?>
</nav>

