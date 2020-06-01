<?php 
    if(isset($_POST["checkBoxArray"])){
        foreach($_POST["checkBoxArray"] as $checkBoxValue){
            $bulk_options = $_POST["bulk_options"];
            switch($bulk_options){
                case "published":
                    $query = "UPDATE posts SET post_status='published' WHERE post_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
                case "draft":
                    $query = "UPDATE posts SET post_status='draft' WHERE post_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
                case "delete":
                    $query = "DELETE FROM posts WHERE post_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);
                break;
                case "clone":
                    $query = "SELECT * FROM posts WHERE post_id=$checkBoxValue";
                    $result = mysqli_query($connection, $query);
                    confirm($query, $connection);

                    $row = mysqli_fetch_array($result);
                    $post_title = $row["post_title"];
                    $post_category_id = $row["post_category"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                    $post_tags = $row["post_tags"];
                    $post_comment_count= $row["post_comment_count"];
                    $post_status= $row["post_status"];

                    $query = "INSERT INTO posts (post_category, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)
                              VALUES($post_category_id, '$post_title', '$post_author', '$post_date', '$post_image', '$post_content', '$post_tags', $post_comment_count, '$post_status')";
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
                <option value="published">Published</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
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
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Views</th>
                                    <th>Date</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $query = "SELECT post_id, cat_title, post_title, username, post_date, post_image, post_content, post_tags, 
                                                 COUNT(comments.comment_id) AS comment_count, post_status, post_views_count 
                                          FROM posts LEFT JOIN categories ON posts.post_category=categories.cat_id LEFT JOIN comments ON comments.comment_post_id=posts.post_id 
                                          INNER JOIN users ON posts.post_author=users.user_id GROUP BY posts.post_id ORDER BY post_id DESC";
                                $select_all_posts = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($select_all_posts)){
                                    $post_id = $row["post_id"];
                                    $post_category = $row["cat_title"]; // display category TITLE
                                    $post_title = $row["post_title"];
                                    $post_author = $row["username"];
                                    $post_date = $row["post_date"];
                                    $post_image = $row["post_image"];
                                    $post_content = $row["post_content"];
                                    $post_tags = $row["post_tags"];
                                    $post_comment_count = $row["comment_count"];
                                    $post_status = $row["post_status"];
                                    $post_views_count = $row["post_views_count"];
                            
                                    echo "<tr>";
                                    echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";
                                    echo "<td>$post_id</td>";
                                    echo "<td>$post_author</td>";
                                    echo "<td><a href='../post.php?p_id=$post_id' target='_blank'>$post_title</a></td>";
                                    echo "<td>$post_category</td>";
                                    echo "<td>$post_status</td>";
                                    echo "<td><img style='width: 100px' src='../images/$post_image'></a></td>";
                                    echo "<td>$post_tags</td>";
                                    echo "<td><a href='./comments.php?source=post_comments&p_id=$post_id'>$post_comment_count</a></td>";
                                    echo "<td>$post_views_count</td>";
                                    echo "<td>$post_date</td>";
                                    echo "<td><a href='./posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                                    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='./posts.php?delete=$post_id'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                        </table>
</form>
                        <?php 
                            if(isset($_GET["delete"])){
                                $delete_post_id = $_GET["delete"];

                                $query = "DELETE FROM posts WHERE post_id=$delete_post_id";
                                $result = mysqli_query($connection, $query);
                                confirm($result, $connection); 
                                header("Location: posts.php");
                            }
                        ?>