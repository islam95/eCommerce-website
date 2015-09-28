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
				refresh();
			}
		});
		return false;
	}
	
	
	function refresh() {
		$.ajax({
			url: 'modules/refresh.php',
			dataType: 'json',
			
			success: function (data) {
				console.log(data); // checking if it works.
				$.each(data, function(k, v) {
					$("#basket_right ." + k + " span").text(v);
				});
			},
			error: function(data) {
				alert("Error in refresh function.");
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
	
	
	if ($(".addToBasket").length > 0) {
		$(".addToBasket").click(function() {
			
			var trigger = $(this);
			var parameter = trigger.attr("rel");
			var i = parameter.split("_");
			
			$.ajax({
				type: 'POST',
				url: 'modules/basket.php',
				dataType: 'json',
				data: ({ id : i[0], job : i[1] }),
				success: function(data) {
					var newOne = i[0] + '_' + data.job;
					if (data.job != i[1]) {
						if (data.job == 0) {
							trigger.attr("rel", newOne);
							trigger.removeClass("buyB");
							trigger.addClass("removeB");
							
						} else {
							trigger.attr("rel", newOne);
							trigger.removeClass("removeB");
							trigger.addClass("buyB");
						}
						refresh();
					}
				},
				error: function(data) {
					alert("Error..");
				}
			});
			return false;
			
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
					refresh();
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