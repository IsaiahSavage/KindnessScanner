<?php
	include_once('header/permissions.php');
	include_once('header/messages.php');
?>

<ul>
	<?php
		if($ks_logged_in_user) {
			printf("<li>Hello, %s</li>\n", htmlentities($ks_logged_in_user['name']));
			?>
				<li><a href='index.php'>Dashboard</a></li>
				<li><a href='cards_manager.php'>Manage Cards</a></li>
				<li><a href='user_manager.php?user_id=<?php echo($ks_logged_in_user['id']); ?>'>My Settings</a></li>
				<?php
					if(ks_can_manage_users()) {
						?> <li><a href='users_manager.php'>Manage Users</a></li> <?php
					}
				?>
				<li><a href='logout.php'>Logout</a></li>
			<?php
		}
		else {
			?> <li><a href='login.php'>Login</a></li> <?php
		}
	?>
</ul>
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
