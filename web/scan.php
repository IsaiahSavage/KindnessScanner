<?php include('header.php'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<title><?php echo($ks_config['title'] . ' - New Scan'); ?></title>
	</head>
	<body>
        

		<h1>Submit a Scan</h1>
        <form action="scan.php" method="post">
            What did the person do for you?
            <textarea name="input_act" id="input_act" cols="30" rows="10"></textarea><br>
            What did this act mean to you?
            <textarea name="input_meaning" id="input_meaning" cols="30" rows="10"></textarea><br>
            <button type="submit">Submit</button>
        </form>
	</body>
</html>

<?php 
        $input_act = $input_meaning = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $input_act = format_data($_POST["input_act"]);
            $input_meaning = format_data($_POST["input_meaning"]);
            /***
             * TODO:
             *  - Add location data retrieval
             *  - Add timestamp
             */
        }

        // format data for submission to DB
        function format_data($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

    