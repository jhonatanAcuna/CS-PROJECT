
<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
	header("Location: login.php");

if ($_SESSION['user_level'] != "employee")
	header("Location: login.php");

if (empty($_GET['cmd']))
	die();

if ($_GET['cmd'] == 'currentorder') {

	$orderQ =  "
					SELECT o.pedcod, m.catnom, OD.procod,MI.pronom,OD.peddetqty,O.pedest
					FROM pedido O
					LEFT JOIN pedidodetalle OD
					ON O.pedcod = OD.pedcod
					LEFT JOIN productos MI
					ON OD.procod = MI.procod
					LEFT JOIN categoria M
					ON MI.catcod = M.catcod
					WHERE O.pedest 
					IN ( 'waiting','preparing','ready')
				";

	if ($res = $sqlconnection->query($orderQ)) {

		$count = 0;

		if ($res->num_rows == 0) {

			echo "<tr><td class='text-center' colspan='7' >Sin ordenes Pendientes </td></tr>";
		} else {
			while ($ordR = $res->fetch_array(MYSQLI_ASSOC)) {

				$rows = getCountID($ordR["pedcod"], "pedcod", "pedidodetalle");

				if ($count == 0)
					$count = $rows;

				echo "<tr>";

				if ($count == $rows) {
					echo "<td rowspan=" . $rows . "># " . $ordR['pedcod'] . "</td>";
				}

				echo "
							<td>" . $ordR['catnom'] . "</td>
							<td>" . $ordR['pronom'] . "</td>
							<td class='text-center'>" . $ordR['peddetqty'] . "</td>
						";

				if ($count == $rows) {

					$color = "badge badge-warning";
					switch ($ordR['pedest']) {
						case 'waiting':
							$color = "badge badge-warning";
							break;

						case 'preparing':
							$color = "badge badge-primary";
							break;

						case 'ready':
							$color = "badge badge-success";
							break;
					}

					echo "<td class='text-center' rowspan=" . $rows . "><span class='{$color}'>" . $ordR['pedest'] . "</span></td>";

					echo "<td class='text-center' rowspan=" . $rows . ">";

					switch ($ordR['pedest']) {
						case 'waiting':

							echo "<button onclick='editStatus(this," . $ordR['pedcod'] . ")' class='btn btn-outline-primary' value = 'preparing'>Preparando</button>";
							echo "<button onclick='editStatus(this," . $ordR['pedcod'] . ")' class='btn btn-outline-success' value = 'ready'>Listo</button>";

							break;

						case 'preparing':

							echo "<button onclick='editStatus(this," . $ordR['pedcod'] . ")' class='btn btn-outline-success' value = 'ready'>Listo</button>";

							break;

						case 'ready':

							echo "<button onclick='editStatus(this," . $ordR['pedcod'] . ")' class='btn btn-outline-warning' value = 'finish'>Limpiar</button>";

							break;
					}

					echo "<button onclick='editStatus(this," . $ordR['pedcod'] . ")' class='btn btn-outline-danger' value = 'cancelled'>Cancelar</button></td>";

					echo "</td>";
				}

				echo "</tr>";

				$count--;
			}
		}
	}
}

//display current ready order list in staff index
if ($_GET['cmd'] == 'currentready') {

	$latestReadyQuery = "SELECT pedcod FROM pedido WHERE pedest IN ( 'finish','ready') ";

	if ($res = $sqlconnection->query($latestReadyQuery)) {

		if ($res->num_rows == 0) {
			echo "<tr><td class='text-center'>Sin ordenes Pendientes </td></tr>";
		}

		while ($latestOrder = $res->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr><td><i class='fas fa-bullhorn' style='color:green;'></i><b> Orden #" . $latestOrder['pedcod'] . "</b> lista para servir.<a href='editstatus.php?pedcod=" . $latestOrder['pedcod'] . "'><i class='fas fa-check float-right'></i></a></td></tr>";
		}
	}
}

?>