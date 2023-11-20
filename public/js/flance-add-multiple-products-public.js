var formclass_defined = 'flance';
var flanceformclass = 'flance';
var formclass = 'flance';

jQuery(document).ready(function () {

	function updateCartTotals(totalQttflance, totaltaxflance, formclass_defined, cart) {
		var totalQttflanceFormatted = totalQttflance.toFixed(2);
		var totaltaxflanceFormatted = totaltaxflance.toFixed(2);

		cart.find(".total").val(totalQttflanceFormatted);
		cart.find(".prodtax" + formclass_defined).val(totaltaxflanceFormatted);

		var prodtaxElement = cart.find(".prodtax" + formclass_defined);
		prodtaxElement.html(totaltaxflanceFormatted || "0.00");

		var prodtotalElement = cart.find(".prodtotal" + formclass_defined);
		prodtotalElement.html(totalQttflanceFormatted || "0.00");

		let flancetxt = jQuery('.' + formclass + '_error');
		let flancetxt_1 = cart.find('.' + formclass + '_error_1');

		if (totalQttflance > 0) flancetxt.html("");
		if (totalQttflance > 0) flancetxt_1.html("");
	}

	function calculateTotal(inputs, totalVariable) {
		inputs.each(function () {
			let priceInput = jQuery(this);
			let quantityInput = priceInput.parent().find('.quantity-input');

			if (!isNaN(priceInput.val())) {
				totalVariable += parseFloat(priceInput.val() * parseInt(quantityInput.val()));
			}
		});

		return totalVariable;
	}

	function plus_calculate(plusButton, cart) {

		plusButton = jQuery(plusButton).closest('.qty_box').find('.quantity-input');

		var Qtt = parseInt(plusButton.val());


		if (!isNaN(Qtt)) {
			plusButton.val(Qtt + 1);
			var totalQttflance = 0;
			var totaltaxflance = 0;

			totalQttflance += calculateTotal(cart.find('input[name="pricequat"]'), totalQttflance);
			totaltaxflance += calculateTotal(cart.find('input[name="pricetax"]'), totaltaxflance);

			updateCartTotals(totalQttflance, totaltaxflance, formclass_defined, cart);
		}

	}

	function trugger_calculate(cart) {

		var totalQttflance = 0;
		var totaltaxflance = 0;

		totalQttflance += calculateTotal(cart.find('input[name="pricequat"]'), totalQttflance);
		totaltaxflance += calculateTotal(cart.find('input[name="pricetax"]'), totaltaxflance);
		console.log(totalQttflance);
		updateCartTotals(totalQttflance, totaltaxflance, formclass_defined, cart);
	}

	function minus_calculate(minusButton, cart) {

		minusButton = jQuery(minusButton).closest('.qty_box').find('.quantity-input');
		var Qtt = parseInt(minusButton.val());
		var totaltaxflance = 0;
		var totalQttflance = 0;
		if (!isNaN(Qtt) && Qtt > 0) {
			minusButton.val(Qtt - 1);
			totalQttflance += calculateTotal(cart.find('input[name="pricequat"]'), totalQttflance);
			totaltaxflance += calculateTotal(cart.find('input[name="pricetax"]'), totaltaxflance);
		} else {
			minusButton.val(0);
			totalQttflance += calculateTotal(cart.find('input[name="pricequat"]'), totalQttflance);
			totaltaxflance += calculateTotal(cart.find('input[name="pricetax"]'), totaltaxflance);
		}
		updateCartTotals(totalQttflance, totaltaxflance, formclass_defined, cart);
	}

	var Virtuemartoneflance = {
		allcarts: {},
		flanceaddme: function (form, $) {
			var paramObj = {};
			let carts = $(form);
			let cart = $(form);
			let notSend = ['pricequat', 'pricetax', 'total', 'totaltaxflance'];
			$.each(carts.serializeArray(), function (_, kv) {

				var paramValue = paramObj[kv.name];
				if ($.inArray(kv.name, notSend) !== -1) {
					return;
				}
				let el = carts.find('[name="' + kv.name + '"]');
				let product_id = el.attr('data-id');
				paramObj[product_id] = paramObj[product_id] || {};
				let attribute_name = el.attr('data-attribute_name_slug');
				if (el.is('select')) {
					var parentContainer = el.closest('.flance-variations-form');
					let variation_id = parentContainer.attr('data-variation_id');

					if (variation_id) {
						paramObj[product_id][attribute_name] = paramValue ? paramValue.concat(kv.value) : kv.value;
						paramObj[product_id]['variation_id'] = variation_id;
					}
				} else {
					paramObj[product_id][attribute_name] = paramValue ? paramValue.concat(kv.value) : kv.value;
				}
			});
			var quantityf = 0;
			var ids = [];

			carts.each(function () {

				let cart = jQuery(this);
				let quantityInput = cart.find('.quantity-input');

				quantityInput.each(function () {
					let value = parseFloat(this.value);
					let dataId = $(this).data('id');
					if (!isNaN(value) && value > 0) {
						ids.push(dataId);
					}
					quantityf += value;
				});

				var x = quantityf;
				var errorline = {};

				if (x == null || x == "" || x == 0 || x < 0) {
					let text = "<div id=\"errorstyle\" >Please enter quantity more than 0 at least for one product</div>";
					cart.prev('.' + formclass + '_error').html(text);
					cart.find('.' + formclass + '_error_1').html(text);
					return false;
				} else {
					setTimeout(function () {

						$.ajax({
							url: WPURLS.ajaxurl,
							type: 'POST',
							data: {action: 'flance_amp_add_to_cart', ids: ids, paramObj},
							dataType: 'json',
							beforeSend: function () {
								// $('#wamp_add_order_item_'+formclass).attr('disabled', true);
								console.log("edd");
								cart.find('.wamp_add_order_item_' + formclass).nextAll().remove();
								cart.find('.wamp_add_order_item_' + formclass).after('<img class="wamp_loading_img" style="padding-left: 10px;" src="' + WPURLS.siteurl + 'img/loading.gif"><b class="wamp_loading_text">Please Wait...</b>');

							},
							success: function (results) {

								cart.find('.wamp_add_order_item_' + formclass).attr('disabled', false);
								cart.find('.wamp_add_order_item_' + formclass).nextAll().remove();
								cart.find('.wamp_add_order_item_' + formclass).after('<b class="wamp_loading_text">Successfully Added</b>');

								var redirect = WPURLS.params.redirect;
								var reload = WPURLS.params.reload;
								var redirectlink = WPURLS.params.redirectlink;
								console.log(redirect, reload, redirectlink);
								setTimeout(function () {
									if (redirect == 'y') {
										window.location = redirectlink;
									} else if (reload == 'y') {
										window.location.reload();

									}
								}, 3000);
							}
						})

					}, 1000);
				}
			});
		},
		formsubmit: function ($) {

			$('.wamp_add_order_item_' + formclass).on('click', function () {

				var form = $(this).closest('form[class*="' + formclass + '"]');

				if (form.length > 0) {
					var reload = Virtuemartoneflance.flanceaddme(form, $);
				}
			});
		},
		productone: function (carts) {
			this.allcarts = carts;
			console.log(carts);
			carts.each(function () {

				let cart = jQuery(this),
					addtocart = cart.find('input.addtocart-button'),
					virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val();
				let quantityControls = cart.find('.quantity-controls');

				// Attach the click event listener to .quantity-controls within the current cart
				quantityControls.on('click', function () {
					let isPlusButton = jQuery(this).hasClass('quantity-plus');
					let isMinusButton = jQuery(this).hasClass('quantity-minus');
					if (isPlusButton || isMinusButton) {
						var isPlus = isPlusButton;
						if (isPlus) {
							plus_calculate(this, cart);
						} else {
							minus_calculate(this, cart);
						}
					}
				});

			});

		},
		productonecalculate: function (carts) {
			this.allcarts = carts;
			carts.each(function () {

				let cart = jQuery(this),
					addtocart = cart.find('input.addtocart-button'),
					virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val();

				trugger_calculate(cart);
			});

		},
		totalprice: function (form) {
			return false; // prevent reload
		},
	};
	jQuery.noConflict();
	jQuery(document).ready(function ($) {

		Virtuemartoneflance.productone($("form" + "." + formclass_defined));
		Virtuemartoneflance.formsubmit($);

		table = $(".jshproductsnap").DataTable({
			initComplete: function () {
				this.api().columns().every(function (i) {
					var column = this;

					if (this.header().innerHTML == "Categorye" || "All Categoriese" == this.header().innerHTML) {
						var select = $('<select class="category-filter"><option value="">Category</option></select>')
							.appendTo($(column.header()).empty())
							.on("change", function () {
								var val = $.fn.dataTable.util.escapeRegex($(this).val());

								column
									.search(val ? "^" + val + "$" : "", true, false)
									.draw();
							});

						column.data().unique().sort().each(function (d, j) {
							select.append('<option value="' + d + '">' + d + '</option>');
						});
					}
				});
			}
		});

		$("select.class_var").on("change", function () {

			var quantityflance = "quantity" + formclass_defined;

			var select_name = this.name.split("=");
			var selected = this;
			var select_name_val = quantityflance + "_" + parsing_name(this);

			var selects = $(".id_" + select_name[0]);
			var other_attr = "";
			$.each(selects, function (key, value) {

				if (selected.id != value.id) {

					other_attr += parsing_name(value);


				}
			});

			select_name_val += other_attr;


			console.log(select_name_val);

			$("input." + quantityflance + "_" + select_name[0]).attr("id", select_name_val);

		});

		function parsing_name(sel) {
			var select_name = sel.name.split("=");
			var select_name_val = select_name[0] + "___" + select_name[1] + "_" + select_name[2] + "___" + sel.value + "_br_";

			return select_name_val;
		}

		function variation_select(selected){
				// Get the data attributes of the parent container dynamically
			var parentContainer = $(selected).closest('.flance-variations-form');
			var productId = parentContainer.data('product_id');
			var productVariations = parentContainer.data('product_variations');
			var parentTrContainer = $(selected).closest('tr');
			// Get values of other select elements within the same parent container
			var selectedAttributes = {};
			parentContainer.find('.variation-select').each(function () {
				var selectName = $(this).attr('name');
				var selectValue = $(this).val();
				selectedAttributes[selectName] = selectValue;
			});

			// Find the matching variation_id in productVariations
			var matchingVariation = findMatchingVariation(selectedAttributes, productVariations);

			if (matchingVariation) {
				parentContainer.attr('data-variation_id', matchingVariation.variation_id);
				if (matchingVariation.is_in_stock === true) {
					const flanceStockElement = parentContainer.find('.flance-stock');
					flanceStockElement.css('display', 'block');
					if (matchingVariation.availability_html !== undefined && matchingVariation.availability_html !== '') {
						flanceStockElement.html(matchingVariation.availability_html);
						parentTrContainer.find('.flance-stock-col').html(matchingVariation.availability_html);
						flance_enable_input(parentTrContainer);
					} else {
						flanceStockElement.html('in Stock');
						parentTrContainer.find('.flance-stock-col').html('in Stock');
						parentTrContainer.find('.flance-price-col').html('');
						flance_enable_input(parentTrContainer);
					}

					if (matchingVariation.price_html !== undefined && matchingVariation.price_html !== '') {
						parentTrContainer.find('.flance-price-col').html(matchingVariation.price_html);
						parentTrContainer.find('.flance-regular-price').val(matchingVariation.display_price);
						parentTrContainer.find('.flance-tax-price').val(matchingVariation.display_price);
					} else {
						parentTrContainer.find('.flance-price-col').html('');
						parentTrContainer.find('.flance-regular-price').val('');
						parentTrContainer.find('.flance-tax-price').val('');
					}


				} else {
					parentContainer.find('.flance-stock').css('display', 'none');
					parentTrContainer.find('.flance-stock-col').html('');
					parentTrContainer.find('.flance-price-col').html('');
					parentTrContainer.find('.flance-regular-price').val('');
					parentTrContainer.find('.flance-tax-price').val('');
					flance_disable_input(parentTrContainer);
				}

			} else {
				parentContainer.attr('data-variation_id', '');
				parentContainer.find('.flance-stock').css('display', 'none');
				parentTrContainer.find('.flance-stock-col').html('');
				parentTrContainer.find('.flance-price-col').html('');
				parentTrContainer.find('.flance-regular-price').val('');
				parentTrContainer.find('.flance-tax-price').val('');
				flance_disable_input(parentTrContainer);

			}
			Virtuemartoneflance.productonecalculate($("form" + "." + formclass_defined));
		}

		function flance_disable_input(parentTrContainer) {
			parentTrContainer.find('.qty_box input').prop('disabled', true);
			parentTrContainer.find('.qty_box').addClass('flance-disabled');
		}

		function flance_enable_input(parentTrContainer) {
			parentTrContainer.find('.qty_box input').prop('disabled', false);
			parentTrContainer.find('.qty_box').removeClass('flance-disabled');
		}
		$('.variation-select').on('change', function () {
			variation_select(this);
		});

		$('.variation-select').each(function () {
			variation_select(this);
		});
// Function to find the matching variation based on selected attributes
		function findMatchingVariation(selectedAttributes, productVariations) {

			for (var i = 0; i < productVariations.length; i++) {
				var variation = productVariations[i];
				if (attributesMatch(selectedAttributes, variation.attributes)) {
					return variation;
				}
			}
			return null; // No matching variation found
		}

// Function to check if two sets of attributes match
		function attributesMatch(attributes1, attributes2) {
			const allValuesNotEmpty = Object.values(attributes1).every(value => value !== undefined && value !== null && value !== '');

			if (!allValuesNotEmpty) {
				return false;
			}
			var inputObject = attributes1;

			var outputObject = {};

			for (var key in inputObject) {
				if (inputObject.hasOwnProperty(key)) {

					var modifiedKey = key.replace(/\[\d+\]/, '');


					outputObject[modifiedKey] = inputObject[key];
				}
			}

			attributes1 = outputObject;
			for (const key in attributes2) {
				if (attributes2.hasOwnProperty(key) && (attributes2[key] === undefined || attributes2[key] === null || attributes2[key] == '')) {
					// Check if attributes1 has the key and remove it
					if (attributes1.hasOwnProperty(key)) {
						delete attributes1[key];
					}
				}
			}
			console.log(attributes1);
			for (var key in attributes1) {

				if (attributes1.hasOwnProperty(key) && attributes2.hasOwnProperty(key)) {
					if (attributes1[key] !== attributes2[key]) {
						return false; // Attribute values don't match
					}
				} else {
					return false; // One set of attributes is missing a key
				}
			}
			return true;
		}
	});

});
