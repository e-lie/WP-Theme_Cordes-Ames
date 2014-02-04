<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * The template for displaying content on one line
 */

	global $woo_options;
 
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */
 
?>
	<li <?php post_class('post-short'); ?>>

		<section class="post-content">
		    <header>
		      <?php 
			  if ( has_post_thumbnail() ) { 
			    the_post_thumbnail('thumbnail');
			  } 
		      ?>
		      <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
		    </header>
	
		</section><!--/.post-content -->
  </li>

