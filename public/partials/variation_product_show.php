<?php
/**
 * vide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.flance.info
 * @since      1.1.4
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public/partials
 */

$html .= $prod_top;
if ( 'y' == $params['showimage'] ) {


	$html .= $row_sep_top;
	$html .= "<td class=\"image flance-table-text-style\" align=\"center\">";
	if ( has_post_thumbnail( $id ) ) {


		$image = get_the_post_thumbnail( $id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => 'title',
				'alt'   => 'alt',
		) );

	}
	if ( $params['showlink'] == 'y' ) {
		$html .= "<a href=\"" . $url . "\">

                                " . $image;
		$html .= "</a></td>\n";
	} else {
		$html .= $image . "</td>\n";


	}
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showname'] ) {


	$html .= $row_sep_top;
	if ( $params['showlink'] == 'y' ) {
		$html .= "<td class=\"product_name flance-table-text-style\" align=\"center\"><a href=\"" . $url . "\">" . $name . "</a></td>\n";

	} else {
		$html .= "<td class=\"product_name flance-table-text-style\" align=\"center\">" . $name . "</td>\n";


	}
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showsku'] ) {
	$html .= $row_sep_top;
	$html .= "<td class=\"product_name flance-table-text-style\" align=\"center\">" . $sku . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['attribute'] ) {

	// Get product attributes
	$attributes = $product->get_attributes();
	$variations = find_valid_variations( $id );

	$_product             = wc_get_product( $id );
	$formatted_attributes = array();
	$available_variations = $_product->get_available_variations();
	$attributes           = $_product->get_variation_attributes();
	$selected_attributes  = $_product->get_default_attributes();
	ob_start();
	if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock">
			<?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?>
		</p>
	<?php else :
		$variations_json = wp_json_encode( $available_variations );
		$variations_attr  = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
		?>
		<div class="variations flance-variations-form" data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok.
		?>" data-variation_id="">
			<?php foreach ( $attributes as $attribute_name => $options ) :
				$attribute_label= wc_attribute_label( $attribute_name );?>
				<div class="variation-row">

					<div class="value">
						<?php
						wc_dropdown_variation_attribute_options_child(
								array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $_product,
								)
						);
						?>
					</div>
				</div>
			<?php endforeach; ?>
			<div class="flance-stock flance-table-text-style">
				<?php echo esc_html__( 'In Stock', 'woomultiorderpro' ) ?>
			</div>
		</div>
	<?php endif;
	$attributes_variation = ob_get_clean();
	foreach ( $available_variations as $forv ) {

		$attr_val = $forv['attributes'];
		foreach ( $attr_val as $ind => $ind_val ) {
			$avail_vars[ $ind ][] = $ind_val;

		}

	}
	if ( ! $variations ) {
		$attrib = "No variations";
	} else {

		$attrib = null;
		foreach ( $attributes as $attribute_name => $attribute ) {


			$attrib              .= "<b>" . wc_attribute_label( $attribute_name ) . "</b>: ";
			$attributes_dropdown = '<select name="' . $id . '=attribute=' . $attribute_name . '"  id="' . $id . '=attribute=' . $attribute_name . '" class="class_var id_' . $id . '" >';
			foreach ( $attribute as $key => $pa ) {
				if ( in_array( $pa, $avail_vars[ 'attribute_' . $attribute_name ] ) ) {

					if ( $key != 0 ) {
						// remove empty first space
						$attributes_dropdown .= '<option value="' . strtolower( $pa ) . '">' . $pa . '</option>';
					} else {
						// first options
						$attributes_dropdown .= '<option value="' . strtolower( $pa ) . '">' . $pa . '</option>';

					}
				}
			}
			$attributes_dropdown .= '</select><br/>';
			$attrib              .= $attributes_dropdown;
		}

	}
	//   print_r ( $attributes);
	$var_attrib = null;
	$unique_id  = null;
	unset( $unique_id_array );
	foreach ( $variations as $key => $value ) {
		$var_attrib = null;
		$unique_id  = null;
		foreach ( $value['attributes'] as $key => $val ) {
			$val        = str_replace( array( '-', '_' ), ' ', $val );
			$key        = str_replace( '-', '=', $key );
			$key_1      = str_replace( 'attribute_', '', $key );
			$val_1      = str_replace( ' ', '__', $val );
			$var_attrib .= '<span><input type="hidden" id="' . $id . '=' . $key . '" name="' . $id . '=' . $key . '" value="' . $val . '" />' . wc_attribute_label( $key_1 ) . ': ' . $val . '</span><br/>';
			$unique_id  .= $id . '___' . $key . '___' . $val_1 . '_br_';

		}
		$unique_id_array[] = $unique_id;
	}
	$html .= $row_sep_top;
	$html .= "<td class=\"attibute flance-table-text-style\" align=\"center\">" . $attributes_variation . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showmfk'] ) {
	$html .= "<td class='brands flance-table-text-style' style='text-align:center;'>" . $term_names . "</td>\n";
}
if ( 'y' == $params['category'] )
$html .= "<td class='cats flance-table-text-style' style='text-align:center;'>" . $terms_cat . "</td>\n";
if ( 'y' == $params['showdesc'] ) {
	$html .= $row_sep_top;
	$html .= "<td class=\"desc flance-table-text-style\">" . $desc . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['instock'] ) {


	$html .= $row_sep_top;
	if ( $product->get_stock_quantity() ) {
		$qty = $product->get_stock_quantity();
	} elseif ( $product->is_in_stock() ) {
		$qty = "in Stock";
	} else {
		$qty = "Out of Stock";
	}
	$qty = '';
	$html .= "<td class=\"stock flance-stock-col flance-table-text-style\">" . $qty . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showprice'] ) {
 $unique_id = (!empty($unique_id))?$unique_id: null;

	$html                        .= $row_sep_top;
	$product_price_including_tax = wc_get_price_including_tax( $product );
	$tax                         = $product_price_including_tax - $product->get_price();
	$html                        .= "<td class=\"price flance-price-col flance-table-text-style\"></td>\n";
	$html                        .= '<input type="hidden" class="flance-regular-price" value="" name="pricequat" id="pricequa' . $formclass . '_' . $unique_id . '">';
	$html                        .= '<input type="hidden" class="flance-tax-price" value="" name="pricetax" id="pricetax' . $formclass . '_' . $unique_id . '">';
	$html                        .= $row_sep_btm;
}
if ( empty( $unique_id ) ) {
	$unique_id = $id;
}

if (!empty( $unique_id_array)) {
	foreach ( $unique_id_array as $uniq ) {
		$idi[ $i ] = $uniq;
		$i ++;
	}
}

if ( 'y' == $params['showquantity'] ) {
	if ( @$params['quantity'] > - 1 ) {
		$qty = $params['quantity'][0];
	} else {
		$qty = $params['quantity'][0];
	}
	$html .= $row_sep_top;
	$html .= "<td class=\"addtocart flance-table-text-style\" style='width:70px;'>";
	$html .= '
                                    <div class="qty_box">
                                     <span class="quantity-controls js-recalculate">
                                        <input class="quantity-controls quantity-plus" id="quantity-plus' . $formclass . '_' . $unique_id . '" type="button"  value="+">

                                        </span>
                                         <span class="quantity-box">
                                         <input data-attribute_name_slug="quantity" data-id="'. absint( $product->get_id() ).'" type="number" value="' . $qty . '" name="quantity['. absint( $product->get_id() ).']" id="quantity' . $formclass . '_' . $unique_id . '" size="4" class="quantity-input js-recalculate quantity' . $formclass . '_' . $id . ' flance-table-text-style">
                                        </span>
                                        <span class="quantity-controls js-recalculate">

                                        <input class="quantity-controls quantity-minus" id="quantity-minus' . $formclass . '_' . $unique_id . '" type="button" value="-">
                                        </span>
                                     </div>
                                          <div class="clear"></div>

                                                </td>';
	$html .= $row_sep_btm;
}
$html .= $prod_btm;
$i ++;
?>