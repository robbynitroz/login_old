<!DOCTYPE html>
<html>
	<head>
		<title><?=$hotel_name?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Client Signup Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
		<link href="/css/fb/mob.css" rel="stylesheet" type="text/css" media="all" />

		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=696113500523537';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			$(document).ready(function() {

				$.ajaxSetup({ cache: true });
				$.getScript('//connect.facebook.net/en_US/sdk.js', function(){
					FB.init({
						appId: '696113500523537',
						status: true, // check login status
						oauth: true,
						version: 'v2.8' // or v2.1, v2.2, v2.3, ...
					});
					$('#loginbutton,#feedbutton').removeAttr('disabled');

					FB.Event.subscribe('edge.create', function(response) {

						$.ajax({
							type: 'POST',
							url: 'http://login.com/like.php',
							dataType: 'json',
							data: {likes:1, mac_address: '$macaddress', url: '$fb_url'},
							success: function(response){
								if(response) {
									window.location = 'http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url';
								} else {
									console.log(response);
								}
							}
						});

					});

					FB.Event.subscribe('edge.remove', function(response) {

						$.ajax({
							type: 'POST',
							url: 'http://login.com/like.php',
							dataType: 'json',
							data: {dislikes:1, mac_address: '$macaddress', url: '$fb_url'},
							success: function(response){
								if(response) {
									window.location = 'http://$nasip:64873/login?username=$macaddress&password=$macaddress&dst=$url';
								} else {
									console.log(response);
								}
							}
						});

					});
				});

			});
		</script>

	</head>
<body>

<!--FB SDK-->
	<!-- main -->
<style>
	body {
		background: url("images/<?php echo $GLOBALS['hotel_bg_image']; ?>") no-repeat center center fixed;
		background-color: <?php echo $GLOBALS['bg_color']; ?>;
	}
</style>

	<div class="contact-wthree">
		<a href="#"><p class="terms">terms & conditions ></p></a>

			<h1 class="heading">Go online with WiFi </h1>
			<div class="form-w3step1">
				<div class="social-wrap c">
					<button class="facebook">Connect using Facebook</button>

				</div>

			</div>
		<form action="#" method="post">
			<p class="subtitle fancy"><span>Or use your email</span></p>
			<div class="form-w3step1">

				<input type="email" class="email agileits-btm email-special" name="Email" placeholder="Your email address here">
				<button class="butt"> > </button>
			</div>
		</form>
			<div class="form-w3step1 logo-image">

				<img src="images/logo.png">
			</div>


			<!--<input type="submit" value="SUBMIT">-->
	</div>


	<!-- //main -->

</body>
</html>