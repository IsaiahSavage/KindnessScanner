<?php 
include_once('header.php');

$card_id = isset($_GET["card_id"]) ? htmlspecialchars($_GET["card_id"]) : '';

function show_form()
{
    ?>
        <h1>Submit a Scan</h1>
        <!-- Card ID tied to a card's QR code -->
        <!-- Example: my.website.com/web/scan.php?card_id=1032 -->
        <!-- Perhaps check for manually-injected card_id:
            if (isset($_GET["source"]) && $_GET["source"] == "qr") {...} 
            or use some sort of check for a specific format
        -->
        <h3>Card ID: <?php echo $card_id ?></h3>
        <form onload="getLocation()" action="scan_confirm.php?card_id=<?php echo $card_id ?>" method="post">
            What did the person do for you?<br>
            <textarea name="input_act" id="input_act" cols="30" rows="10"></textarea><br>
            What did this act mean to you?<br>
            <textarea name="input_meaning" id="input_meaning" cols="30" rows="10"></textarea><br>
            <input type="submit" value="Submit">
            <input type="hidden" name="latitude" id="latitude" value="">
            <input type="hidden" name="longitude" id="longitude" value="">
        </form>
        <script>
            var la = document.getElementById("latitude");
            var lo = document.getElementById("longitude");
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(setLocation);
                } else {
                    la.value = "Not Supported"; 
                    lo.value = "Not Supported"; 
                }
            }
            function setLocation(position) {
                la.value = position.coords.latitude; 
                lo.value = position.coords.longitude; 
            }
        </script>
    <?php
}

function show_error()
{
 ?>
    <h1>Oops!</h1>
    <h3>It seems that there was an issue reading your card. Please try scanning the card again.</h3>
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
            try {
                $results = $ks_db->query('SELECT card_id FROM card WHERE card_id = $1 AND card_id IN (select card_id from r_u_card)', [$card_id]);
                if (!empty($results)) {
                    // Card is already registered; add form to page
                    show_form();
                } else {
                    // TODO: check for card_id IN card AND NOT IN r_u_card
                    // Add error message to page
                    show_error();
                }
            } catch (Exception $e) {
                show_error();
            }
        ?>
	</body>
</html>
