<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * Single Post Template
 *
 * This template is the default page template. It is used to display content when someone is viewing a
 * singular view of a post ('post' post_type).
 * @link http://codex.wordpress.org/Post_Types#Post
 *
 * @package WooFramework
 * @subpackage Template
 */
	get_header();
	global $woo_options;
	
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */
	
	$settings = array(
					'thumb_single' => 'false', 
					'single_w' => 787, 
					'single_h' => 300, 
					'thumb_single_align' => 'alignright'
					);
					
	$settings = woo_get_dynamic_values( $settings );
?>
       
    <div id="content" class="col-full">
    
    	<?php woo_main_before(); ?>
    	
		<section id="main" class="col-left">
		           
        <?php
        	if ( have_posts() ) { $count = 0;
        		while ( have_posts() ) { the_post(); $count++;
        ?>
			<article <?php post_class(); ?>>
				
				<section class="post-content">

					<?php echo woo_embed( 'width=787' ); ?>
	                <?php if ( $settings['thumb_single'] == 'true' && ! woo_embed( '' ) ) { woo_image( 'width=' . $settings['single_w'] . '&height=' . $settings['single_h'] . '&class=thumbnail ' . $settings['thumb_single_align'] ); } ?>
	
	                	<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'woothemes' ), 'after' => '</div>' ) ); ?>
					</section>
													
        
        <section class="related-albums">

        <?php
	  $id_post = get_the_id();
          $related_pages_ids = rpt_get_object_relation($id_post, 'product');
          if ( count($related_pages_ids) >= 1 ) {
              $related_pages = query_posts( array(
                  'post_type' => 'product',
                  'post_status' => 'publish',
                  'posts_per_page' => 5,
                  'post__in' => $related_pages_ids,
                  'orderby' => 'post_date',
                  'order' => 'DESC',
              ) );
              ?>
              
              <h2>Albums</h2>
              <ul>
              <?php
              foreach ( $related_pages as $post ) {
                  echo '<li><a href="'.get_permalink($post).'">'.get_the_title($post).'</a></li>' . "\n";
              }?>
              </ul> <?php } ?>
	</section>
                                
            </article><!-- .post -->

				<?php woo_subscribe_connect(); ?>

            <?php
            	// Determine wether or not to display comments here, based on "Theme Options".
            	if ( isset( $woo_options['woo_comments'] ) && in_array( $woo_options['woo_comments'], array( 'post', 'both' ) ) ) {
            		comments_template();
            	}

				} // End WHILE Loop
			} else {
		?>
			<article <?php post_class(); ?>>
            	<p><?php _e( 'Sorry, no posts matched your criteria.', 'woothemes' ); ?></p>
			</article><!-- .post -->             
       	<?php } ?>  
        
		</section><!-- #main -->
		
		<?php woo_main_after(); ?>

        <?php get_sidebar(); ?>

    </div><!-- #content -->
		
<?php get_footer(); ?>
