<?php
/**
 *vide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.flance.info
 * @since      1.0.0
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public/partials
 */


	$html                    = '<div id="wamp_form" class="flance-form">';
	$params                  = array(
			'id'            => '0',
			'showname'      => 'y',
			'showimage'     => 'y',
			'attribute'     => 'y',
			'showdesc'      => 'y',
			'showsku'       => 'n',
			'showmfk'       => 'n',
			'splitchild'    => 'n',
			'showpkg'       => 'n',
			'showprice'     => 'y',
			'showquantity'  => 'y',
			'showlink'      => 'y',
			'quantity'      => '0',
			'instock'       => 'y',
			'showaddtocart' => 'y',
			'displaylist'   => 'v',
			'displayeach'   => 'h',
			'width'         => '100',
			'border'        => '0',
			'styling'       => '',
			'align'         => ''
	);
	$params['showname']      = get_option( 'showname' );
	$params['showimage']     = get_option( 'showimage' );
	$params['attribute']     = get_option( 'attribute' );
	$params['showdesc']      = get_option( 'showdesc' );
	$params['showmfk']       = get_option( 'showmfk' );
	$params['splitchild']    = get_option( 'splitchild' );
	$params['showsku']       = get_option( 'showsku' );
	$params['showpkg']       = get_option( 'showpkg' );
	$params['showprice']     = get_option( 'showprice' );
	$params['showlink']      = get_option( 'showlink' );
	$params['instock']       = get_option( 'instock' );
	$params['showaddtocart'] = get_option( 'showaddtocart' );
	$params['redirect']      = get_option( 'redirect' );
	$params['reload']        = get_option( 'reload' );
	$params['redirectlink']  = get_option( 'redirectlink' );
	if ( ! empty( $form_id ['form_id'] ) ) {
		$formclass = "flance_" . $form_id ['form_id'];

	} else {
		$formclass = "flance";

	}
	$html .= '

    <div  class="' . $formclass . '_error" ></div>


    <form class="' . $formclass . ' multijs-recalculate " name="addtocart" method="post" action="" >';
	$html .= '<h4>' . 'Add Product(s)...' . '</h4>';
	$html .= "<table class=\"jshproductsnap\" id=\"jshproductsnap\" width=\"{$params['width']}\" border=\"{$params['border']}\"  ";
	$html .= ! empty( $params['align'] ) ? "align=\"{$params['align']}\">" : ">";
	$html .= "\n";
	$html .= "<thead><tr style=''>\n";
	if ( 'y' == $params['showimage'] ) {
		$html .= "<th class='img header_class' style='text-align:center;'>Image</th>\n";
	}
	if ( 'y' == $params['showname'] ) {
		$html .= "<th class='header_class' style='text-align:center;'>Product</th>\n";
	}
	if ( 'y' == $params['showsku'] ) {
		$html .= "<th class='header_class' style='text-align:center;'>SKU</th>\n";
	}
	if ( 'y' == $params['attribute'] ) {
		$html .= "<th class='attibute header_class' style='text-align:center;'>Attributes</th>\n";
	}
	if ( 'y' == $params['showmfk'] ) {
		$html .= "<th style='text-align:center;' class='brands header_class'>Manufacturer</th>\n";
	}
	$html .= "<th style='text-align:center;' class='cats header_class'>All Categories</th>\n";
	if ( 'y' == $params['showdesc'] ) {
		$html .= "<th class='desc header_class'>Description</th>\n";
	}
	if ( 'y' == $params['instock'] ) {
		$html .= "<th class='instock header_class'>In Stock</th>\n";
	}
	if ( 'y' == $params['showprice'] ) {
		$html .= "<th class='price header_class'>Price</th>\n";
	}
	if ( 'y' == $params['showaddtocart'] ) {
		$html .= "<th class='qty header_class'>Qty</th>\n";
	}
	$html .= "</tr></thead><tbody>\n";
	// set up how the rows and columns are displayed
	if ( 'v' == $params['displayeach'] ) {
		$row_sep_top = "<tr>\n";
		$row_sep_btm = "</tr>\n";
	} else {
		$row_sep_top = "";
		$row_sep_btm = "";
	}
	if ( 'h' == $params['displaylist'] ) {
		$start = "<tr class='flance-tr-parent'>\n";
		$end   = "</tr>\n";
	} else {
		$start = "";
		$end   = "";
	}
	if ( 'h' == $params['displaylist'] && 'v' == $params['displayeach'] ) {
		$prod_top = "<td valign=\"top\"><table>\n";
		$prod_btm = "</table></td>\n";
	} else if ( $params['displaylist'] == $params['displayeach'] ) {
		$prod_top = "";
		$prod_btm = "";
	} else {
		$prod_top = "<tr>\n";
		$prod_btm = "</tr>\n";
	}
	$i    = 0;
	$html .= $start;
	foreach ( $products as $product ) {

		$sku        = $product->get_sku();
		$name       = $product->get_name();
		$id         = $product->get_id();
		$term_names = get_the_term_list( $id, 'product_brand', $before = '', $sep = ', ', $after = '' );
		if ( empty( $term_names->errors ) ) {
			$term_names = strip_tags( $term_names );
		} else {
			$term_names = null;
		}
		$terms_cat     = get_the_term_list( $id, 'product_cat', $before = '', $sep = ', ', $after = '' );
		$terms_cat     = strip_tags( $terms_cat );
		$desc          = substr( wc_format_content( $product->get_short_description() ), 0, 80 );
		$url           = $url = get_permalink( $id );
		$product_price = wc_get_product( $id );
		$variations    = find_valid_variations( $id );
		if ( $variations ) {
			if ( $params['splitchild'] == 'y' ) {
				include( 'variation_sep_product_show.php' );
			} else {
				include( 'variation_product_show.php' );
			}
		} else {
			include( 'simple_product_show.php' );
		}
	}
	$html .= $end;
	$sym  = get_option( 'woocommerce_currency' );
	if ( empty( $sym ) ) {
		$sym = null;
	}
	$html .= "</tbody><tr style=''>\n";
	if ( 'y' == $params['showimage'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	if ( 'y' == $params['showsku'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	if ( 'y' == $params['showname'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	if ( 'y' == $params['attribute'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	if ( 'y' == $params['showmfk'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	$html .= "<th style='text-align:center;'></th>\n";
	if ( 'y' == $params['showdesc'] ) {
		$html .= "<th></th>\n";
	}
	if ( 'y' == $params['instock'] ) {
		$html .= "<th style='text-align:center;'></th>\n";
	}
	if ( 'y' == $params['showprice'] ) {
		$html .= "<th colspan='2' class='qty_bottom'>
                                                            <div class='taxfinal'>
                                                            <div style='float:left;'> Tax: </div>
                                                            <div style='margin-left:5px;float:left;' class='prodtax " . $formclass . "'>0</div>
                                                            <div style='margin-left:5px;float:left;'>  " . $sym . "</div>
                                                            </div>
                                                             <div style='clear:both;' />\n";
	}
	if ( 'y' == $params['showaddtocart'] ) {

		$html .= '<input type="hidden" value="total" name="total" class="total">';
		$html .= '<input type="hidden" value="totaltax' . $formclass . '" name="totaltax' . $formclass . '" class="totaltax' . $formclass . '">';
		$html .= "<div> <div style='float:left;'>Total Price:  </div><div style='margin-left:5px;float:left;' class='prodtotal" . $formclass . "'>0</div><div style='float:left;margin-left:5px;'>  " . $sym . "</div></div> <div style='clear:both;' /></th>\n";
	}
	$html .= "</tr>\n";
	$html .= ' </table>
 		<div class="' . $formclass . '_error_1" ></div>';
	if ( 'y' == $params['showaddtocart'] ) {
		$html .= ' <div style=text-align:center;" >
				 <input
				 id="wamp_add_items_button_' . $formclass . '"
				 type="button" title="Add Items to Order"  
				value="	Add Item (s) to Order"
				 class="addtocart_button' . $formclass . '  add_order_item wamp_add_order_item_' . $formclass . '">


				</div>';
	}
	$html .= '	</form>';
	$html .= '</div>';
	?>