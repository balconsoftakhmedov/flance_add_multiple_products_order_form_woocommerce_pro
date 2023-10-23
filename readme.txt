=== Flance Add Multiple Products order form for Woocommerce Pro ===
Contributors: flance
Tags: woocommerce, add-to-cart, ajax, cart, shopping-cart, addin multiple products to the carts
Requires at least: 3.5.1
Tested up to: 4.6.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Pro vestion of the plugin gives functionality to have the form to add multiple products to the cart and calculate in same page
 the total price of the order. Pro version has the functionality to show the product attributes on the page.
 and add the product attributes to the cart.
== Description ==
The plugin gives functionality to have the form to add multiple products to the cart and calculate in same page the total 
price of the order.
And you also can use shortcode to use the plugin other places. Just place the shortcode where 
you wanna put the input form and it's done !!!
Pro vesrion has the functionality to show the product attributes on the page non commercial version does not have 
attribute show functionality. 


= Features =

* Adding the multiple products to order and submit to the cart
* Same page order total price calculation
*	Selecting the quantity of product in the form and recalculation
* Showing the Products from desired category .
* Showing the product with selected ids
* Multiple product categories select option.
* Shortcode for showing the form elsewhere.
* Widget for placing the form in any kind of sidebar.
* Fully translation ready.
* Ajax enabled product adding to the cart.
* show attributes and product attributes to the cart
* Very easy to use.

= Shortcode =

[flance_products_form product_ids=99,96,93 prod_cat=15]
product_ids is Product ids to show in form.
prod_cat is Products Category Id to show the product from the category in the form.

Comment: Shortcode parameter product_ids is prioritized. Which means that if we have two parameters in shortcode
like [flance_products_form product_ids=99,96,93 prod_cat=15 ] the products with ids 99,96,93 will be shown in the form.
Therefore, if you want to show the products from category you should not use the parameter product_ids.
form id can be added by parameter form_id example [flance_products_form product_ids=99,96,93 form_id=1 ]


== Installation ==

1. Upload `flance-add-multiple-product` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress



== Screenshots ==

1. Products Forms Page.
2. Settings page. You can change or set the necessary settings form this page.


== Changelog ==

= 1.1.3 =
* Initial version.

= 1.1.3 =
* Multiple forms supported , multiple shortcode usage is enabled now
* Products display by category id is supported 

= 1.1.4 =

* added sorting, searching, category filtering
* splitting products by product attributes

= 1.1.5 =

* added select dropdown and splitting options

= 1.1.6 =

* Checked with latest Wordpress 6.2.2 and Woocommerce

