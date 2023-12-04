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
$unique_id  = null;
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
		$html .= "<a href=\"" . $url . "\" class='flance-table-text-style'>

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
	$attrib = '';
	$html .= $row_sep_top;
	$html .= "<td class=\"attibute flance-table-text-style\" align=\"center\">" . $attrib . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showmfk'] ) {
	$html .= "<td class='brands flance-table-text-style' style='text-align:center;'>" . $term_names . "</td>\n";
}
if ( 'y' == $params['category'] ) {
	$html .= "<td class='cats flance-table-text-style' style='text-align:center;'>" . $terms_cat . "</td>\n";
}
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
	$html .= "<td class=\"stock flance-table-text-style\">" . $qty . "</td>\n";
	$html .= $row_sep_btm;
}
if ( 'y' == $params['showprice'] ) {


	$html .= $row_sep_top;
	$product_price_including_tax = wc_get_price_including_tax( $product );
	$tax                         = $product_price_including_tax - $product->get_price();
	$raw_price = $product->get_price();
	$price_with_currency = wc_price($raw_price);
	$html                        .= "<td class=\"price flance-table-text-style\">" . $price_with_currency . "</td>\n";
	$html                        .= '<input type="hidden" value="' . wc_get_price_including_tax( $product, array( 'qty' => 1 ) ) . '" name="pricequat" id="pricequa' . $formclass . '_' . $unique_id . '">';
	$html                        .= '<input type="hidden" value="' . $tax . '" name="pricetax" id="pricetax' . $formclass . '_' . $unique_id . '">';
	$html .= $row_sep_btm;
}
$idi[ $i ] = $unique_id;
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
                                         <input data-attribute_name_slug="quantity" data-id="' . absint( $product->get_id() ) . '" type="number" value="' . $qty . '" name="quantity[' . absint( $product->get_id() ) . ']" id="quantity' . $formclass . '_' . $unique_id . '" size="4" class="quantity-input js-recalculate flance-table-text-style">
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