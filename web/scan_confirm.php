<?php 
include_once('header.php');

$input_act = $input_meaning = "";

if (isset($_POST["input_act"], $_POST["input_meaning"]), $_POST["latitude"], $_POST["longitude"]) {
    $input_act = format_data($_POST["input_act"]);
    $input_meaning = format_data($_POST["input_meaning"]);
    $timestamp = build_timestamp();
    
    // TODO: Add location data retrieval
    //  Data will need to be collected in JS due to limitations of server-side code,
    //    then collected/set via POST by this block.
    $latitude = (float) format_data($_POST["latitude"]);
    $longitude = (float) format_data($_POST["longitude"]);
    // submit_data($latitude, $longitude, $timestamp, $input_act);
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
function submit_data(float $submission_latitude, float $submission_longitude, string $submission_time, string $submission_act)
{
    $ks_db->begin();

    try {
        $ks_db->query('INSERT INTO scan (latitude, longitude, time, description) VALUES ($1, $2, TIMESTAMP WITH TIME ZONE $3, $4)', $submission_latitude, $submission_longitude, $submission_time, $submission_act);
        $ks_db->query('INSERT INTO card_scan (card_id, scan_id) VALUES ($1, $2)', $_GET["card_id"], $scan_id);
        $ks_db->t_commit();
    } catch (Exception $e) {
        $ks_db->t_rollback();
        throw $e;
    }
} */
?>

<!DOCTYPE html> 
<html lang="en">
    <head>
        <title><?php echo($ks_config['title'] . ' - New Scan'); ?></title>
    </head>    
    <body>
        <h1>Thank you for your submission!</h1>
        <h3>Your information has been submitted. Your next task: pass it on.</h3>
        <button><a href="index.php">View Map</a></button>
    </body>
</html>