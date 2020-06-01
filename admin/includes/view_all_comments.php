<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
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
                                $query = "SELECT `comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, 
                                                    `comment_status`, `comment_date`, post_title
                                          FROM `comments` LEFT JOIN posts ON comment_post_id=post_id;";
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
                                    echo "<td>$comment_id</td>";
                                    echo "<td>$comment_author</td>";
                                    echo "<td>$comment_content</td>";
                                    echo "<td>$comment_email</td>";
                                    echo "<td>$comment_status</td>";
                                    echo "<td><a href='../post.php?p_id=$comment_post_id'>$post_title</a></td>";
                                    echo "<td>$comment_date</td>";
                                    echo "<td><a href='./comments.php?approve=$comment_id'>Approve</a></td>";
                                    echo "<td><a href='./comments.php?unapprove=$comment_id'>Unapproved</a></td>";
                                    echo "<td><a href='./comments.php?source=edit_comment&p_id=$comment_id'>Edit</a></td>";
                                    echo "<td><a href='./comments.php?delete=$comment_id'>Delete</a></td>";
                                    echo "</tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php 
                            if(isset($_GET["delete"])){
                                $delete_comment_id = $_GET["delete"];
                                $post_id = $_GET["p_id"];
                                $query = "DELETE FROM comments WHERE comment_id=$delete_comment_id";
                                $result = mysqli_query($connection, $query);
                                confirm($result, $connection); 
                                header("Location: comments.php");
                            }

                            if(isset($_GET["unapprove"])){
                                $comment_id = $_GET["unapprove"];
                                
                                $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id=$comment_id";
                                $result = mysqli_query($connection, $query);

                                confirm($query, $connection);

                                header("Location: ./comments.php");
                            }

                            if(isset($_GET["approve"])){
                                $comment_id = $_GET["approve"];
                                
                                $query = "UPDATE comments SET comment_status='approved' WHERE comment_id=$comment_id";
                                $result = mysqli_query($connection, $query);

                                confirm($query, $connection);

                                header("Location: ./comments.php");
                            }
                        ?>