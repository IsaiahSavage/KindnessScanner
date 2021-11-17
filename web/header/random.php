<?php

include('header.php');

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

function ks_generate_random_password() {
	$generator = new ComputerPasswordGenerator();
	$generator->setLength(16)
		->setOptionValue(ComputerPasswordGenerator::OPTION_UPPER_CASE, false)
		->setOptionValue(ComputerPasswordGenerator::OPTION_LOWER_CASE, true)
		->setOptionValue(ComputerPasswordGenerator::OPTION_NUMBERS, true)
		->setOptionValue(ComputerPasswordGenerator::OPTION_SYMBOLS, false);
	return $generator->generatePassword();
}
