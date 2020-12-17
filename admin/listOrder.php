
<?php
	include("../functions.php");

	if((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])) ) 
		header("Location: login.php");

	if($_SESSION['user_level'] != "admin")
		header("Location: login.php");

	if(empty($_GET['cmd'])) 
		die();
	if ($_GET['cmd'] != 'display')	
		die();

	$displayOrderQuery =  "
			SELECT o.pedcod, m.catnom, OD.procod,MI.pronom,OD.peddetqty,O.pedest
			FROM pedido O
			LEFT JOIN pedidodetalle OD
			ON O.pedcod = OD.pedcod
			LEFT JOIN productos MI
			ON OD.procod = MI.procod
			LEFT JOIN categoria M
			ON MI.catcod = M.catcod
			WHERE O.pedest 
			IN ( 'waiting','preparing','ready','finish')
		";

	if ($orderResult = $sqlconnection->query($displayOrderQuery)) {
			
		$currentspan = 0;

		//if no order
		if ($orderResult->num_rows == 0) {

			echo "<tr><td class='text-center' colspan='7' >Sin ordenes por el momento </td></tr>";
		}

		else {
			while($orderRow = $orderResult->fetch_array(MYSQLI_ASSOC)) {

				//basically count rowspan so no repetitive display id in each table row
				$rowspan = getCountID($orderRow["pedcod"],"pedcod","pedidodetalle"); 

				if ($currentspan == 0)
					$currentspan = $rowspan;

				echo "<tr>";

				if ($currentspan == $rowspan) {
					echo "<td class='text-center' rowspan=".$rowspan."># ".$orderRow['pedcod']."</td>";
				}

				echo "
					<td>".$orderRow['catnom']."</td>
					<td>".$orderRow['pronom']."</td>
					<td class='text-center'>".$orderRow['peddetqty']."</td>
				";

				if ($currentspan == $rowspan) {

					$color = "badge badge-warning";
					switch ($orderRow['pedest']) {
						case 'waiting':
							$color = "badge badge-warning";
							break;
						
						case 'preparing':
							$color = "badge badge-primary";
							break;

						case 'ready':
							$color = "badge badge-success";
							break;
							
						case 'finish':
							$color = "badge badge-success";
							break;
					}

					echo "<td class='text-center' rowspan=".$rowspan."><span class='{$color}'>".$orderRow['pedest']."</span></td>";
				
					echo "</td>";

				}

				echo "</tr>";

				$currentspan--;
			}
		}	
	}

?>