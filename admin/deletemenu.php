<?php

	if (isset($_POST['deleteCat'])) {

		//Eliminando el Menú
		if (isset($_POST['catID'])) {
			
			$categoria = $sqlconnection->real_escape_string($_POST['catID']);

			//primeramente se borran los productos
			$deleteCatItemQuery = "DELETE FROM productos WHERE cate_cod = {$categoria}";

			if ($sqlconnection->query($deleteCatItemQuery) === TRUE) {

				//Luego eliminamos la categoria
				$deleteCatQuery = "DELETE FROM categoria WHERE codigo = {$categoria}";

				if ($sqlconnection->query($deleteCatQuery) === TRUE) {
					header("Location: menu.php");//modifcar 
					exit();
					} 
				else {		
						echo "someting wrong";
						echo $sqlconnection->error;
					}
				} 

			else {
					echo "someting wrong";
					echo $sqlconnection->error;
				}
		}
	}
	

?>