<?php
	
	//Add new menu (category)
	if (isset($_POST['categoria'])) {

		if (!empty($_POST['categoria'])) {
			$categoria = $sqlconnection->real_escape_string($_POST['categoria']);

			$addCateQuery = "INSERT INTO categoria (nombre) VALUES ('{$categoria}')";

			if ($sqlconnection->query($addCateQuery) === TRUE) {
				header("Location: menu.php");
			} else {
				//handle
				echo "someting wong";
			}
		}
		

	}


?>