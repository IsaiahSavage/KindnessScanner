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
		<?php
			$card = ks_da_card_get($ks_db, (int) $_GET['card_id']);
			$owner = ks_da_user_get($ks_db, $card['owner']);
		?>
		<h1>Card #<?php echo $card['id'] ?></h1>
		Registered to <?php echo $owner['name']; ?><br>
		Created at <?php echo date('c', $card['creation_time']); ?><br>
	</body>
</html>
