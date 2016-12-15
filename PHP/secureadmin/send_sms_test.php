<?php
	// Authorisation details.
	$username = "readabookchallenge@gmail.com";
	$hash = "3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea";

	// Config variables. Consult http://api.textlocal.in/docs for more info.
	$test = "0";
	$name = "lingu";
	$orderNumber = "BOOK1234567890";
	// Data for text message. This is the text message data.
	//$sender = "TXTLCL"; // This is who the message appears to be from.
	$sender = "RDBOOK"; // This is who the message appears to be from.
	$numbers = "919019784755"; // A single number or a comma-seperated list of numbers
	$message = rawurlencode("Dear ".$name." your order has been placed successfully. Your order number is ".$orderNumber.".");
	
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
	$ch = curl_init('http://api.textlocal.in/send/?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch); // This is the result from the API
	curl_close($ch);
	
	echo $result;
?>