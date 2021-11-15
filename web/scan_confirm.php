<?php 
include_once('header.php');

$input_act = $input_meaning = "";

function construct_data() {
    $input_act = format_data($_POST["input_act"]);
    $input_meaning = format_data($_POST["input_meaning"]);
    $timestamp = build_timestamp();
    $latitude = (float) format_data($_POST["latitude"]);
    $longitude = (float) format_data($_POST["longitude"]);

    // TODO: Add location data retrieval
    //  Data will need to be collected in JS due to limitations of server-side code,
    //    then collected/set via POST by this block.
    // $latitude = ;
    // $longitude = ;
}

// Format data for submission to DB
function format_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Build timestamp for submission
function build_timestamp() {
    $date_time = date('Y-m-d G:i:s') . get_UTC_offset(date_default_timezone_get());
    return $date_time;
}

// Convert to UTC offset for use in DB queries
function get_UTC_offset($timezone)
{
    $current = timezone_open($timezone);
    $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
    $offsetInSecs = $current->getOffset($utcTime);
    $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
    return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
}

/*
// Insert user data into DB
// Currently under construction due to lack of lat./long. values
function submit_data()
{
    $ks_db->begin();

    try {
        $ks_db->query('INSERT INTO scan (latitude, longitude, time, description) VALUES ($1, $2, TIMESTAMP WITH TIME ZONE $3, $4)', [$latitude, $longitude, $timestamp, $input_act]);
        $scan_id = $ks_db->query('SELECT CURRVAL('scan_scan_id_seq')');
        $ks_db->query('INSERT INTO card_scan (card_id, scan_id) VALUES ($1, $2)', [$_GET["card_id"], $scan_id]);
        $ks_db->t_commit();
    } catch (Exception $e) {
        $ks_db->t_rollback();
        throw $e;
    }
} */

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
        <?php
            if (isset($_POST["input_act"], $_POST["input_meaning"], $_POST["latitude"], $_POST["longitude"])) {
                try{
                    construct_data();
                    // submit_data();
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