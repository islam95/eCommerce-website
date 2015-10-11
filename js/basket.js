$(document).ready(function() {
	
	initialise();
	
	// methods for clicking update button or Enter key in a keyboard.
	function initialise() {
		// if there is such class.
		if($('.removeItem').length > 0) {
			$('.removeItem').bind('click', removeItem);
		}
		if($('.update').length > 0) {
			$('.update').bind('click', update);
		}
		if($('.input_qty').length > 0){
			$('.input_qty').bind('keypress', function(element){
				// For different browsers. Firefox uses "which"
				var key = element.keyCode ? element.keyCode : element.which;
				// 13 is "Enter" key in a keyboard.
				if (key == 13) {
					update();
				}
			});
		}
	}
	
	
	function removeItem(){
		var product = $(this).attr('rel');
		$.ajax({
			type:'POST',
			url: 'modules/remove.php',
			dataType: 'html',
			data: ({ id: product }),
			success: function() {
				refreshCart();
				refreshSmallBasket();
			}
		});
		return false;
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
				alert("Error in refreshSmallBasket function.");
			}
		});
	
	}
	
	
	// Viewing the main basket, it just views the basket using ajax, but does not store anything.
	function refreshCart(){
		$.ajax({
			url: 'modules/view.php',
			dataType: 'html',
			success: function(data) {
				$('#cart').html(data);
				initialise();
			},
			error: function(data){
				alert('Error in refreshCart function.')
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
					alert("Error occured in AJAX call for add_to_basket.");
				}
			});
			return false; // so that the page does not scroll up or down when clicking the buttons
			
		});
	}
	
	
	function update(){
		$('#basket_form input').each(function() {
			// splits the name with "-" as in qty name in basket.
			var qID = $(this).attr('id').split('-'); 
			var number = $(this).val(); // the value that hold this: qty.
			$.ajax({
				type: 'POST',
				url: 'modules/qty.php',
				data: ({ id: qID[1], qty: number }),
				success: function() {
					console.log("If you see this then update() method works fine! ");
					refreshSmallBasket();
					refreshCart();
				},
				error: function(){
					alert('ERROR in update function!');
				}
			});
		});
	}
	
	
	// Proceeding to PayPal.
	if($('.paypal').length > 0){
		$('.paypal').click(function(){
			var aToken = $(this).attr('id');
			var loading = "<div class=\"load\">";
			loading = loading + "<p class=\"loading\"></p>";
			loading = loading + "<p>Redirecting to PayPal...</p>";
			loading = loading + "</div>";
			loading = loading + "<div id=\"_paypal\"></div>";
			
			$('#cart').fadeOut(200, function(){
				$(this).html(loading).fadeIn(200, function(){
					paypal(aToken);
				});
			});
			
		});
	}

	 
	
	function paypal(aToken){
		$.ajax({
			type: 'POST',
			url: 'modules/paypal.php',
			data: ({ aToken : aToken }),
			dataType: 'html',
			success: function(data){
				$('#_paypal').html(data);
				// Submitting form automatically.
				$('.formPayPal').submit();	
			},
			error: function(){
				alert("Error occurred in a paypal function.");
			}
		});
	}
	
	

	
});






