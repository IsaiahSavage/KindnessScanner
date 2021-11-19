<?php
	use chillerlan\QRCode\{QRCode, QROptions};
	use FPDF;

	include_once('header/da_card.php');

	$card = ks_da_card_get($ks_db, (int) $_GET['card_id']);

	$qr_options = new QROptions(array(
		'eccLevel'   => QRCode::ECC_L,
	));

	$url = sprintf('%s/scan.php/%d', $ks_config['root_url'], $card['id']);

	$matrix = (new QRCode($qr_options))->getMatrix($url);

	$size = [3.37, 2.125];
	$qr_side_length = (2.125 / 2);

	$scale = $qr_side_length / $matrix->size();

	$fpdf = new FPDF('L', 'in', $size);
	$fpdf->AddPage();
	$fpdf->SetAutoPageBreak(false);

	/* Create an identical PDF document to test line heights. */
	$fpdf_test = new FPDF('L', 'in', $size);
	$fpdf_test->AddPage();
	$fpdf_test->SetAutoPageBreak(false);

	foreach($matrix->matrix() as $y => $row) {
		foreach($row as $x => $module) {
			if($matrix->check($x, $y)) {
				$fpdf->Rect($x * $scale, $y * $scale, $scale, $scale, 'F');
			}
		}
	}

	$fpdf->SetFont('Arial', '', 12);

	$fpdf->SetXY($qr_side_length, $scale * 4);
	$fpdf->MultiCell($size[0] - $qr_side_length - $scale * 4, 12 / 72, $ks_config['title']);

	$ufont_size = 8;

	/* First try adding the bottom text with the test PDF, then use the ending cursor Y to determine how much we need to shift up still. */
	$fpdf_test->SetFont('Arial', 'U', $ufont_size);
	$fpdf_test->SetTextColor(0, 0, 255);
	$fpdf_test->SetXY(0, 0);
	$fpdf_test->MultiCell($size[0] - $scale * 4, $ufont_size / 72, $url);

	$overflow_height = $fpdf_test->GetY() - $size[1];

	$fpdf->SetFont('Arial', 'U', $ufont_size);
	$fpdf->SetTextColor(0, 0, 255);
	$fpdf->SetXY($scale * 4, - $scale * 4 - $overflow_height);
	$fpdf->MultiCell($size[0] - $scale * 4, $ufont_size / 72, $url);

	header('Content-type: application/pdf');
	echo $fpdf->Output('S');
