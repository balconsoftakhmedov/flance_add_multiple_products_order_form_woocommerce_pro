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

foreach ( $variations as $key => $value ) {

	if ( ! $value['variation_is_visible'] ) {
		continue;
	}
	$html .= $prod_top;
	if ( 'y' == $params['showimage'] ) {


		$html .= $row_sep_top;
		$html .= "<td class=\"image\" align=\"center\">";
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
			$html .= "<td class=\"product_name\" align=\"center\"><a href=\"" . $url . "\">" . $name . "</a></td>\n";

		} else {
			$html .= "<td class=\"product_name\" align=\"center\">" . $name . "</td>\n";


		}
		$html .= $row_sep_btm;
	}
	if ( 'y' == $params['showsku'] ) {
		$html .= $row_sep_top;
		$html .= "<td class=\"product_name\" align=\"center\">" . $sku . "</td>\n";
		$html .= $row_sep_btm;
	}
	if ( 'y' == $params['attribute'] ) {
		//    $attrib = $this->get_attribute($id);
		if ( ! empty( $attrib ) ) {
			//   $attrib = $this->get_attribute($id);
		} else {
			//      $attrib = 'No Product attibute';
		}
		// Get product attributes
		$attributes = $product->get_attributes();
		$variations = find_valid_variations( $id );
		//   echo "<pre>"; print_r($variations);  echo "</pre>";
		//     $variations = $product->get_available_variations();
		$formatted_attributes = array();
		$var_attrib           = null;
		$unique_id            = null;
		foreach ( $value['attributes'] as $key => $val ) {
			$val        = str_replace( array( '-', '_' ), ' ', $val );
			$key        = str_replace( '-', '=', $key );
			$key_1      = str_replace( 'attribute_', '', $key );
			$val_1      = str_replace( ' ', '__', $val );
			$var_attrib .= '<span><input type="hidden" id="' . $id . '=' . $key . '" name="' . $id . '=' . $key . '" value="' . $val . '" />' . wc_attribute_label( $key_1 ) . ': ' . $val . '</span><br/>';
			$unique_id  .= $id . '___' . $key . '___' . $val_1 . '_br_';

		}
		$attrib = $var_attrib;
		$html   .= $row_sep_top;
		$html   .= "<td class=\"attibute\" align=\"center\">" . $attrib . "</td>\n";
		$html   .= $row_sep_btm;
	}
	if ( 'y' == $params['showmfk'] ) {
		$html .= "<td class='brands' style='text-align:center;'>" . $term_names . "</td>\n";
	}
	if ( 'y' == $params['category'] ) {
		$html .= "<td class='cats' style='text-align:center;'>" . $terms_cat . "</td>\n";
	}
	if ( 'y' == $params['showdesc'] ) {
		$html .= $row_sep_top;
		$html .= "<td class=\"desc\">" . $desc . "</td>\n";
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
		$html .= "<td class=\"stock\">" . $qty . "</td>\n";
		$html .= $row_sep_btm;
	}
	if ( 'y' == $params['showprice'] ) {


		$html          .= $row_sep_top;
		$product_price = wc_get_price_including_tax( $product );
		$tax           = $product_price - $product->get_price();
		$html          .= "<td class=\"price\">" . $value['display_price'] . "</td>\n";
		$html          .= '<input type="hidden" value="' . $value['display_price'] . '" name="pricequat" id="pricequa' . $formclass . '_' . $unique_id . '">';
		$html          .= '<input type="hidden" value="' . $tax . '" name="pricetax" id="pricetax' . $formclass . '_' . $unique_id . '">';
		$html          .= $row_sep_btm;
	}
	$idi[ $i ] = $unique_id;
	if ( 'y' == $params['showquantity'] ) {
		if ( @$params['quantity'] > - 1 ) {
			$qty = $params['quantity'][0];
		} else {
			$qty = $params['quantity'][0];
		}
		$html .= $row_sep_top;
		$html .= "<td class=\"addtocart\" style='width:70px;'>";
		$html .= '
                                    <div class="qty_box">
                                     <span class="quantity-controls js-recalculate">
                                        <input class="quantity-controls quantity-plus" id="quantity-plus' . $formclass . '_' . $unique_id . '" type="button"  value="+">

                                        </span>
                                         <span class="quantity-box">
                                         <input data-id="' . absint( $product->get_id() ) . '" type="numbner" value="' . $qty . '" name="quantity[' . absint( $product->get_id() ) . ']" id="quantity' . $formclass . '_' . $unique_id . '" size="4" class="quantity-input js-recalculate">
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


}
?>
