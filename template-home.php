<?php
/*
Template Name: Home Page
*/

// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Page Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a page ('page' post_type) unless another page template overrules this one.
 * @link http://codex.wordpress.org/Pages
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
?>
       
  <div id="content" class="page col-full">
    
    <?php woo_main_before(); ?>
    	
		<section id="main" class="col-left home-cea"> 			

      <?php
        if ( have_posts() ) { 
          $count = 0;
          while ( have_posts() ) { the_post(); $count++;
      ?>                                                           

      <article <?php post_class(); ?>>

        <section class="entry">
          <?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
        </section><!-- /.entry -->

				<?php edit_post_link( __( '{ Edit }', 'woothemes' ), '<span class="small">', '</span>' ); ?>

      </article><!-- /.post -->
            
      <?php
				  } // End WHILE Loop
        } else {
		  ?>

			<article <?php post_class(); ?>>
        <p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
      </article><!-- /.post -->

      <?php } // End IF Statement ?>  
        
		</section><!-- /#main -->
		
  </div><!-- /#content -->
		
<?php get_footer(); ?>
