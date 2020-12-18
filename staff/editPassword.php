<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
    header("Location: login.php");

if ($_SESSION['user_level'] != "employee")
    header("Location: login.php");

if (isset($_POST['editPass'])) { {
        if (!empty($_POST['password']) && isset($_POST['empcod'])) {
            $empcod = $sqlconnection->real_escape_string($_POST['empcod']);
            $empPass = $sqlconnection->real_escape_string($_POST['password']);
            $clave_hash = password_hash($empPass,PASSWORD_DEFAULT);

            $updatePassQuery = "UPDATE empleado SET emppass = '{$clave_hash}' WHERE empcod = {$empcod};";

            if($sqlconnection->query($updatePassQuery)==TRUE){
                header( "Location: index.php");
            }else{
                echo "someting wong";
		        echo $sqlconnection->error;
            }
        }
    }
}
