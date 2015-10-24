$(document).ready(function() {
	
	// Execute this function when a document is loaded.
	initialize();
	
	// Method for clicking update button or Enter key in a keyboard.
	// Initializing all the bindings: click bindings and key presses for specific element on the page. 
	// Relates to css classes for update, remove and input quentity in pages/basket.php and classes/Basket.php
	function initialize() {
		// if there is such class.
		if($('.remove_item').length > 0) {
			$('.remove_item').bind('click', removeFromBasket);
		}
		if($('.update_basket').length > 0) {
			$('.update_basket').bind('click', updateBasket); // Once this element is clicked execute function "updateBasket"
		}
		if($('.input_qty').length > 0){
			$('.input_qty').bind('keypress', function(element){
				// For different browsers. Firefox uses "which". Internet Explorer uses "keyCode"
				var key = element.keyCode ? element.keyCode : element.which;
				// 13 is "Enter" key on a keyboard.
				if (key == 13) {
					updateBasket();
				}
			});
		}
	}
	
	// Method to remove the product from the basket after clicking the red cross
	function removeFromBasket(){
		var product = $(this).attr('rel');
		$.ajax({
			type:'POST',
			url: 'modules/basket_remove.php',
			dataType: 'html',
			data: ({ id: product }),
			success: function() {
				refreshCart();
				refreshSmallBasket();
			}
		});
		return false;
	}

	// Method for updating the main basket after the change of the quantity in a basket.
	function updateBasket(){
		// for each loop
		$('#basket_form input').each(function() {
			// splits the name with "-" as in qty name in basket.php
			// qty_id[1] - is the "id" of the product
			var qty_id = $(this).attr('id').split('-'); // assign the "id" of "input" field
			// populating the value from the "input" field in main basket
			var value = $(this).val(); // the value that holds this: qty.
			$.ajax({
				type: 'POST',
				url: 'modules/basket_qty.php',
				// qty_id[1] - is the "id" of the product
				data: ({ id: qty_id[1], qty: value }),
				success: function() {
					//console.log("If you see this then updateBasket() method works fine! ");
					refreshSmallBasket();
					refreshCart();
				},
				error: function(){
					alert('ERROR in updateBasket() function!');
				}
			});
		});
	} 
	
	//Refreshing the small basket. Updates the content of small basket when add to basket or remove is clicked
	function refreshSmallBasket() {
		$.ajax({
			url: 'modules/basket_small_refresh.php',
			dataType: 'json',
			success: function (data) {
				//console.log(data); // checking if it works.
				$.each(data, function(k, v) {
					// Fill in values in small basket - /modules/basket_small.php
					$("#basket_small ." + k + " span").text(v);
				});
			},
			error: function(data) {
				alert("Error in refreshSmallBasket() function.");
			}
		});
	
	}
	
	// Viewing the main basket, it just views the basket using ajax, but does not store anything.
	function refreshCart(){
		$.ajax({
			url: 'modules/basket_view.php',
			dataType: 'html',
			success: function(data) {
				//Replace the current basket with the new one - modules/basket_view.php
				$('#cart').html(data); //#cart - div in pages/basket.php that wraps the whole basket.
				//assigning all the binding again after ajax call.
				initialize();  //if we do not do this, user will not be able to do anything on the page.
			},
			error: function(data){
				alert('Error in refreshCart() function.')
			}
		});
		
	}
	
	// AJAX call for Add to basket and Remove buttons for updating small basket without reloading.
	// Relates to a method activeButton() in Basket.php
	if ($(".add_to_basket").length > 0) {
		$(".add_to_basket").click(function() {
			
			var trigger = $(this); // assigning the Add to basket link to a trigger
			var parameter = trigger.attr("rel"); // rel stores the session_id "_" and id that is generated for the buttons - Basket.php -> activeButton
			var i = parameter.split("_"); // splitting the value populated from the rel attribute with the "_"
			
			$.ajax({
				type: 'POST', // sending the request to specific file using POST method
				url: 'modules/basket.php', // the file to which we are sending this using POST 
				dataType: 'json',
				data: ({ id : i[0], job : i[1] }), // data that we are sending using POST
				success: function(data) {
					//Relates to a method /modules/basket.php file.
					var new_id = i[0] + '_' + data.job;
					if (data.job != i[1]) {
						if (data.job == 0) {
							trigger.attr("rel", new_id);
							trigger.text("Remove");
							trigger.addClass("remove_btn");
							
						} else {
							trigger.attr("rel", new_id);
							trigger.text("Add to basket");
							trigger.removeClass("remove_btn");
						}
						refreshSmallBasket();
					}
				},
				error: function(data) {
					alert("Error occurred in AJAX call for add_to_basket().");
				}
			});
			return false; // so that the page does not scroll up or down when clicking the buttons
		});
	}
	
	// Proceeding to PayPal button.
	if($('.paypal').length > 0){ //if paypal class found
		$('.paypal').click(function(){ //by clicking on it execute the function
			// replacement for checkout page
			var token = $(this).attr('id');
			var loading = "<div style=\"text-align:centre\">";
			loading = loading + "<img src=\"images/loading.gif\"";
			loading = loading + " alt=\"Redirecting to PayPal\" />";
			loading = loading + "<br>Redirecting to PayPal...";
			loading = loading + "</div><div id=\"paypal_form\"></div>";
			
			$('#cart').fadeOut(200, function(){
				$(this).html(loading).fadeIn(200, function(){
					paypal(token);
				});
			});

		});
	}

	// Sending data to PayPal.
	function paypal(token){
		$.ajax({
			type: 'POST',
			url: 'modules/paypal.php',
			data: ({ token : token }),
			dataType: 'html',
			success: function(data){
				$('#paypal_form').html(data);
				// Submitting form automatically.
				$('#formPP').submit();	
			},
			error: function(){
				alert("Error occurred in a paypal() function.");
			}
		});
	}
	
	
	
});


