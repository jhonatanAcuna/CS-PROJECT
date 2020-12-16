<?php

  include("../functions.php");

  if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
    header("Location: login.php");

  if($_SESSION['user_level'] != "staff")
    header("Location: login.php");


	if (isset($_POST['btnSta']) && isset($_POST['empcod'])) {

		$btnStatus = $sqlconnection->real_escape_string($_POST['btnSta']);
		$empcod = $sqlconnection->real_escape_string($_POST['empcod']);

		if ($btnStatus== "Online")
			$status = "Offline";

		if ($btnStatus== "Offline")
			$status = "Online";
		
		$updateStatusQuery = "UPDATE empleado SET empest = '{$status}' WHERE empcod = {$empcod};";

		if ($sqlconnection->query($updateStatusQuery) == TRUE) {
				header("Location: index.php");
			} 

		else {

				echo "someting wong";
				echo $sqlconnection->error;

		}
	}
?>