<?php 

if(isset($_POST["create_user"])){
    $username = $_POST["username"];
    $user_password = $_POST["user_password"];
    $user_firstname = $_POST["user_firstname"];
    $user_lastname = $_POST["user_lastname"];
    $user_email = $_POST["user_email"];
    $user_image = $_FILES["user_image"]["name"];
    $user_image_temp = $_FILES["user_image"]["tmp_name"];
    $user_role = $_POST["user_role"];
    // $_FILES => 

    move_uploaded_file($user_image_temp, "../images/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));

    $query = "INSERT INTO `users` (`username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, 
                                  `user_role`) ";
    $query.= "VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', 
             '$user_email', '$user_image', '$user_role')";
    
    $result = mysqli_query($connection, $query);

    // CONFIRM QUERY
    confirm($result, $connection);

    $_SESSION["message"] = "User Created!";
    
}

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    echo "<h1 class='alert alert-success'>$message</h1>";
    unset($_SESSION["message"]);
}

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_author">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="post_author">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <div class="form-group">
        <label for="post_status">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="post_status">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="post_status">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <div class="form-group">
        <label for="post_image">User Image</label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <label for="post_tags">Role</label>
        <!-- <input type="text" class="form-control" name="user_role"> -->
        <select name="user_role" id="user_role">
            <option value="admin">Admin</option>
            <option value="subscriber" selected>Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
    
    
</form>