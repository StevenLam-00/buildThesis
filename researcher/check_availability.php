<?php
require_once("includes/config.php");
// code for username availablity
if (!empty($_POST["username"])) {
	$uName = $_POST["username"];

	$sql = "SELECT username FROM researcher WHERE username=:uName";
	$query = $dbh->prepare($sql);
	$query->bindParam(':uName', $uName, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		echo "<span style='color:red'> User Name is already exists. Please choose another one.</span>";
		echo "<script>$('#signUp').prop('disabled',true);</script>";
	} else {

		echo "<span style='color:green'> User Name is available for Registration.</span>";
		echo "<script>$('#signUp').prop('disabled',false);</script>";
	}
}

// code for email availablity
if (!empty($_POST["email"])) {
	$email = $_POST["email"];
	$sql = "SELECT email FROM researcher WHERE email=:email";
	$query = $dbh->prepare($sql);
	$query->bindParam(':email', $email, PDO::PARAM_STR);
	$query->execute();
	$results = $query->fetchAll(PDO::FETCH_OBJ);
	if ($query->rowCount() > 0) {
		echo "<span style='color:red'> Email is already exists. Please choose another one.</span>";
		echo "<script>$('#signUp').prop('disabled',true);</script>";
	} else {

		echo "<span style='color:green'> Email is available for Registration .</span>";
		echo "<script>$('#signUp').prop('disabled',false);</script>";
	}
}