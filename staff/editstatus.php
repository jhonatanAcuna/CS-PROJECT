<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
	header("Location: login.php");

if ($_SESSION['user_level'] != "employee")
	header("Location: login.php");

if (isset($_POST['status']) && isset($_POST['pedcod'])) {

	$status = $sqlconnection->real_escape_string($_POST['status']);
	$pedcod = $sqlconnection->real_escape_string($_POST['pedcod']);

	$addOrderQuery = "UPDATE pedido SET pedest = '{$status}' WHERE pedcod = {$pedcod};";

	if ($sqlconnection->query($addOrderQuery) === TRUE) {
		echo "inserted.";
	} else {
		//handle
		echo "someting wong";
		echo $sqlconnection->error;
	}
}

if (isset($_GET['pedcod'])) {

	$status = "Completed";
	$pedcod = $sqlconnection->real_escape_string($_GET['pedcod']);

	$addOrderQuery = "UPDATE pedido SET pedest = '{$status}' WHERE pedcod = {$pedcod};";

	if ($sqlconnection->query($addOrderQuery) === TRUE) {
		echo "inserted.";
		header("Location: index.php");
	} else {
		//handle
		echo "someting wong";
		echo $sqlconnection->error;
	}
}
