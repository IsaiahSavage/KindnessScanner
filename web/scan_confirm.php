<?php
include_once('header.php');

$input_act = $input_meaning = "";

function construct_data() {
    $latitude = (float) format_data($_POST["latitude"]);
    $longitude = (float) format_data($_POST["longitude"]);
    $input_act = format_data($_POST["input_act"]);
    $input_meaning = format_data($_POST["input_meaning"]);
    return array($latitude, $longitude, $input_act);
}

// Format data for submission to DB
function format_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Insert user data into DB
// Currently under construction
function submit_data(float $lat, float $long, string $description)
{
    GLOBAL $ks_db;
    $ks_db->t_begin();

    try {
        $card_id = (integer) htmlspecialchars($_GET["card_id"]);
        $scan_id_row = $ks_db->query('INSERT INTO scan (latitude, longitude, time, description) VALUES ($1, $2, NOW(), $3) RETURNING scan_id', array($lat, $long, $description));
        $scan_id = pg_fetch_row($scan_id_row)['0'];
        $ks_db->query('INSERT INTO card_scan (card_id, scan_id) VALUES ($1, $2)', array($card_id, $scan_id));
        $ks_db->t_commit();
    } catch (Exception $e) {
        $ks_db->t_rollback();
        throw $e;
    }
}

function show_confirmation()
{
    ?>
        <h1>Thank you for your submission!</h1>
        <h3>Your information has been submitted. Your next task: pass it on.</h3>
        <button><a href="index.php">View Map</a></button>
    <?php
}

function show_error()
{
 ?>
    <h1>Oops!</h1>
    <h3>It seems that there was an issue submitting your scan. Please try submitting the information again.</h3>
    <button><a href="scan.php">Go Back</a></button>
 <?php
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo $ks_config['title']; ?> | New Scan</title>
    </head>
    <body>
		<header>
			<?php include_once('nav_header.php'); ?>
		</header>
        <?php
            if (isset($_POST["input_act"], $_POST["input_meaning"], $_POST["latitude"], $_POST["longitude"])) {
                try{
                    $data = construct_data();
                    submit_data(...$data);
                    show_confirmation();
                } catch(Exception $e) {
                    show_error();
                }
            } else {
                show_error();
            }
        ?>
    </body>
</html>
