<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>
<?php 
    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);
        
        // $salt = '$2y$10$iusesomecrazystring222$';

        // $password = crypt($password, $salt);

        $query = "SELECT * FROM users WHERE (username='$username' || user_email='$username')"; // && user_password='$password'
        $result = mysqli_query($connection, $query);
        confirm($query, $connection);
        while($row = mysqli_fetch_assoc($result)){
            $db_id = $row["user_id"];
            $db_username = $row["username"];
            $db_password = $row["user_password"];
            $db_firstname = $row["user_firstname"];
            $db_lastname = $row["user_lastname"];
            $db_email = $row["user_email"];
            $db_image = $row["user_image"];
            $db_role = $row["user_role"];
            

        }

        // WORKS BUT LACKS ERROR HANDLING
        if(($username === $db_username || $username === $db_email) && password_verify($password, $db_password)) {
            $_SESSION["username"] = $db_username;
            $_SESSION["user_firstname"] = $db_firstname;
            $_SESSION["user_lastname"] = $db_lastname;
            $_SESSION["user_email"] = $db_email;
            $_SESSION["user_image"] = $db_image;
            $_SESSION["user_role"] = $db_role;
            
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../index.php");
        }
    }
?>