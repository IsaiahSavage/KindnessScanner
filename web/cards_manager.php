<?php
	include_once('header.php');
	include_once('header/permissions.php');
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Card Manager</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body id="cards-manager">
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		Current cards:
		<ul>
			<?php
				foreach($ks_db->query_array("SELECT card.card_id, registered_user.user_id, registered_user.name FROM card LEFT JOIN r_u_card ON card.card_id = r_u_card.card_id LEFT JOIN registered_user ON r_u_card.user_id = registered_user.user_id ORDER BY card.card_id") as $row) {
					if(ks_can_manage_card($row[0])) {
						printf("<li><a href='card_manager.php?card_id=%d'>Card %d%s</a></li>\n", $row[0], $row[0], $row[1] ? sprintf(" for %s", $row[2]) : "");
					}
				}
			?>
		</ul>
	</body>
</html>
