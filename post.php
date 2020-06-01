<?php include "includes/header.php"; ?>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>
    <?php 
        if(isset($_GET["p_id"])){
            $p_id = $_GET["p_id"];
            if($p_id != ""){

                $viewsQuery = "UPDATE posts SET post_views_count=post_views_count+1 WHERE post_id=$p_id";
                $viewsResult = mysqli_query($connection, $viewsQuery);
                confirm($viewsQuery, $connection);

                $query = "SELECT * FROM posts WHERE post_id=$p_id";
                $result = mysqli_query($connection, $query);
                
                while($row = mysqli_fetch_assoc($result)){
                    $post_id = $row["post_id"];
                    $post_category = $row["post_category"];
                    $post_title = $row["post_title"];
                    $post_author = $row["post_author"];
                    $post_date = $row["post_date"];
                    $post_image = $row["post_image"];
                    $post_content = $row["post_content"];
                    $post_tags = $row["post_tags"];
                    $post_status = $row["post_status"];
                }
    
                if($p_id != $post_id){
                    header("Location: index.php");
                    exit();
                }
            } else {
                header("Location: index.php");
                exit();
            }
            
        } else {
            header("Location: index.php");
        }
    ?>
    <!-- Page Content -->
    <div class="container">
        <?php 
        if(isset($_SESSION["message"])){
            $class = $_SESSION["message"][0];
            $message = $_SESSION["message"][1];
            echo "<div class='alert alert-$class'>$message</div>";
            unset($_SESSION["message"]);
        }
        ?>
        <div class="row">

            <!-- Blog Post Content Column -->
            <div class="col-lg-8">

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $post_content; ?></p>
                <hr>

                <!-- Blog Comments -->
                <?php 
                    if(isset($_POST["create_comment"])){
                        $the_post_id = $_GET["p_id"];
                        $comment_author = $_POST["comment_author"];
                        $comment_email = $_POST["comment_email"];
                        $comment_content = $_POST["comment_content"];

                        if(empty($comment_author) || empty($comment_email) || empty($comment_content)){
                            $_SESSION["message"] = ["danger", "All Fields must be populated!"];
                            header("Location: post.php?p_id=$post_id");
                        } else {
                            $query = "INSERT INTO comments (
                                        comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date
                                      ) VALUES(
                                          $the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now()
                                      )";
                            
                            $result = mysqli_query($connection, $query);
                            confirm($query, $connection);
                            
                            $_SESSION["message"] = ["success", "Comment Posted!"];
                            header("Location: post.php?p_id=$post_id");
                            
                        }
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST">
                        <div class="form-group">
                            <input class="form-control" type="text" name="comment_author" placeholder="Author">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="email" name="comment_email" placeholder="Email">
                        </div>
                        <div class="form-group">    
                            <textarea class="form-control" rows="3" placeholder="Comment..." name="comment_content"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->
                <?php 
                    if(isset($_GET["p_id"])){
                        $p_id = $_GET["p_id"];

                        $query = "SELECT * FROM comments WHERE comment_post_id=$p_id && comment_status='approved'";
                        $result = mysqli_query($connection, $query);
                        confirm($query, $connection);

                        while($row = mysqli_fetch_assoc($result)){
                            $comment_author = $row["comment_author"];
                            $comment_content = $row["comment_content"];
                            $comment_date = $row["comment_date"];
                ?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>
                <?php
                        }

                    }
                ?>

                <!-- <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                    </div>
                </div> -->

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                        <!-- Nested Comment -->
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <!-- End Nested Comment -->
                    </div>
                </div>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
                include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->

        <?php include "includes/footer.php"; ?>