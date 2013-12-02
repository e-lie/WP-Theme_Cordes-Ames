<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * The template for displaying content of 'artist' type
 */

	global $woo_options;
 
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

 	$settings = array(
					'thumb_w' => 787, 
					'thumb_h' => 300, 
					'thumb_align' => 'aligncenter'
					);
					
	$settings = woo_get_dynamic_values( $settings );
 
?>

	<article <?php post_class(); ?>>
		<aside class="meta">
			<span class="month"><?php the_time( 'M' ); ?></span>
			<span class="day"><?php the_time( 'd' ); ?></span>
			<span class="year"><?php the_time( 'o' ); ?></span>
		</aside>
		
		<section class="post-content">
		    <?php 
		    	if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] != 'content' ) { 
		    		woo_image( 'width=' . $settings['thumb_w'] . '&height=' . $settings['thumb_h'] . '&class=thumbnail ' . $settings['thumb_align'] ); 
		    	} 
		    ?>
		    
			<header>
				<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			</header>
	
			<section class="entry">
			<?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'content' ) { the_content( __( 'Continue Reading &rarr;', 'woothemes' ) ); } else { the_excerpt(); } ?>
			</section>
	
			  
		</section><!--/.post-content -->

	</article><!-- /.post -->
