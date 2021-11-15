<?php 
include_once('header.php');
$card_id = isset($_GET["card_id"]) ? htmlspecialchars($_GET["card_id"]) : '';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<title><?php echo $ks_config['title'] . ' - New Scan'; ?></title>
	</head>
	<body onload="getLocation()">
		<h1>Submit a Scan</h1>
        <!-- Card ID tied to a card's QR code -->
        <!-- Example: my.website.com/web/scan.php?card_id=1032 -->
        <!-- Perhaps check for manually-injected card_id:
             if (isset($_GET["source"]) && $_GET["source"] == "qr") {...} 
             or use some sort of check for a specific format
        -->
        <h3>Card ID: <?php echo $card_id ?></h3>
        <form action="scan_confirm.php?card_id=<?php echo $card_id ?>" method="post">
            What did the person do for you?<br>
            <textarea name="input_act" id="input_act" cols="30" rows="10"></textarea><br>
            What did this act mean to you?<br>
            <textarea name="input_meaning" id="input_meaning" cols="30" rows="10"></textarea><br>
            <input type="hidden" id="latitude" value="">
            <input type="hidden" id="longitude" value="">
            <button type="submit">Submit</button>
        </form>
        <script>
            var la = document.getElementById("latitude");
            var lo = document.getElementById("longitude");
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(setLocation);
                } else {
                    la.value = "Oops"; 
                    lo.value = "Oops"; 
                }
            }
            function setLocation(position) {
                la.value = position.coords.latitude; 
                lo.value = position.coords.longitude; 
            }
        </script>
	</body>
</html>