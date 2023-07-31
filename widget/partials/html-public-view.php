<div id="wamp_form">
	<?php if ( empty($title) ): ?>
	    <h4><?php _e( 'Add Product(s)...', 'Flance' ); ?></h4>
	<?php else: ?>
		<?php echo $args['before_title'] . $title . $args['after_title']; ?>
	<?php endif; ?>
    <!-- multiple dropdown -->
    <select id="wamp_select_box" data-placeholder="<?php _e( 'Choose a product...', 'Flance' )?>" multiple class="wamp_products_select_box">
		<optgroup label="<?php _e( 'Choose products by SKU or Name....', 'Flance' )?>">
			<?php Flance_Add_Multiple_Products_order_form_Woocommerce_Public::flance_amp_get_products(); ?>
		</optgroup>
    </select>
    <button id="wamp_add_items_button" type="button" class="button add_order_item wamp_add_order_item"><?php _e( 'Add Item(s)', 'Flance' )?></button>
</div>