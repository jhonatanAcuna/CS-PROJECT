<?php

if (isset($_POST['deleteCat'])) {

	//Eliminando categoria
	if (isset($_POST['catID'])) {

		$categoria = $sqlconnection->real_escape_string($_POST['catID']);

		//primeramente se borran los productos
		$deleteProdQuery = "DELETE FROM productos WHERE catcod = {$categoria}";

		if ($sqlconnection->query($deleteProdQuery) === TRUE) {

			//Luego eliminamos la categoria
			$deleteCatQuery = "DELETE FROM categoria WHERE catcod = {$categoria}";

			if ($sqlconnection->query($deleteCatQuery) === TRUE) {
				header("Location: categoria.php"); //modifcar 
				exit();
			} else {
				echo "someting wrong";
				echo $sqlconnection->error;
			}
		} else {
			echo "someting wrong";
			echo $sqlconnection->error;
		}
	}
}
