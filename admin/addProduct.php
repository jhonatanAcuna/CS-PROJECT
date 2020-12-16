<?php

	//Add new menu item
	if (isset($_POST['addProd'])) {

		if (!empty($_POST['prodName']) && !empty($_POST['price']) && !empty($_POST['category'])) {
			$prodName = $sqlconnection->real_escape_string($_POST['prodName']);
			$price = $sqlconnection->real_escape_string($_POST['price']);
			$cate = $sqlconnection->real_escape_string($_POST['category']);

			$addProdQuery = "INSERT INTO productos (catcod ,pronom ,proprice) VALUES ({$cate} ,'{$prodName}' ,{$price})";

			if ($sqlconnection->query($addProdQuery) === TRUE) {
				header("Location: categoria.php"); 
				exit();

			} 

			else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;
			}
		}

	}

	
?>