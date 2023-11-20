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
$prod_cat_atts = shortcode_atts( array(
	
		'prod_cat' => '',
), $atts );

$product_ids = shortcode_atts( array(
	
		'product_ids'=>'',
), $atts );
$form_id = shortcode_atts( array(
	
		'form_id'=>'',
), $atts );

$html = $this->flance_amp_get_products($product_ids,$prod_cat_atts, $form_id);