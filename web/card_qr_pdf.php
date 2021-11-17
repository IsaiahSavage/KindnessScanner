<?php
	use chillerlan\QRCode\{QRCode, QROptions};

	include_once('header/da_card.php');

	$card = ks_da_card_get($ks_db, (int) $_GET['card_id']);

	$qr_options = new QROptions(array(
		'outputType'   => QRCode::OUTPUT_FPDF,
		'imageBase64'  => false,
		'eccLevel'   => QRCode::ECC_H,
	));

	header('Content-type: application/pdf');
	echo (new QRCode($qr_options))->render(sprintf('%s/scan.php?card_id=%d', $ks_config['root_url'], $card['id']));
