<?php
	include_once("header.php");
	include_once('header/map.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title'] . ' | Home'); ?></title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<section id="top-dashboard">
			<h1 class="header-dashboard">God Loves Unconditionally.<br>So should we.</h1>
			<p class="description-dashboard">Acts of kindness can change a life. 
			<br>Let's work together to spread them as far as possible.</p>
			<a class="button" href="#about-dashboard">Learn More</a>
			<a class="button" href="#map-dashboard">View Map</a>
		</section>
		<section id="about-dashboard">
			<h1 class="header-dashboard">Stick together, pay it forward.</h1>
			<p class="description-dashboard">Kindness Scanner is built around the idea that a simple act of kindness can mean the world to the one who receieves it. By passing a GLU card, you can add an act of kindness to our map - or perhaps start a chain of many.</p>
			<a class="button" href="#map-dashboard">View Map</a>
		</section>
		<section id="map-dashboard">
			<h1 class="header-dashboard">
				<?php 
					GLOBAL $ks_db; 
					$result = $ks_db->query_array('SELECT count(scan_id) FROM scan');
					echo $result[0][0] . ' scans and counting.';
				?>
			</h1>
			<p class="description-dashboard">Soon, you'll be able to request a card and help pay it forward.</p>
			<div id="map"></div>
			<?php ks_map_all('map'); ?>
			<a href="#top-dashboard" class="button">Back to Top</a>
		</section>
	</body>
</html>
