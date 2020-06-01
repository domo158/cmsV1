<?php 
    if(isset($_POST["checkBoxArray"])){
        foreach($_POST["checkBoxArray"] as $checkBoxValue){
            $bulk_options = $_POST["bulk_options"];
            switch($bulk_options){
                case "approved":
                    $query = "UPDATE comments SET comment_status='approved' WHERE comment_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
                case "unapproved":
                    $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
                case "delete":
                    $query = "DELETE FROM comments WHERE comment_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
            }
        }
    }
?>

<form action="" method="POST">
    <div id="bulkOptionsContainer" class="col-xs-4" style="padding-left:0;">
        <div class="form-group">
            <select class="form-control" name="bulk_options" id="bulk_options">
                <option value="">Select Options</option>
                <option value="approved">Approved</option>
                <option value="unapproved">Unapproved</option>
                <option value="delete">Delete</option>
                <!-- <option value="clone">Clone</option> -->
            </select>
        </div>
    </div>
    <div class="col-xs-4">
        <div class="form-group">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
    </div>

<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input id="selectAllBoxes" type="checkbox"></th>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(!empty($_GET["p_id"])){
                                    $post_id = $_GET["p_id"];
                                    $query = "SELECT `comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, 
                                                            `comment_status`, `comment_date`, post_title
                                              FROM `comments` LEFT JOIN posts ON comment_post_id=post_id WHERE comment_post_id=$post_id";
                                    $select_all_comments = mysqli_query($connection, $query);
    
                                    while($row = mysqli_fetch_assoc($select_all_comments)){ 
                                        $comment_id = $row["comment_id"];
                                        $comment_post_id = $row["comment_post_id"];
                                        $comment_author = $row["comment_author"];
                                        $comment_content = $row["comment_content"];
                                        $comment_status = $row["comment_status"];
                                        $comment_date = $row["comment_date"];
                                        $comment_email = $row["comment_email"];
                                        $post_title = $row["post_title"];
    
                                        echo "<tr>";
                                        echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$comment_id'></td>";
                                        echo "<td>$comment_id</td>";
                                        echo "<td>$comment_author</td>";
                                        echo "<td>$comment_content</td>";
                                        echo "<td>$comment_email</td>";
                                        echo "<td>$comment_status</td>";
                                        echo "<td><a href='../post.php?p_id=$comment_post_id'>$post_title</a></td>";
                                        echo "<td>$comment_date</td>";
                                        echo "<td><a href='./comments.php?source=post_comments&approve=$comment_id&p_id=$post_id'>Approve</a></td>";
                                        echo "<td><a href='./comments.php?source=post_comments&unapprove=$comment_id&p_id=$post_id'>Unapproved</a></td>";
                                        echo "<td><a href='./comments.php?source=edit_comment&c_id=$comment_id'>Edit</a></td>";
                                        echo "<td><a href='./comments.php?source=post_comments&delete=$comment_id&p_id=$post_id'>Delete</a></td>";
                                        echo "</tr>";
                                    }
                                    
                                } else {
                                    echo "<h1>No Comments!</h1>";
                                }
                            ?>
                            </tbody>
                        </table>
                        </form>
                        <?php 
                            if(isset($_GET["delete"])){
                                $delete_comment_id = $_GET["delete"];
                                $post_id = $_GET["p_id"];

                                $query = "DELETE FROM comments WHERE comment_id=$delete_comment_id";
                                $result = mysqli_query($connection, $query);
                                confirm($result, $connection); 
                                header("Location: comments.php?source=post_comments&p_id=$post_id");
                            }

                            if(isset($_GET["unapprove"])){
                                $comment_id = $_GET["unapprove"];
                                $post_id = $_GET["p_id"];
                                $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id=$comment_id";
                                $result = mysqli_query($connection, $query);

                                confirm($query, $connection);

                                header("Location: comments.php?source=post_comments&p_id=$post_id");
                            }

                            if(isset($_GET["approve"])){
                                $comment_id = $_GET["approve"];
                                $post_id = $_GET["p_id"];
                                $query = "UPDATE comments SET comment_status='approved' WHERE comment_id=$comment_id";
                                $result = mysqli_query($connection, $query);

                                confirm($query, $connection);

                                header("Location: comments.php?source=post_comments&p_id=$post_id");
                            }
                        ?>