<?php
	include_once("header.php");
	include_once('header/map.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?></title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<div id="map" style="width: 100%; height: 75vh;"></div>
		<?php ks_map_all('map'); ?>
	</body>
</html>
