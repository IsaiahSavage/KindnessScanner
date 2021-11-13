<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<title><?php echo($ks_config['title'] . ' - New Scan'); ?></title>
	</head>
	<body>
		<h1>Submit a Scan</h1>
        <form action="scan.php" method="post">
            What did the person do for you?<br>
            <textarea name="input_act" id="input_act" cols="30" rows="10"></textarea><br>
            What did this act mean to you?<br>
            <textarea name="input_meaning" id="input_meaning" cols="30" rows="10"></textarea><br>
            <button type="submit">Submit</button>
        </form>
	</body>
</html>

<?php 
        $input_act = $input_meaning = "";

        if (isset($_POST["input_act"], $_POST["input_meaning"])) {
            $input_act = format_data($_POST["input_act"]);
            $input_meaning = format_data($_POST["input_meaning"]);
            $timestamp = build_timestamp();
            // TODO: Add location data retrieval
            //  - Data will need to be collected in JS due to limitations of server-side code,
            //    then collected/set via POST by this block.
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
            $date_time = date('Y-m-d G:i:s') . getUTCOffset(date_default_timezone_get());
            return $date_time;
        }

        // Convert to UTC offset for use in DB queries
        function getUTCOffset($timezone)
        {
            $current = timezone_open($timezone);
            $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
            $offsetInSecs = $current->getOffset($utcTime);
            $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
            return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
        }  