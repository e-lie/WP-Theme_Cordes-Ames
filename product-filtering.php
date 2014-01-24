<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<div id="archive-browser" target="<?php echo site_url().'/?page_id=6173' ?>" type="<?php echo $ajax_request_type ?>" >
	<div>
		<h4>Année</h4>
		<select id="date-choice">
			<option val="no-choice"> &mdash; </option>
			<?php custom_post_wp_get_archives(array(
			
				'type'    => $archive_type,
				'format'  => 'option',
        'post_type' => $post_type
			
			)); ?>
		</select>
	</div>
	<div>
		<h4>Genre</h4>
		<?php 

			wp_dropdown_categories(array('show_option_none' => '--', 'taxonomy' => $taxonomy_name) );
					
		?> 
	</div>
	<div>
		<h4>Classement</h4>
	<select id="orderby" name="orderby" class="orderby">
		<?php
			$catalog_orderby = apply_filters( 'woocommerce_catalog_orderby', array(
				'name' => __( 'Default sorting', 'woocommerce' ),
				'date'       => __( 'Sort by newness', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' )
			) );

			foreach ( $catalog_orderby as $name => $text )
				echo '<option value="' . esc_attr( $name ) . '" ' . selected( $orderby, $name, false ) . '>' . esc_attr( $text ) . '</option>';
		?>
	</select>
	</div>
</div>

