<?php

	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	//eliminando los productos
	if (isset($_GET['catCod']) && isset($_GET['prodCod'])) {
		
		$del_catcod = $sqlconnection->real_escape_string($_GET['catCod']);
		$del_prodcod = $sqlconnection->real_escape_string($_GET['prodCod']);

		$deleteProdQuery = "DELETE FROM productos WHERE cate_cod = {$del_catcod} AND codigo = {$del_prodcod}";

		if ($sqlconnection->query($deleteProdQuery) === TRUE) {
				header("Location: categoria.php"); 
				exit();
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
		
	}
?>