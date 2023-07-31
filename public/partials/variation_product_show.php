<?php 
/**
 * vide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.flance.info
 * @since     1.1.4
 *
 * @package    Flance_Add_Multiple_Products_order_form_Woocommerce
 * @subpackage Flance_Add_Multiple_Products_order_form_Woocommerce/public/partials
*/



        $html .= $prod_top;
        if ('y' == $params['showimage']) {


            $html .= $row_sep_top;

            $html .= "<td class=\"image\" align=\"center\">";
            if (has_post_thumbnail($id)) {


                $image = get_the_post_thumbnail($id, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                    'title' => 'title',
                    'alt' => 'alt',
                ));

            }

            if ($params['showlink'] == 'y') {
                $html .= "<a href=\"" . $url . "\">

                                " . $image;

                $html .= "</a></td>\n";
            } else {
                $html .= $image . "</td>\n";


            }

            $html .= $row_sep_btm;
        }
        if ('y' == $params['showname']) {


            $html .= $row_sep_top;
            if ($params['showlink'] == 'y') {
                $html .= "<td class=\"product_name\" align=\"center\"><a href=\"" . $url . "\">" . $name . "</a></td>\n";

            } else {
                $html .= "<td class=\"product_name\" align=\"center\">" . $name . "</td>\n";


            }
            $html .= $row_sep_btm;
        }

        if ('y' == $params['showsku']) {
            $html .= $row_sep_top;
            $html .= "<td class=\"product_name\" align=\"center\">" . $sku . "</td>\n";
            $html .= $row_sep_btm;
        }





        if ('y' == $params['attribute']) {
              // $attrib = $this->get_attribute($id);

            if (!empty($attrib)) {
                //   $attrib = $this->get_attribute($id);

            } else {
                //      $attrib = 'No Product attibute';
            }

            // Get product attributes
            $attributes = $product->get_attributes();


            $variations = find_valid_variations($id);
            //  echo "<pre>"; print_r($variations);  echo "</pre>";
             //    $variations = $product->get_available_variations();

           // echo "<pre>"; print_r ($product) ;echo "</pre>";

            $_product = wc_get_product( $id );

            $formatted_attributes = array();


                $available_variations  =  $_product->get_available_variations();
                $attributes            =  $_product->get_variation_attributes();
                $selected_attributes   =  $_product->get_variation_default_attributes();




            foreach ($available_variations as $forv){

                $attr_val = $forv['attributes'] ;



                    foreach($attr_val as $ind=>$ind_val){
                        $avail_vars[$ind][]=$ind_val;

                    }

            }





            if (!$variations) {
                $attrib = "No variations";
            } else {

                $attrib = Null;


                foreach ($attributes as $attribute_name => $attribute) {


                    $attrib .= "<b>" . wc_attribute_label( $attribute_name ) . "</b>: ";

                    $attributes_dropdown = '<select name="' . $id . '=attribute=' . $attribute_name . '"  id="' . $id . '=attribute=' . $attribute_name. '" class="class_var id_' . $id . '" >';

                    foreach ($attribute as $key => $pa) {
                        if (in_array($pa, $avail_vars['attribute_'.$attribute_name])) {

                            if ($key != 0) {
                                // remove empty first space
                                $attributes_dropdown .= '<option value="' . strtolower($pa) . '">' . $pa . '</option>';
                            } else {
                                // first options
                                $attributes_dropdown .= '<option value="' . strtolower($pa) . '">' . $pa . '</option>';

                            }
                        }
                    }

                    $attributes_dropdown .= '</select><br/>';

                    $attrib .= $attributes_dropdown;
                }

            }


            //   print_r ( $attributes);
            $var_attrib = null;
            $unique_id = null;
            unset($unique_id_array);
            foreach ($variations as $key => $value) {
                $var_attrib = null;
                $unique_id = null;
                foreach ($value['attributes'] as $key => $val) {
                    $val = str_replace(array('-', '_'), ' ', $val);
                    $key = str_replace('-', '=', $key);

                    $key_1 = str_replace('attribute_', '', $key);
                    $val_1 = str_replace(' ', '__', $val);

                    $var_attrib .= '<span><input type="hidden" id="' . $id . '=' . $key . '" name="' . $id . '=' . $key . '" value="' . $val . '" />' . wc_attribute_label($key_1) . ': ' . $val . '</span><br/>';
                    $unique_id .= $id . '___' . $key . '___' . $val_1 . '_br_';

                }

                $unique_id_array[]=$unique_id;
            }

            //$attrib = $var_attrib ;
           //  echo "<pre>";            print_r ($unique_id_array);            echo "</pre>";

            $html .= $row_sep_top;

            $html .= "<td class=\"attibute\" align=\"center\">" . $attrib . "</td>\n";

            $html .= $row_sep_btm;
        }


        if( 'y' == $params['showmfk'] ) $html .= "<td class='brands' style='text-align:center;'>".$term_names."</td>\n";

        $html .= "<td class='cats' style='text-align:center;'>".$terms_cat."</td>\n";

        if ('y' == $params['showdesc']) {
            $html .= $row_sep_top;
            $html .= "<td class=\"desc\">" . $desc . "</td>\n";
            $html .= $row_sep_btm;
        }
        if ('y' == $params['instock']) {


            $html .= $row_sep_top;




            if ($product->get_stock_quantity()) {
                $qty = $product->get_stock_quantity();


            } elseif ($product->is_in_stock()) {
                $qty = "in Stock";


            } else {

                $qty = "Out of Stock";
            }

            $html .= "<td class=\"stock\">" . $qty . "</td>\n";


            $html .= $row_sep_btm;
        }


        if ('y' == $params['showprice']) {


            $html .= $row_sep_top;

            $tax = $product_price->get_price_including_tax(1, $product->get_price()) - $product_price->get_price();
            $html .= "<td class=\"price\">" . $value['display_price'] . "</td>\n";
            $html .= '<input type="hidden" value="' . $value['display_price']  . '" name="pricequat" id="pricequa' . $formclass . '_' . $unique_id . '">';
            $html .= '<input type="hidden" value="' . $tax . '" name="pricetax" id="pricetax' . $formclass . '_' . $unique_id . '">';

            $html .= $row_sep_btm;
        }

        if(empty($unique_id)){
            $unique_id = $id;
        }
       // echo "<pre>";    print_r ($unique_id_array); echo "</pre>";
        foreach ($unique_id_array as $uniq){
            $idi[$i] = $uniq;
            $i++;
        }

      // echo "<pre>"; print_r($idi); echo "</pre>";


        if ('y' == $params['showquantity']) {
            if (@$params['quantity'] > -1) {
                $qty = $params['quantity'][0];
            } else {
                $qty = $params['quantity'][0];
            }

            $html .= $row_sep_top;
            $html .= "<td class=\"addtocart\" style='width:70px;'>";

            $html .= '
                                    <div class="qty_box">
                                     <span class="quantity-controls js-recalculate">
                                        <input class="quantity-controls quantity-plus" id="quantity-plus' . $formclass . '_' . $unique_id. '" type="button"  value="+">

                                        </span>
                                         <span class="quantity-box">
                                         <input type="text" value="' . $qty . '" name="quantity[]" id="quantity' . $formclass . '_' . $unique_id . '" size="4" class="quantity-input js-recalculate quantity' . $formclass . '_' . $id . '">
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
        $i++;




?>

         	
				   

		   

	