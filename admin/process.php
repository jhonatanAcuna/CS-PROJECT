<?php 
    include("../functions.php");

        //verificando ingreso de usuario y correo
        if (isset($_POST['username']) && isset($_POST['password'])) {

            //evitar la inyecction de sql escape de caracters especiales
            $user = $sqlconnection->real_escape_string($_POST['username']);
            $pass = $sqlconnection->real_escape_string($_POST['password']);

            //sql statement
            $sql = "SELECT * FROM administrador WHERE admuser ='$user' AND admpass = '$pass'";

            if ($result = $sqlconnection->query($sql)) {

                if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    
                    $uid = $row['admcod'];
                    $user = $row['admuser'];

                    $_SESSION['uid'] = $uid;
                    $_SESSION['username'] = $user;
                    $_SESSION['user_level'] = "admin";
                    echo "correct";
                }

                else {
                    echo "Usuario o Contraseña Incorrecta";
                }

            }

        }
      
?>