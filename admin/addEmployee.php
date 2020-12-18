<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
	header("Location: login.php");

if ($_SESSION['user_level'] != "admin")
	header("Location: login.php");

if (isset($_POST['addEmployee'])) {
	if (!empty($_POST['employeeName']) && !empty($_POST['employeeRol'])) {
		$empUserName = $sqlconnection->real_escape_string($_POST['employeeName']);
		$empRol = $sqlconnection->real_escape_string($_POST['employeeRol']);
		$pass = "empleado1234";
		$clave_hash = password_hash($pass, PASSWORD_DEFAULT);

		$addStaffQuery = "INSERT INTO empleado (empuser ,emppass ,empest ,emprol) VALUES ('{$empUserName}' ,'{$clave_hash}' ,'Offline' ,'{$empRol}') ";

		if ($sqlconnection->query($addStaffQuery) === TRUE) {
			echo "added.";
			header("Location: Employees.php");
			exit();
		} else {
			//handle
			echo "someting wong";
			echo $sqlconnection->error;
		}
	}
}
