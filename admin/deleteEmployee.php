<?php

include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
	header("Location: login.php");

if ($_SESSION['user_level'] != "admin")
	header("Location: login.php");

//Deleting Employee
if (isset($_GET['empCod'])) {

	$delEmployee = $sqlconnection->real_escape_string($_GET['empCod']);

	$deleteEmployeeQuery = "DELETE FROM empleado WHERE empcod = {$delEmployee}";

	if ($sqlconnection->query($deleteEmployeeQuery) === TRUE) {
		echo "deleted.";
		header("Location: Employees.php");
		exit();
	} else {
		echo "someting wrong";
		echo $sqlconnection->error;
	}
}
