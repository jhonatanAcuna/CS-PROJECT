<?php 
    include("../functions.php");

    //checking username and password input
    if (isset($_POST['username']) && isset($_POST['password'])) {

        //prevent sql injection by escaping special characters
        $username = $sqlconnection->real_escape_string($_POST['username']);
        $password = $sqlconnection->real_escape_string($_POST['password']);

        //sql statement
        $sql = "SELECT * FROM empleado WHERE empuser ='$username' AND emppass = '$password'";

        if ($result = $sqlconnection->query($sql)) {

            if ($row = $result->fetch_array(MYSQLI_ASSOC)) {

                $uid = $row['empcod'];
                $username = $row['empuser'];
                $role = $row['emprol'];

                $_SESSION['uid'] = $uid;
                $_SESSION['username'] = $username;
                $_SESSION['user_level'] = "employee"; // 1 - admin 2 - staff
                $_SESSION['user_role'] = $role;

                echo ("correct");
            }

            else {
                echo "Wrong username or password.";
            }

        }

    }
      
?>