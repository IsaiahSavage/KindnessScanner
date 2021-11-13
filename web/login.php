<?php
	include_once('header/login.php');

	function show_login_form() {
		?>
			<form action="login.php" method="POST">
				<input type="email" name="email"><br>
				<input type="password" name="password"><br>
				<input type="submit" value="Login">
			</form>
		<?php
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo($ks_config['title']); ?> | Login</title>
	</head>
	<body>
		<?php
			if($_SERVER['REQUEST_METHOD'] == 'POST') {
				if(ks_login($_POST['email'], $_POST['password'])) {
					?>
						Hello, <?php echo(htmlentities($ks_logged_in_user['name'])) ?>.
					<?php
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
