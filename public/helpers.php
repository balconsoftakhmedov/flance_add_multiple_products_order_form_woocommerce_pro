<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.flance.info
 * @since      1.0.0
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public
 */

function generateTableHeaders( $conditions, $params, $useClasses = false ) {
	ob_start();
	?>
		<?php foreach ( $conditions as $field => $label ) : ?>
			<?php if ( 'y' == $params[ $field ] ) : ?>
				<?php $class = $useClasses ? strtolower( $label ) : ''; ?>
				<th<?php echo $class ? " class='$class'" : ''; ?> style='text-align:center;'><?php echo $label; ?></th>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php
	return ob_get_clean();
}

function find_valid_variations( $item_id ) {


	$product      = new WC_Product_Variable( $item_id );
	$variations   = $product->get_available_variations();
	$attributes   = $product->get_attributes();
	$new_variants = array();
	// Loop through all variations
	foreach ( $variations as $variation ) {

		// Peruse the attributes.
		// 1. If both are explicitly set, this is a valid variation
		// 2. If one is not set, that means any, and we must 'create' the rest.
		$valid = true; // so far
		foreach ( $attributes as $slug => $args ) {
			if ( array_key_exists( "attribute_$slug", $variation['attributes'] ) && ! empty( $variation['attributes']["attribute_$slug"] ) ) {
				// Exists
			} else {
				// Not exists, create
				$valid = false; // it contains 'anys'
				// loop through all options for the 'ANY' attribute, and add each
				foreach ( explode( '|', $attributes[ $slug ]['value'] ) as $attribute ) {
					$attribute                                    = trim( $attribute );
					$new_variant                                  = $variation;
					$new_variant['attributes']["attribute_$slug"] = $attribute;
					$new_variants[]                               = $new_variant;
				}

			}
		}
		// This contains ALL set attributes, and is itself a 'valid' variation.
		if ( $valid ) {
			$new_variants[] = $variation;
		}

	}

	return $new_variants;
}

function get_variation_data_from_variation_id( $item_id ) {

	$handle      = new WC_Product_Variable( $item_id );
	$variations1 = $handle->get_available_variations();
	echo "<pre>";
	print_r( $variations1 );
	echo "</pre>";
	echo '<select>';
	foreach ( $variations1 as $key => $value ) {
		echo '<option  value="' . $value['variation_id'] . '">' . implode( '/', $value['attributes'] ) . '-' . $value['price_html'] . '</option>';

	}
	echo '</select>';

	return; // $variation_detail will return string containing variation detail which can be used to print on website
}

function flance_entry_footer(){

}

if ( ! function_exists( 'wc_dropdown_variation_attribute_options_child' ) ) {

	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param array $args Arguments.
	 * @since 2.4.0
	 */
	function wc_dropdown_variation_attribute_options_child( $args = array() ) {
		$args = wp_parse_args(
			apply_filters( 'woocommerce_dropdown_variation_attribute_options_args', $args ),
			array(
				'options'          => false,
				'attribute'        => false,
				'attribute_name'   => false,
				'product'          => false,
				'selected'         => false,
				'required'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => __( 'Choose a', 'woocommerce' ),
			)
		);

$attribute_label = wc_attribute_label( $args['attribute'] );

		// Get selected value.
		if ( false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product ) {
			$selected_key = 'attribute_' . sanitize_title( $args['attribute'] );
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$args['selected'] = isset( $_REQUEST[ $selected_key ] ) ? wc_clean( wp_unslash( $_REQUEST[ $selected_key ] ) ) : $args['product']->get_variation_default_attribute( $args['attribute'] );
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$product_id = $product->get_id();
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title( $attribute );
		$id                    = $args['id'] ? $args['id'] : sanitize_title( $attribute );
		$class                 = $args['class'];
		$required              = (bool) $args['required'];
		$show_option_none      = (bool) $args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'].'  '.$attribute_label  : $attribute_label;
		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[ $attribute ];
		}

		$html  = '<select data-id="'. absint( $product_id ).'" id="' . esc_attr( $id ) . '___' . esc_attr( $product_id ) . '"  class="' . esc_attr( $class ) . ' variation-select" name="' . esc_attr( $name ) . '[' . esc_attr( $product_id ) . ']" data-attribute_name="attribute_' . esc_attr( sanitize_title( $attribute ) ) . '___' . esc_attr( $product_id ) . '"  data-attribute_name_slug="' . esc_attr( $name ) . '"  data-show_option_none="' . ( $show_option_none ? 'yes' : 'no' ) . '"' . ( $required ? ' required' : '' ) . '>';
		$html .= '<option value="">' . esc_html( $show_option_none_text ) . '</option>';

		if ( ! empty( $options ) ) {
			if ( $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options, true ) ) {
						$html .= '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $args['selected'] ), $term->slug, false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name, $term, $attribute, $product ) ) . '</option>';
					}
				}
			} else {
				foreach ( $options as $option ) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title( $args['selected'] ) === $args['selected'] ? selected( $args['selected'], sanitize_title( $option ), false ) : selected( $args['selected'], $option, false );
					$html    .= '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option, null, $attribute, $product ) ) . '</option>';
				}
			}
		}

		$html .= '</select>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters( 'woocommerce_dropdown_variation_attribute_options_html', $html, $args );
	}
}
