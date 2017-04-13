<!DOCTYPE html>
<html>
	<head>
		<title><?=$hotel_name?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Client Signup Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs  Sign up Web Templates, Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
		<link href="/css/fb/mob.css" rel="stylesheet" type="text/css" media="all" />

		<script src="../js/jquery.min.js"></script>
		<script src="../js/script.js"></script>

		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1519471891398547';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));

			$(document).ready(function() {

				$.ajaxSetup({ cache: true });
				$.getScript('//connect.facebook.net/en_US/sdk.js', function(){
					FB.init({
						appId: '1519471891398547',
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
							data: {mac_address: '<?php echo $macaddress; ?>', hotel_id: <?php echo $hotel_id; ?>, page_id: <?php echo $fb_page_id; ?>, email: $('#user_email').val()},
							success: function(response){
								if(response) {
									window.location = 'http://<?php echo $nasip; ?>:64873/login?username=<?php echo $macaddress; ?>&password=<?php echo $macaddress; ?>&dst=<?php echo $url; ?>';
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
		background-color: <?php echo $GLOBALS['bg_color']; ?>;
	}
</style>

	<div class="contact-wthree">
		<a href="#"><p class="terms">terms & conditions ></p></a>

<!--			<div class="form-w3step1">-->
<!--				<div class="social-wrap c">-->
<!--					<button class="facebook">Connect using Facebook</button>-->
<!--				</div>-->
<!--			</div>-->
<!--		<form action="#" method="post">-->
<!--			<p class="subtitle fancy"><span>Or use your email</span></p>-->
<!--			<div class="form-w3step1">-->
<!---->
<!--				<input type="email" class="email agileits-btm email-special" name="Email" placeholder="Your email address here">-->
<!--				<button class="butt"> > </button>-->
<!--			</div>-->
<!--		</form>-->

		<form action="http://login.com/emailSave.php" method="post">
			<h1 class="heading"><?php echo $GLOBALS['title']; ?></h1>
				<?php
					if ($_GET['liked'] == 'false'):
				?>
				<div class="form-w3step1">
					<div id='like_wrapper' style='margin-left: 40%;
								transform: scale(2.5, 1.7);
								-ms-transform: scale(2.5, 1.7);
								-webkit-transform: scale(2.5, 1.7);
								-o-transform: scale(2.5, 1.7);
								-moz-transform: scale(2.5, 1.7);
								'
						 class="fb-like social-wrap c" data-href="<?php echo $fb_url; ?>"
						 data-width="400"
						 data-layout="button"
						 data-action="like"
						 data-size="large"
						 data-show-faces="false"
						 data-share="false">
					</div>
				</div>
				<?php
			else:
				?>
				<div class="form-w3step1">
					<div class="social-wrap c">
						<button type='button' class="facebook">
							<a style='color: #ffffff;'
							   href="http://fbdev.guestcompass.nl/index.php?macaddress=<?php echo $macaddress; ?>&nasip=<?php echo $nasip; ?>&hotel_id=<?php echo $hotel_id; ?>&url=<?php echo $url; ?>">
								Connect using Facebook
							</a>
						</button>
					</div>
				</div>
				<?php
			endif;
			?>

			<input type="hidden" id="user_email" value="<?php echo urldecode($_GET['email']); ?>">

			<input type="hidden" name="hotel_id" value="<?php echo $hotel_id; ?>">
			<input type="hidden" name="template_id" value="<?php echo $template_id; ?>">
			<input type="hidden" name="nasip" value="<?php echo $nasip; ?>">
			<input type="hidden" name="macaddress" value="<?php echo $macaddress; ?>">
			<input type="hidden" name="url" value="<?php echo $url; ?>">

			<p class="subtitle fancy"><span><?php echo $GLOBALS['middle_title']; ?></span></p>
			<div class="form-w3step1">
				<input type="email" class="email agileits-btm email-special" name="Email" placeholder="<?php echo $GLOBALS['email_title']; ?>">
				<button class="butt"> > </button>
			</div>

			<div class="form-w3step1 logo-image">
				<img src="images/<?php echo $GLOBALS['image']; ?>">
			</div>

			<!--<input type="submit" value="SUBMIT">-->
		</form>


			<div class="form-w3step1 logo-image">

				<img src="images/<?php echo $GLOBALS['image']; ?>">
			</div>


			<!--<input type="submit" value="SUBMIT">-->
	</div>


	<!-- //main -->

</body>
</html>