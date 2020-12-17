<?php

	require("dbconnection.php");

	session_start();
	
	function getNumRowsQuery($query) {
		global $sqlconnection;
		if ($result = $sqlconnection->query($query))
			return $result->num_rows;
		else
			echo "Something wrong the query!";
	}

	function getFetchAssocQuery($query) {
		global $sqlconnection;
		if ($result = $sqlconnection->query($query)) {
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        		echo "\n", $row["itemID"], $row["menuID"], $row["menuItemName"], $row["price"];
    		}
    		
			return ($result);
		}
		else
			echo "Something wrong the query!";
			echo $sqlconnection->error;
	}

	function getLastID($id,$table) {
		global $sqlconnection;

		$query = "SELECT MAX({$id}) AS {$id} from {$table} ";

		if ($result = $sqlconnection->query($query)) {
			
			$res = $result->fetch_array();

			if ($res[$id] == NULL)
				return 0;

			return $res[$id];
		}
		else {
			echo $sqlconnection->error;
			return null;
		}
	}

	function getCountID($idnum,$id,$table) {
		global $sqlconnection;

		$query = "SELECT COUNT({$id}) AS {$id} from {$table} WHERE {$id}={$idnum}";

		if ($result = $sqlconnection->query($query)) {
			
			$res = $result->fetch_array();

			if ($res[$id] == NULL)
				return 0;

			return $res[$id];
		}
		else {
			echo $sqlconnection->error;
			return null;
		}
	}

	function getSalesTotal($orderID) {
		global $sqlconnection;
		$total = null;

		$query = "SELECT pedtot FROM pedido WHERE pedcod = ".$orderID;

		if ($result = $sqlconnection->query($query)) {
		
			if ($res = $result->fetch_array()) {
				$total = $res[0];
				return $total;
			}

			return $total;
		}

		else {

			echo $sqlconnection->error;
			return null;

		}
	}

	function getSalesGrandTotal($duration) {
		global $sqlconnection;
		$total = 0;

		if ($duration == "ALLTIME") {
			$query = "
					SELECT SUM(pedtot) as grandtotal
					FROM pedido
					";
		}

		else if ($duration == ("DAY" || "MONTH" || "WEEK")) {

			$query = "
					SELECT SUM(pedtot) as grandtotal
					FROM pedido

					WHERE peddate > DATE_SUB(NOW(), INTERVAL 1 ".$duration.")
					";
		}

		else 
			return null;

		if ($result = $sqlconnection->query($query)) {
		
			while ($res = $result->fetch_array(MYSQLI_ASSOC)) {
				$total+=$res['grandtotal'];
			}

			return $total;
		}

		else {

			echo $sqlconnection->error;
			return null;

		}
	}

	function updateTotal($orderID) {
		global $sqlconnection;

		$query = "
			UPDATE pedido o
			INNER JOIN (
			    SELECT SUM(OD.peddetqty*mi.proprice) AS total
			        FROM pedido O
			        LEFT JOIN pedidodetalle OD
			        ON O.pedcod = OD.pedcod
			        LEFT JOIN productos MI
			        ON OD.procod = MI.procod
			        LEFT JOIN categoria M
			        ON MI.catcod = M.catcod
			        
			        WHERE o.pedcod = ".$orderID."
			) x
			SET o.pedtot = x.total

			WHERE o.pedcod = ".$orderID."
		";

		if ($sqlconnection->query($query) === TRUE) {
				echo "updated.";
			} 

		else {
				//handle
				echo "someting wong";
				echo $sqlconnection->error;

		}

	}

?>