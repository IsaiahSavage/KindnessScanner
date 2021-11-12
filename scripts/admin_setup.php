<?php

include_once('header/da_user.php');

echo("Setting up an admin user...\nYou will be able to confirm this information at the end.\n");

/* Read a line from the input with a prompt, with the input hidden if possible.
Input hiding only works on *nix systems with `stty`. */
function readline_password(string $prompt) {
	// Save old TTY style.
	$old_style = shell_exec('stty -g');

	// Only do something special if we had a status (meaning, we have stty).
	if($old_style) {
		echo($prompt);

		// Disable echo.
		shell_exec('stty -echo');

		// Read in a line without newlines.
		$line = rtrim(fgets(STDIN), "\r\n");

		// Restore TTY style.
		shell_exec('stty ' . $old_style);

		// Output trailing newline.
		echo("\n");

		return $line;
	}
	else {
		echo("[Warning: Password will be echoed!] ");
		return readline($prompt);
	}
}

$name = readline("What is this admin's name? ");
$email = readline("What is this admin's e-mail address? ");
$password = readline_password("What is this admin's password? ");
$password2 = readline_password("Confirm the password: ");

if($password !== $password2) {
	die("Passwords do not match.\n");
}

printf("Name: %s\nE-mail: %s\n", $name, $email);
$ok = readline("Does this look OK? (y/n) ");
if(in_array(strtolower($ok), array('yes', 'y'))) {
	echo("Adding user...\n");
	ks_da_user_add(array(
		'name' => $name,
		'email' => $email,
		'password' => $password,
		'privilege' => 'admin',
	));
}
else {
	die("Canceled.\n");
}
