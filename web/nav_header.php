<?php
	include_once('header/permissions.php');
	include_once('header/messages.php');
?>
<link rel="stylesheet" href="styles.css">
<nav class="container">
	<div class="logo">
		<a id="link-dashboard-nav" href='index.php'><?php echo $ks_config['title']; ?></a>
	</div>
	<ul id="wrapper-links-nav">
		<li><a id="link-about-nav" href="index.php#about-dashboard">About</a></li>
		<li><a id="link-map-nav" href="index.php#map-dashboard">Map</a></li>
		<?php
			if($ks_logged_in_user) {
				?><li class="dropdown">
					<a href="#" class="dropdown-title highlight" id="welcome-dropdown-nav">
						<?php printf("Hello, %s", htmlentities(explode(" ", $ks_logged_in_user['name'])[0])); ?>
					</a>
					<div class="dropdown-sub" id="content-dropdown-nav">
						<a class="dropdown-content" id="cards-dropdown-nav" href='cards_manager.php'>My Cards</a>
						<a class="dropdown-content" id="settings-dropdown-nav" href='user_manager.php?user_id=<?php echo($ks_logged_in_user['id']); 
							?>'>Settings</a>
						<?php
							if(ks_can_manage_users()) {
								?> <a class="dropdown-content" id="users-dropdown-nav" href='users_manager.php'>Manage Users</a> <?php
							}
						?>
						<a class="dropdown-content" id="logout-dropdown-nav" href='logout.php'>Logout</a>
					</div>
				</li><?php
			} else {
				?> <li><a href='login.php' class="highlight" id="link-login-nav">Login</a></li> <?php
			}
		?>
	</ul>
</nav>
<?php
	$nav_messages = ks_pop_messages();
	if(!empty($nav_messages)) {
		?>
			<hr>
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
