<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
	header("Location: login.php");

if ($_SESSION['user_level'] != "employee")
	header("Location: login.php");

if (isset($_POST['btnCat'])) {

	$catCod = $sqlconnection->real_escape_string($_POST['btnCat']);

	$prodQuery = "SELECT procod,pronom FROM productos WHERE catcod = " . $catCod;

	if ($prodResult = $sqlconnection->query($prodQuery)) {
		if ($prodResult->num_rows > 0) {
			$counter = 0;
			while ($prodRow = $prodResult->fetch_array(MYSQLI_ASSOC)) {

				if ($counter >= 3) {
					echo "</tr>";
					$counter = 0;
				}

				if ($counter == 0) {
					echo "<tr>";
				}

				echo "<td><button style='margin-bottom:4px;white-space: normal;' class='btn btn-warning' onclick = 'setQty({$prodRow['procod']})'>{$prodRow['pronom']}</button></td>";

				$counter++;
			}
		} else {
			echo "<tr><td>No hay productos en esta Categoría</td></tr>";
		}
	}
}

if (isset($_POST['btnProd']) && isset($_POST['qty'])) {

	$prodID = $sqlconnection->real_escape_string($_POST['btnProd']);
	$quantity = $sqlconnection->real_escape_string($_POST['qty']);

	$prodQuery = "SELECT mi.procod,mi.pronom,mi.proprice,m.catnom FROM productos mi LEFT JOIN categoria m ON mi.catcod = m.catcod WHERE procod = " . $prodID;

	if ($prodResult = $sqlconnection->query($prodQuery)) {
		if ($prodResult->num_rows > 0) {
			if ($prodRow = $prodResult->fetch_array(MYSQLI_ASSOC)) {
				echo "
					<tr>
						<input type = 'hidden' name = 'prodcod[]' value ='" . $prodRow['procod'] . "'/>
						<td>" . $prodRow['catnom'] . " : " . $prodRow['pronom'] . "</td>
						<td>" . $prodRow['proprice'] . "</td>
						<td><input type = 'number' required='required' min='1' max='50' name = 'prodqty[]' width='10px' class='form-control' value ='" . $quantity . "'/></td>
						<td>" . number_format((float)$prodRow['proprice'] * $quantity, 2, '.', '') . "</td>
						<td><button class='btn btn-danger deleteBtn' type='button' onclick='deleteRow()'><i class='fas fa-times'></i></button></td>
					</tr>
					";
			}
		} else {
			echo "null";
		}
	}
}
