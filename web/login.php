<?php
	include_once('header/login.php');

	function show_login_form() {
		?>
			<form class="login-form" action="login.php" method="POST">
				<input type="email" name="email"><br>
				<input type="password" name="password"><br>
				<input id="login-submit" type="submit" value="Login">
			</form>
		<?php
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Login</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(ks_login($_POST['email'], $_POST['password'])) {
					header('Location: index.php');
					die();
				}
				else {
					?>
						Sorry, that login was incorrect. Try again?<br>
					<?php
					show_login_form();
				}
		?>
		<?php
			}
			else {
				show_login_form();
			}
		?>
	</body>
</html>
