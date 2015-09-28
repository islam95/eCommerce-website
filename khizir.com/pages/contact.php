<?php

require_once('header.php');
include_once("offerSection.php");
require_once('navigation.php');
require_once('sidebar.php');	

?>
<!-- Google mapse API for the address of company-->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
	var map;
	function initialize() {
	
		var mapOptions = {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.DEFAULT,
				position: google.maps.ControlPosition.DEFAULT
			},
			zoom: 16,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.DEFAULT,
				position: google.maps.ControlPosition.DEFAULT
			},
			panControl: false,
			streetViewControl: false,
			scaleControl: false,
			overviewMapControl: false,
			center: new google.maps.LatLng(51.52493677805769, -0.09798577993467461)
		};
		
		map = new google.maps.Map(document.getElementById('google_maps'),
			mapOptions);
		
		var icon = {
			path: 'M16.5,51s-16.5-25.119-16.5-34.327c0-9.2082,7.3873-16.673,16.5-16.673,9.113,0,16.5,7.4648,16.5,16.673,0,9.208-16.5,34.327-16.5,34.327zm0-27.462c3.7523,0,6.7941-3.0737,6.7941-6.8654,0-3.7916-3.0418-6.8654-6.7941-6.8654s-6.7941,3.0737-6.7941,6.8654c0,3.7916,3.0418,6.8654,6.7941,6.8654z',
			anchor: new google.maps.Point(16.5, 51),
			fillColor: '#FF0000',
			fillOpacity: 0.6,
			strokeWeight: 0,
			scale: 0.66
		};
		
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(51.52493677805769, -0.09798577993467461),
			map: map,
			icon: icon,
			title: 'marker'
		});
	}
	
	google.maps.event.addDomListener(window, 'load', initialize);
	
</script>

<div id="contact_us">
    <h2>Contact us</h2>
    <form action="?page=email_form" method="post" name="form1" class="contact_form">
        <label for="name"></label>
        <input name="name" type="text" required id="name" placeholder="Name" size="50">
        <br>
        <br>
        <label for="email"></label>
        <input name="email" type="email" required id="email" placeholder="Email" size="50">
        <br>
        <br>
        <label for="comments"></label>
        <textarea name="comments" cols="55" required id="comments" placeholder="Comments"></textarea>
        <br>
        <br>
        <input type="submit" name="submit" id="submit" value="Submit">
    </form> 
</div>

<!-- Actually tweets by me! -->
<div class="twitter">
	<a class="twitter-timeline" href="https://twitter.com/id_895" 
		data-widget-id="597536460284293120">Tweets by khizir.com</a> 
		
	 <!-- Connection to Twitter on contact page where visitors leave their comments
	so they can see the twitter account of the website and follow.
	-->
	<script>
		!function(d,s,id){
			var js,fjs=d.getElementsByTagName(s)[0],
			p=/^http:/.test(d.location)?'http':'https';
			if(!d.getElementById(id)){
				js=d.createElement(s);
				js.id=id;
				js.src=p+"://platform.twitter.com/widgets.js";
				fjs.parentNode.insertBefore(js,fjs);
			}
		}
		(document,"script","twitter-wjs");
	</script>
</div>
	
<div class="company_details">
	<strong><?php echo $company['name']; ?></strong><br /><br />
	Address:<br />
	<?php echo Check::encodeHtml($company['address'], 2); ?><br />
	Phone: <?php echo $company['phone']; ?><br /><br />
	Email: <?php echo $company['email']; ?>
</div>

<!-- Google Map -->
<div id="google_maps"></div>
 
 
<?php require_once('footer.php'); ?>