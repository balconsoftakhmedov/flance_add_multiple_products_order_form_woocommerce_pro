<?php 

/**
 * The plugin bootstrap file
 *
 *
 * @link              http://www.flance.info
 * @since             1.1.4
 * @package           Flance_Add_Multiple_Products_order_form_Woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Flance Add Multiple Products order form for Woocommerce
 * Description:       The plugin gives functionality to have the form to add multiple products to the cart and calculate in same page the total price of the order. And you also can use shortcode to use the plugin other places. Just place the shortcode where you wanna put the input form and it's done !!! Pro vesrion has the functionality to show the product attributes on the page non commercial version does not have attribute show functionality. 
 * Version:           1.1.3
 * Author:            Rusty 
 * Author URI:        http://www.flance.info
 * Text Domain:       flance-add-multiple-products-order-form-woocommerce
 * Domain Path:       /languages
 */

 $html .=   '<script type="text/javascript">
//<![CDATA[

  (function( $ ) {
	            var '.$formclass.'formclass = \''.$formclass.'\';

                 //formclassobject[0] = \''.$formclass.'\';

                var formclass = \''.$formclass.'\';
                //'.$formclass.'addme ('.$formclass.'formclass);

                $(\'.wamp_add_order_item_\'+formclass).on(\'click\', function(){

                        theForms = document.getElementsByTagName("form");
                        var reload= "no";
                        for(i=0;i<theForms.length;i++){

                        if (theForms[i].id.indexOf("flance") >= 0){

                            formclass = theForms[i].id;

                            reload = window[formclass+\'addme\'](formclass);

                        }

                }
});



        this.'.$formclass.'addme =function (formclass){
        var paramObj = {};

        $.each($(\'#\'+formclass).serializeArray(), function(_, kv) {


          if (paramObj.hasOwnProperty(kv.name)) {
            paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
            paramObj[kv.name].push(kv.value);
          }
          else {
            paramObj[kv.name] = kv.value;
          }


        });


         var quantityf = 0;
          var ids = {};   ';

    foreach($idi as $k=>$value) {
     $html .=   '




             if($("#quantity"+formclass+"_'.$value.'").length ){


                     quantityf += parseFloat(document.getElementById ("quantity"+formclass+"_'.$value.'").value);
                      qty =   parseFloat(document.getElementById ("quantity"+formclass+"_'.$value.'").value)

                      if (qty > 0){



                        ids["'.$value.'"] =qty;
                        qty=0;
                      }



                }

     ';

      }

$html .=   '
   


var x=quantityf;

var errorline = {};



if (x==null || x=="" || x==0 || x<0)
  {
 
   errorline[\''.$formclass.'txt\']=document.getElementById(formclass+"error");
    errorline[\''.$formclass.'txt_1\']=document.getElementById(formclass+"error_1");
   errorline[\''.$formclass.'txt\'].innerHTML="<div id=\"errorstyle\" >Please enter quantity more than 0 at least for one product</div>";
   errorline[\''.$formclass.'txt_1\'].innerHTML="<div id=\"errorstyle\" >Please enter quantity more than 0 at least for one product</div>";

  return false;
  }else{
setTimeout(function() {

  $.ajax({
			url: WPURLS.ajaxurl,
			type:\'POST\',
			data:{ action: \'flance_amp_add_to_cart\', ids: ids,paramObj },
			dataType: \'json\',
			beforeSend: function() {
				// $(\'#wamp_add_items_button_\'+formclass).attr(\'disabled\', true);
				$(\'#wamp_add_items_button_\'+formclass).nextAll().remove();
				$(\'#wamp_add_items_button_\'+formclass).after(\'<img class="wamp_loading_img" style="padding-left: 10px;" src="\' + WPURLS.siteurl + \'img/loading.gif"><b class="wamp_loading_text">Please Wait...</b>\');
			
			
			},
			success:function(results){
				
				';
				
				global $woocommerce;
$cart_url = $woocommerce->cart->get_cart_url();
//$html .= 'window.location = "'.$cart_url.'"; // for redirection to the cart
$html .= '
$(\'#wamp_add_items_button_\'+formclass).attr(\'disabled\', false);
$(\'#wamp_add_items_button_\'+formclass).nextAll().remove();
$(\'#wamp_add_items_button_\'+formclass).after(\'<b class="wamp_loading_text">Successfully Added</b>\');


var redirect = \''.$params['redirect'].'\';
var reload = \''.$params['reload'].'\';
var redirectlink = \''.$params['redirectlink'].'\';	

	
setTimeout(function() {
if (redirect == \'y\') {
	


window.location =	redirectlink;

	
}else if(reload == \'y\'){
 window.location.reload() ;	
	
}



}, 4000);			


		}
		})
		
		}, 1000);


  }
			}
		
		
		})( jQuery );




            var Virtuemartone'.$formclass.' = {
	        productone : function(carts) {
				carts.each(function(){
					var cart = jQuery(this),
					addtocart = cart.find(\'input.addtocart-button\'),';
                                        
                 
                    foreach($idi as $k=>$value) {
                        $html .= 'plus' . $value . '   = cart.find(\'#quantity-plus' . $formclass . '_' . $value . '\'),
                        minus' . $value . '  = cart.find(\'#quantity-minus' . $formclass . '_' . $value . '\'),
                                quantity' . $value . ' = cart.find(\'#quantity' . $formclass . '_' . $value . '\'),
                                pricequa' . $value . ' = cart.find(\'#pricequa' . $formclass . '_' . $value . '\'),
                           pricetax' . $value . ' = cart.find(\'#pricetax' . $formclass . '_' . $value . '\'),
                                ';

                    }

                            $html .=   '


                                        virtuemart_product_id = cart.find(\'input[name="virtuemart_product_id[]"]\').val();
                ';
                                        
                                        
        foreach($idi as $k=>$value) {

                $html .=   '
                            plus'.$value.'.click(function() {


                            var Qtt = parseInt(quantity'.$value.'.val());


                            if (!isNaN(Qtt)) {
                                quantity'.$value.'.val(Qtt + 1);
                                                            var totalQtt'.$formclass.' = 0;
                                                           var totaltax'.$formclass.' = 0;

                                                            ';

                                                  foreach($idi as $r=>$prodis) {


                                                   $html .=   '

                                                   if(!isNaN(pricequa'.$prodis.'.val())){

                                                    totalQtt'.$formclass.' += parseFloat(pricequa'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val()));
                                                   totaltax'.$formclass.' += parseFloat(pricetax'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val()));

                                                   }


                                                   ';
                                                      }
                                               $html .=   '
                                                           jQuery("#total").val(
                                                           totalQtt'.$formclass.'.toFixed(2)
                                                          );
                                                           jQuery("#totaltax'.$formclass.'").val(
                                                           totaltax'.$formclass.'.toFixed(2)
                                                          );
                                                        if (totaltax'.$formclass.' >0) {
                            cart.find("#prodtax'.$formclass.'").html(totaltax'.$formclass.'.toFixed(2));

                                                    }else {
                                                     cart.find("#prodtax'.$formclass.'").html("0.00");

                                                        }


                                                         if (totalQtt'.$formclass.' >0) {
                                                      cart.find("#prodtotal'.$formclass.'").html(totalQtt'.$formclass.'.toFixed(2));// total pricequa
                                 var '.$formclass.'txt=document.getElementById("'.$formclass.'error"); // remove error notice for zero total value
                        var '.$formclass.'txt_1=document.getElementById("'.$formclass.'error_1");
                      '.$formclass.'txt.innerHTML="";
                      '.$formclass.'txt_1.innerHTML="";


                                                        }else{

                                                       cart.find("#prodtotal'.$formclass.'").html("0.00");

                                                          }
                            }

                        });
                                                minus'.$value.'.click(function() {
                            var Qtt = parseInt(quantity'.$value.'.val());
                            var totaltax'.$formclass.' = 0;
                                                    var totalQtt'.$formclass.' = 0;
                                                    if (!isNaN(Qtt) && Qtt>0) {
                                quantity'.$value.'.val(Qtt - 1);


                                                              ';
                                                  foreach($idi as $r=>$prodis) {

                                                   $html .=   '
                                                    if(!isNaN(pricequa'.$prodis.'.val())){
                                                        totalQtt'.$formclass.' += pricequa'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val());
                                                        totaltax'.$formclass.' += parseFloat(pricetax'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val()));
                                                    }

                                                   ';
                                                      }
                                               $html .=   '


                                                              jQuery("#total").val(
                                                           totalQtt'.$formclass.'.toFixed(2)
                                                          );
                                                           jQuery("#totaltax'.$formclass.'").val(
                                                           totaltax'.$formclass.'.toFixed(2)
                                                          );
                            } else {

                                                        quantity'.$value.'.val(0) ;
                                                           ';
                                                  foreach($idi as $r=>$prodis) {

                                                   $html .=   '
                                                    totalQtt'.$formclass.' += pricequa'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val());
                                                    totaltax'.$formclass.' += parseFloat(pricetax'.$prodis.'.val()*parseInt(quantity'.$prodis.'.val()));


                                                   ';
                                                      }
                                               $html .=   '
                                                           jQuery("#total").val(
                                                           totalQtt'.$formclass.'.toFixed(2)
                                                          );
                                                           jQuery("#totaltax'.$formclass.'").val(
                                                           totaltax'.$formclass.'.toFixed(2)
                                                          );
                                                        }



                                                     if (totaltax'.$formclass.' >0) {
                            cart.find("#prodtax'.$formclass.'").html(totaltax'.$formclass.'.toFixed(2));

                                                    }else {
                                                     cart.find("#prodtax'.$formclass.'").html("0.00");

                                                        }

                                                       if (totalQtt'.$formclass.' >0) {
                                                      cart.find("#prodtotal'.$formclass.'").html(totalQtt'.$formclass.'.toFixed(2));

                                                        }else{

                                                       cart.find("#prodtotal'.$formclass.'").html("0.00");

                                                          }
                        });

                    ';

                                 }
                      $html .=   ' });

                },
                        	productcal : function(carts) {
				carts.each(function(){
					var cart = jQuery(this),
					addtocart = cart.find(\'input.addtocart-button\'),';
                                        
                                        
    foreach($idi as $k=>$value) {
        $html .= 'plus' . $value . '   = cart.find(\'#quantity-plus' . $value . '\'),
		minus' . $value . '  = cart.find(\'#quantity-minus' . $value . '\'),
                quantity' . $value . ' = cart.find(\'#quantity' . $value . '\'),
                pricequa' . $value . ' = cart.find(\'#pricequa' . $value . '\'),
           pricetax' . $value . ' = cart.find(\'#pricetax' . $value . '\'),
                ';

    }
					
			$html .=   '	
                        
                        
                        virtuemart_product_id = cart.find(\'input[name="virtuemart_product_id[]"]\').val();


                  ';

                                        
    foreach($idi as $k=>$value) {

        $html .= '
                   
                                        	
						var Qtt = parseInt(quantity' . $value . '.val());
						if (!isNaN(Qtt) && Qtt>0) {
							quantity' . $value . '.val(Qtt);
                                                          var totalQtt' . $formclass . ' = 0;
                                                           var totaltax' . $formclass . ' = 0;
                                                          ';
        foreach ($idi as $r => $prodis) {

            $html .= '
                                                totalQtt' . $formclass . ' += pricequa' . $prodis . '.val()*parseInt(quantity' . $prodis . '.val());
                                                totaltax' . $formclass . ' += parseFloat(pricetax' . $prodis . '.val()*parseInt(quantity' . $prodis . '.val()));
                                              
                                               
                                               ';
        }
        $html .= '
                                                          jQuery("#total").val(
                                                       totalQtt' . $formclass . '.toFixed(2)
                                                      );  
                                                       jQuery("#totaltax' . $formclass . '").val(
                                                       totaltax' . $formclass . '.toFixed(2)
                                                      ); 
						} else { 
                                                    
                                                    quantity' . $value . '.val(0) ;
                                                      
                                                    
                                                    }
                                                if (totaltax' . $formclass . ' >0) {
						    cart.find("#prodtax' . $formclass . '").html(totaltax' . $formclass . '.toFixed(2));
                                                
                                                }else {
                                                 cart.find("#prodtax' . $formclass . '").html("0.00");
                                                  
                                                    }
                                                    
                                                    if (totalQtt' . $formclass . ' >0) {
                                                  cart.find("#prodtotal' . $formclass . '").html(totalQtt' . $formclass . '.toFixed(2));
                                                
                                                    }else{
                                                      
                                                   cart.find("#prodtotal' . $formclass . '").html("0.00");
                                                   
                                                      }
				
				';

    }
				  $html .=   ' });

			},
                       totalprice : function (form) {
				
				
				return false; // prevent reload
			}, 
                        
                        
                        
                        };
        jQuery.noConflict();
		jQuery(document).ready(function($) {
                  
			Virtuemartone'.$formclass.'.productone($("form.'.$formclass.'"));
			
			
		
                //        Virtuemartone'.$formclass.'.productcal($("form.'.$formclass.'"));


              table=$("#jshproductsnap").DataTable( {

                        initComplete: function () {

                            this.api().columns().every( function (i) {
                                var column = this;
                                console.log (this.header().innerHTML);

                                if (this.header().innerHTML == "Category") {
                                        var select = $(\'<select><option value="">Category</option></select>\')
                                            .appendTo( $(column.header()).empty() )
                                            .on( "change", function () {
                                                var val = $.fn.dataTable.util.escapeRegex(
                                                        $(this).val()
                                                    );

                                                column
                                                .search( val ? "^"+val+"$" : "", true, false )
                                                .draw();
                                            } );

                                        column.data().unique().sort().each( function ( d, j ) {
                                            select.append( \'<option value="\'+d+\'">\'+d+\'</option>\' )
                                                } );
                                 }

                             } );

                        }
             });
 
				$("select.class_var").on("change", function() {

                        var quantityflance =  "quantity' . $formclass.'";

                        var select_name = this.name.split("=");
                        var selected = this;
                        var select_name_val = quantityflance+"_"+parsing_name(this);

                        var selects = $(".id_"+select_name[0]) ;
                        var  other_attr = "";
                        $.each( selects, function( key, value ) {

                             if(selected.id != value.id){

                               other_attr +=  parsing_name(value);


                             }
                        });

                        select_name_val += other_attr;


                        console.log(  select_name_val);

                      $ ("input."+quantityflance+"_"+select_name[0]).attr ("id", select_name_val);

                });

                function parsing_name(sel){
                     var select_name = sel.name.split("=");
                    var select_name_val = select_name[0]+"___"+select_name[1]+"_"+select_name[2]+"___"+sel.value+"_br_";

                    return select_name_val;
                }
		});


//]]>
</script>';

?>