<div class="wrap about-wrap">
    <h1><?php printf( __( 'Flance Add Multiple Products order form for Woocommerce Pro %s' ), $this->version ); ?></h1>

    <div class="about-text">
        <?php printf( __( 'Thank you for downloading this product. 
		The Pro vestion of the plugin gives functionality to have the form to add multiple products
		to the cart and calculate in same page
 the total price of the order. Pro version has the functionality to show the product attributes on the page.
		
		For any kind of support please post in forum of flance.info or mail me at <a href="mailto:tutyou1972@gmail.com">tutyou1972@gmail.com</a><br>' ), $this->version ); ?>
    </div>
	<?php 
	
	
	?>
	

    <form method="post" action="options.php">
        <?php settings_fields( 'flance-amp-settings-group' ); ?>
        <?php do_settings_sections( 'flance-amp-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Product Category(s)</th>
                <td>
                    <select id="flance_amp_product_cat" name="flance_amp_product_cat[]" multiple="multiple" required>
                        <optgroup label="<?php _e( 'Please select a product category....', 'flance-add-multiple-products-order-form-woocommerce-pro' )?>">
                            
                            <?php $this->flance_amp_admin_settings_get_product_cats();?>
                        
                        </optgroup>
                    </select>
                    <br>
                    <span class="description"> <code>All Products</code> to show all products.</span>
                </td>
            </tr>
               <tr valign="top">
                <th scope="row">Show Name</th>
                <td>
                    <select id="showname" name="showname"  required>
                
                            <option <?php if (get_option('showname') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showname') == "n") echo "selected"; ?> value="n">No</option>
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the name of the products</code> .</span>
                </td>
            </tr>
			    <tr valign="top">
                <th scope="row">Show Image</th>
                <td>
                    <select id="showimage" name="showimage"  required>
                      
                            
                     <option <?php if (get_option('showimage') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showimage') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the Image of the products</code> .</span>
                </td>
            </tr>
			   <tr valign="top">
                <th scope="row">Show Attribute</th>
                <td>
                    <select id="attribute" name="attribute"  required>
                      
                     <option <?php if (get_option('attribute') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('attribute') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the attribute of the products</code> .</span>
                </td>
            </tr>

            </tr>
            <tr valign="top">
                <th scope="row">Show Manufacture</th>
                <td>
                    <select id="showmfk" name="showmfk"  required>

                        <option <?php if (get_option('showmfk') == "y") echo "selected"; ?> value="y"; >Yes</option>
                        <option <?php if (get_option('showmfk') == "n") echo "selected"; ?> value="n">No</option>



                    </select>
                    <br>
                    <span class="description"> <code>Show the manufacturee of the products. WooCommerce Brands plugin must be activated. please see Plugin URI: https://woocommerce.com/products/brands/</code> .</span>
                </td>
            </tr>
			  <tr valign="top">
                <th scope="row">Show Description</th>
                <td>
                    <select id="showdesc" name="showdesc"  required>
                      
                          <option <?php if (get_option('showdesc') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showdesc') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the Description of the products</code> .</span>
                </td>
            </tr>
			  <tr valign="top">
                <th scope="row">Show SKU</th>
                <td>
                    <select id="showsku" name="showsku"  required>
                      
                         <option <?php if (get_option('showsku') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showsku') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the SKU of the products</code> .</span>
                </td>
            </tr>
		  <tr valign="top">
                <th scope="row">Show PKG</th>
                <td>
                    <select id="showpkg" name="showpkg"  required>
                       <option <?php if (get_option('showpkg') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showpkg') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the Packaging of the products</code> .</span>
                </td>
            </tr>
				  <tr valign="top">
                <th scope="row">Show Price</th>
                <td>
                    <select id="showprice" name="showprice"  required>
                      
                     <option <?php if (get_option('showprice') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showprice') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the Price of the products</code> .</span>
                </td>
            </tr>
	  <tr valign="top">
                <th scope="row">Show quantity</th>
                <td>
                    <select id="showquantity" name="showquantity"  required>
                       <option <?php if (get_option('showquantity') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showquantity') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the quantity of the products</code> .</span>
                </td>
            </tr>
		  <tr valign="top">
                <th scope="row">Show link</th>
                <td>
                    <select id="showlink" name="showlink"  required>
                       <option <?php if (get_option('showlink') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showlink') == "n") echo "selected"; ?> value="n">No</option>
                        
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the quantity of the products</code> .</span>
                </td>
            </tr>	
			  <tr valign="top">
                <th scope="row">Show In Stock </th>
                <td>
                    <select id="instock" name="instock"  required>
                 <option <?php if (get_option('instock') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('instock') == "n") echo "selected"; ?> value="n">No</option>
                     
                    </select>
                    <br>
                    <span class="description"> <code>Show In Stock Column</code> .</span>
                </td>
            </tr>
	  <tr valign="top">
                <th scope="row">Show Add to cart</th>
                <td>
                    <select id="showaddtocart" name="showaddtocart"  required>
                 <option <?php if (get_option('showaddtocart') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('showaddtocart') == "n") echo "selected"; ?> value="n">No</option>
                          
                         
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Show the Add to cart button</code> .</span>
                </td>
            </tr>
		<tr valign="top">
                <th scope="row">Redirection to the link</th>
                <td>
                    <select id="redirect" name="redirect"  required>
                 <option <?php if (get_option('redirect') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('redirect') == "n") echo "selected"; ?> value="n">No</option>
                          
                         
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Redirection to the link after click submit button, please put redirection link below</code> .</span>
                </td>
            </tr>
				<tr valign="top">
                <th scope="row">Redirection Link</th>
                <td>
                    <input id="redirectlink" name="redirectlink"
                value = "<?php echo get_option('redirectlink');?>">
					<br>
                    <span class="description"> <code>Redirection link is mandatory if Redirection to the link option in Yes option </code> .</span>
                </td>
            </tr>
              <tr valign="top">
                <th scope="row">Reload</th>
                <td>
                    <select id="redirect" name="reload"  required>
                 <option <?php if (get_option('reload') == "y") echo "selected"; ?> value="y"; >Yes</option>
                            <option <?php if (get_option('reload') == "n") echo "selected"; ?> value="n">No</option>
                          
                         
                        
                      
                    </select>
                    <br>
                    <span class="description"> <code>Reload page after clicking submit button and ajax submission of forms Data. This "Reload" option does not work if Redirect to the link is in "Yes" option. because you should choose beetwen redirect page to cart or checkout or stay in same oage after ajax submission</code> .</span>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Split/separate show of products variations as sub products</th>
                <td>
                    <select id="splitchild" name="splitchild"  required>
                        <option <?php if (get_option('splitchild') == "y") echo "selected"; ?> value="y"; >Yes</option>
                        <option <?php if (get_option('splitchild') == "n") echo "selected"; ?> value="n">No</option>




                    </select>
                    <br>
                    <span class="description"> <code>Split/separate show of products variations as sub products pls see demo <a href="http://flance.info/multi/test/"> Demo site show Mulptiple product show </a></code> .</span>
                </td>
            </tr>



       

        </table>
		 Comments: By putting the shortcode parameters prod_cat (product categories) or product_ids (product ids)<br/> 
			 as example: <br/>
			 [flance_products_form product_ids=99,96,93]
			 or <br/>
			  [flance_products_form prod_cat=15] <br/>
			  the form will show the products with ids 99,96,93
			  or the products from the category with id=15 <br/>
			  In otherwords, the shortcode's parameters' values prioritized.
			  
			 

        <?php submit_button(); ?>

    </form>
</div>