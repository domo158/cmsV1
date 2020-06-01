<?php 
    // FILL THE FORM WITH DATA FROM DB  
    if(isset($_GET["u_id"])){
        $user_id = $_GET["u_id"];
        
        $query = "SELECT * FROM users WHERE user_id=$user_id";
        $result = mysqli_query($connection, $query);

        confirm($query, $connection);
       
        while($row = mysqli_fetch_assoc($result)){
            $username = $row["username"];
            $user_password = $row["user_password"];
            $user_firstname = $row["user_firstname"];
            $user_lastname = $row["user_lastname"];
            $user_email = $row["user_email"];
            $user_image = $row["user_image"];
            $user_role = $row["user_role"];
        }
    } else {
        header("Location: users.php");
    }

    // UPDATE POST IN DB WITH NEW DATA FROM THE FORM
    if(isset($_POST["update_user"])){
        $username = $_POST["username"];
        $user_password = $_POST["user_password"];
        $user_firstname = $_POST["user_firstname"];
        $user_lastname = $_POST["user_lastname"];
        $user_email = $_POST["user_email"];
        $user_image = $_FILES["user_image"]["name"];
        $user_image_temp = $_FILES["user_image"]["tmp_name"];
        $user_role = $_POST["user_role"];
        
        //moving image from temporary location to permanent location
        move_uploaded_file($user_image_temp, "../images/$user_image");

        // CHECK IF FILE INPUT IS EMPTY, TAKE FROM THE OLD IMAGE FROM THE DB
        if(empty($user_image)){
            $query = "SELECT user_image FROM users WHERE user_id=$user_id";
            $result = mysqli_query($connection, $query);
            confirm($query, $connection);
            while($row = mysqli_fetch_assoc($result)){
                $user_image = $row["user_image"];
            }
        }

        if(!empty($user_password)){
            $query = "SELECT user_password FROM users WHERE user_id = $user_id";
            $pass_result = mysqli_query($connection, $query);
            confirm($query, $connection);
            $db_password = mysqli_fetch_array($pass_result);

            if($user_password != $db_password["user_password"]){
                $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));
            }
        }
    
        $query_update = "UPDATE users SET
                                username='$username',
                                user_password='$user_password',
                                user_firstname='$user_firstname',
                                user_lastname='$user_lastname',
                                user_email='$user_email',
                                user_image='$user_image',
                                user_role='$user_role'
                         WHERE user_id=$user_id";

        mysqli_query($connection, $query_update);

        
        confirm($query_update, $connection);
        $_SESSION["message"] = ["User Updated!", "success"];
        header("Location: users.php");
    }
?>
<?php 
    $query = "SELECT * FROM users WHERE user_id=2";
    $result = mysqli_query($connection, $query);
    $user1 = mysqli_fetch_array($result);
    $query = "SELECT * FROM users WHERE user_id=11";
    $result = mysqli_query($connection, $query);
    $user2 = mysqli_fetch_array($result);
    $query = "SELECT * FROM users WHERE user_id=13";
    $result = mysqli_query($connection, $query);
    $user3 = mysqli_fetch_array($result);

    
    
    echo $user1[1] . " " . $user1[2] . "<br>";
    echo $user2[1] . " " . $user2[2] . "<br>";
    echo $user3[1] . " " . $user3[2] . "<br>";

    if($user1[2] === $user2[2]){
        echo "TRUE <br>";
    } else {
        echo "FALSE <br>";
    }
    if($user1[2] === $user3[2]){
        echo "TRUE <br>";
    } else {
        echo "FALSE <br>";
    }
    if($user2[2] === $user3[2]){
        echo "TRUE <br>";
    } else {
        echo "FALSE <br>";
    }
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_author">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname; ?>">
    </div>
    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>
    <div class="form-group">
        <label for="post_image">User Image</label>
        <input class="form-control" type="file" name="user_image">
        <img width="200px" src="../images/<?php echo $user_image; ?>">
    </div>
    <div class="form-group">
        <label for="post_tags">Role</label>
        <!-- <input type="text" class="form-control" name="user_role"> -->
        <select class="form-control" name="user_role" id="user_role">
            <?php 
                if($user_role == "admin"){
                    echo "<option value='admin' selected>Admin</option>";
                    echo "<option value='subscriber'>Subscriber</option>";
                } else {
            ?>
            <option value="admin">Admin</option>
            <option value="subscriber" selected>Subscriber</option>
            <?php       
                }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
    </div>
</form>