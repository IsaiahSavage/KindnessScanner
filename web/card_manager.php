<?php
	include_once('header.php');
	include_once('header/permissions.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Card Manager</title>
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			$card = ks_da_card_get($ks_db, (int) $_GET['card_id']);
			$owner = ks_da_user_get($ks_db, $card['owner']);
		?>
		<h1>Card #<?php echo $card['id'] ?></h1>
		Registered to <?php echo $owner['name']; ?><br>
		Created at <?php echo date('c', $card['creation_time']); ?><br>
		<?php printf("<a href='card_qr_pdf.php?card_id=%d'>Generate Card PDF</a>", $card['id']); ?>
	</body>
</html>
