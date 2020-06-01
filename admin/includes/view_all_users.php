<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Image</th>
                                    <th>Role</th>
                                    <th>Change Role</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $query = "SELECT `user_id`, `username`, `user_firstname`, `user_lastname`, `user_email`, 
                                                 `user_image`, `user_role` 
                                          FROM `users`";
                                $select_all_users = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($select_all_users)){ 
                                    $user_id = $row["user_id"];
                                    $username = $row["username"];
                                    $user_firstname = $row["user_firstname"];
                                    $user_lastname = $row["user_lastname"];
                                    $user_email = $row["user_email"];
                                    $user_image = $row["user_image"];
                                    $user_role = $row["user_role"];

                                    echo "<tr>";
                                    echo "<td>$user_id</td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$user_firstname</td>";
                                    echo "<td>$user_lastname</td>";
                                    echo "<td>$user_email</td>";
                                    echo "<td><img src='../images/$user_image'></td>";
                                    echo "<td>$user_role</td>";
                                    echo "<td><a href='./users.php?change_role=$user_id'>Change Role</a></td>";
                                    echo "<td><a href='./users.php?source=edit_user&u_id=$user_id'>Edit</a></td>";
                                    echo "<td><a href='./users.php?delete=$user_id'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php 
                            if(isset($_GET["change_role"])){
                                $user_id = $_GET["change_role"];

                                $query = "SELECT user_role FROM users WHERE user_id=$user_id";
                                $result= mysqli_query($connection, $query);
                                confirm($query, $connection);
                                $row = mysqli_fetch_assoc($result);
                                $user_role = $row["user_role"];

                                if($user_role == "admin"){
                                    $user_role = "subscriber";
                                } elseif($user_role == "subscriber"){
                                    $user_role = "admin";
                                }

                                $query = "UPDATE users SET user_role='$user_role' WHERE user_id=$user_id";
                                $result= mysqli_query($connection, $query);
                                confirm($query, $connection);
                                header("Location: users.php");
                            }
                                
                            if(isset($_GET["delete"])){
                                $user_id = $_GET["delete"];

                                $query = "DELETE FROM users WHERE user_id=$user_id";
                                $result = mysqli_query($connection, $query);
                                confirm($result, $connection); 
                                header("Location: users.php");
                            }
                        ?>