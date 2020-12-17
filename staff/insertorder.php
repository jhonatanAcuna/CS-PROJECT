<?php
	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "employee")
		header("Location: login.php");

	

	if (isset($_POST['sentorder'])) {

		if (isset($_POST['prodcod']) && isset($_POST['prodqty'])) {

			$arrProd = $_POST['prodcod'];
			$arrProdQty = $_POST['prodqty'];			

			//check pair of the array have same element number
			if (count($arrProd) == count($arrProdQty)) {				
				$arrlength = count($arrProd);

				//add new id
				$currentOrderCod = getLastID("pedcod","pedido") + 1;

				insertOrderQuery($currentOrderCod);

				for ($i=0; $i < $arrlength; $i++) { 
					insertOrderDetailQuery($currentOrderCod,$arrProd[$i] ,$arrProdQty[$i]);
				}

				updateTotal($currentOrderCod);

				//completed insert current order
				header("Location: index.php");
				exit();
			}
		}	
	}

	function insertOrderDetailQuery($orderCod,$prodCod,$quantity) {
		global $sqlconnection;
		$addOrderQuery = "INSERT INTO pedidodetalle (pedcod ,procod ,peddetqty) VALUES ('{$orderCod}', '{$prodCod}' ,{$quantity})";

		if ($sqlconnection->query($addOrderQuery) === TRUE) {
				echo "inserted.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
	}

	function insertOrderQuery($orderCod) {
		global $sqlconnection;
		$addOrderQuery = "INSERT INTO pedido (pedcod ,pedest ,peddate) VALUES ('{$orderCod}' ,'waiting' ,CURDATE() )";

		if ($sqlconnection->query($addOrderQuery) === TRUE) {
				echo "inserted.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}
	}

?>