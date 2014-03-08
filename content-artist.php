<?php
// File Security Check
if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    die ( 'You do not have sufficient permissions to access this page!' );
}
?>
<?php
/**
 * The template for displaying content of 'artist' type (based on content-short)
 */

	global $woo_options;
 
/**
 * The Variables
 *
 * Setup default variables, overriding them if the "Theme Options" have been saved.
 */

 	$settings = array(
					'thumb_w' => 300, 
					'thumb_h' => 300, 
					'thumb_align' => 'aligncenter'
					);
					
	$settings = woo_get_dynamic_values( $settings );
 
?>

<li <?php post_class(); ?>>
    <a href="<?php the_permalink(); ?>" class="thumb">
    <?php
	$size = 'shop_catalog';
	if ( has_post_thumbnail() )
	  the_post_thumbnail('medium');
	elseif ( woocommerce_placeholder_img_src() )
	  echo woocommerce_placeholder_img( $size );
    ?>
    </a>
    
    <section class="content">
	<h3><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h3>
	<section class="entry">
	<span class="post-date"><?php the_time(__('M j, Y')) ?></span>
	    <?php if ( isset( $woo_options['woo_post_content'] ) && $woo_options['woo_post_content'] == 'content' ) { the_content( __( 'Continue Reading &rarr;', 'woothemes' ) ); } else { the_excerpt(); } ?>
	</section>
    </section><!--/.post-content -->
    
    <div class="extenseur"></div>

</li><!-- /.post -->
