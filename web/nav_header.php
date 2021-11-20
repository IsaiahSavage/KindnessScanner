<?php
	include_once('header/permissions.php');
	include_once('header/messages.php');
?>
<link rel="stylesheet" href="styles.css">
<nav class="navigation">
	<?php
		if($ks_logged_in_user) {
			printf("<li>Hello, %s</li>\n", htmlentities(explode(" ", $ks_logged_in_user['name'])[0]));
			?>
				<a href='index.php'>Dashboard</a>
				<a href='cards_manager.php'>Manage Cards</a>
				<a href='user_manager.php?user_id=<?php echo($ks_logged_in_user['id']); ?>'>My Settings</a>
				<?php
					if(ks_can_manage_users()) {
						?> <a href='users_manager.php'>Manage Users</a> <?php
					}
				?>
				<a href='logout.php'>Logout</a>
			<?php
		}
		else {
			?> <a href='login.php'>Login</a> <?php
		}
	?>
</nav>
<hr>
<?php
	$nav_messages = ks_pop_messages();
	if(!empty($nav_messages)) {
		?>
			<ul>
			<?php
				foreach($nav_messages as $message) {
					?>
						<li><?php echo htmlentities($message); ?></li>
					<?php
				}
			?>
			</ul>
			<hr>
		<?php
	}
?>
