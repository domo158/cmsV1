<?php 

function confirm($result, $connection){
    if(!$result){
        die("QUERY FAILED " . mysqli_error($connection));
    }
}

function insert_categories(){
    global $connection;
    if(isset($_POST["submit"])){
        $cat_title = $_POST["cat_title"];

        if($cat_title == "" || empty($cat_title)){
            echo "This field should not be empty!";
        } else {
            $query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}')";
            $create_category_query = mysqli_query($connection, $query);

            if(!$create_category_query){
                die("QUERY FAILED." . mysqli_error($connection));
            }
        }

    }
}

function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories";
    $cat_result = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($cat_result)){
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"];

        echo "<tr>
                <td>{$cat_id}</td>
                <td>{$cat_title}</td>
                <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
                <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
            </tr>";
    }
}

function deleteCategories(){
    global $connection;
    if(isset($_GET["delete"])){
        $cat_id_delete = $_GET["delete"];
        
        $query = "DELETE FROM categories WHERE cat_id={$cat_id_delete}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");    
        if(!$delete_query){
            die("QUERY FAILED.");
        }
    }
}

function users_online(){
    
    if(isset($_GET["onlineusers"])){
        global $connection;

        if(!$connection){
            session_start();
            include("../includes/db.php");
            
            $session = session_id(); // when we start a session this function catches the id of the session
            $time = time();
            $time_out_in_seconds = 60;
            $time_out = $time - $time_out_in_seconds;
        
            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);
        
            if($count == NULL){
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }
        
            $users_online = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        
            echo $count_users = mysqli_num_rows($users_online);
        }
    } 
}

users_online();