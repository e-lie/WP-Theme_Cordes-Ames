<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $wp_query;


?>

<div id="archive-browser" target="<?php echo site_url().'/archive-ajax' ?>" >
	<div>
		<h4>Month</h4>
		<select id="date-choice">
			<option val="no-choice"> &mdash; </option>
			<?php custom_post_wp_get_archives(array(
			
				'type'    => 'monthly',
				'format'  => 'option',
        'post_type' => $post_type
			
			)); ?>
		</select>
	</div>
	<div>
		<h4>Category</h4>
		<?php 

			wp_dropdown_categories(array('show_option_none' => '--', 'taxonomy' => $taxonomy_name) );
					
		?> 
	</div>
</div>

