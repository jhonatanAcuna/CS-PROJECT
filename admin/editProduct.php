<?php

	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	if(isset($_POST['editprod'])) {

		if (!empty($_POST['prodName']) && !empty($_POST['prodPrice']) ) {

			$cateCod = $sqlconnection->real_escape_string($_POST['cateCod']);
			$prodCod = $sqlconnection->real_escape_string($_POST['prodCod']);
			$prodName = $sqlconnection->real_escape_string($_POST['prodName']);
			$prodPrice = $sqlconnection->real_escape_string($_POST['prodPrice']);

			$updateProdQuery = "UPDATE productos SET pronom = '{$prodName}' , proprice = {$prodPrice} WHERE catcod = {$cateCod} AND procod = {$prodCod} ";

			if ($sqlconnection->query($updateProdQuery) === TRUE) {
				header("Location: categoria.php"); 
				exit();
			} 

			else {
				echo "someting wong";
				echo $sqlconnection->error;
				echo $updateItemQuery;
			}

		}
	} 

?>