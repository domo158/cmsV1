<?php 
    include "includes/admin_header.php";
?>


    <div id="wrapper">

        <!-- Navigation -->
        <?php 
            include "includes/admin_navigation.php";
        ?>

        <?php 
            if(isset($_SESSION["username"])){
                $username_session = $_SESSION["username"];

                $query = "SELECT * FROM users WHERE username='$username_session'";
                $result = mysqli_query($connection, $query);
                confirm($query, $connection);

                while($row = mysqli_fetch_assoc($result)){
                    $user_id = $row["user_id"];
                    $username = $row["username"];
                    $user_password = $row["user_password"];
                    $user_firstname = $row["user_firstname"];
                    $user_lastname = $row["user_lastname"];
                    $user_email = $row["user_email"];
                    $user_image = $row["user_image"];
                    $user_role = $row["user_role"];
                }
            }

            if(isset($_POST["update_profile"])){
                $username = $_POST["username"];
                $user_password = $_POST["user_password"];
                $user_firstname = $_POST["user_firstname"];
                $user_lastname = $_POST["user_lastname"];
                $user_email = $_POST["user_email"];
                $user_image = $_FILES["user_image"]["name"];
                $user_image_temp = $_FILES["user_image"]["tmp_name"];
                $user_role = $_POST["user_role"];

                if(empty($user_image)){
                    $query = "SELECT user_image FROM users WHERE user_id=$user_id";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);

                    while($row = mysqli_fetch_assoc($result)){
                        $user_image = $row["user_image"];
                    }
                }

                if(!empty($user_password)){
                    $query = "SELECT user_password FROM users WHERE user_id=$user_id";
                    $pass_result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                    $db_password = mysqli_fetch_array($pass_result);
    
                    if($user_password != $db_password["user_password"]){
                        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));
                    }
                }

                $query = "UPDATE users SET 
                                 username='$username',
                                 user_password='$user_password',
                                 user_firstname='$user_firstname',
                                 user_lastname='$user_lastname',
                                 user_email='$user_email',
                                 user_image='$user_image',
                                 user_role='$user_role'
                                 WHERE user_id=$user_id";
                $result = mysqli_query($connection, $query);
                confirm($query, $connection);
                $_SESSION["message"] = "Profile Updated!";
            }
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">
                <?php 
                if(isset($_SESSION["message"])){
                    $message = $_SESSION["message"];
                    echo "<h1 class='alert alert-success'>$message</h1>";
                    unset($_SESSION["message"]);
                }
                ?>
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION["user_firstname"]; ?></small>
                        </h1>
                        <!-- TABLE -->
                        <form action="profile.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="post_author">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                            </div>
                            <div class="form-group">
                                <label for="post_author">Password</label>
                                <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
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
                                <input type="file" name="user_image">
                                <img width="200px" src="../images/<?php echo $user_image; ?>">
                            </div>
                            <div class="form-group">
                                <label for="post_tags">Role</label>
                                <select name="user_role" id="user_role">
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
                                <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                            </div>
                        </form>
                        <!-- TABLE END -->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php
    include "includes/admin_footer.php";
?> 
