<?php 
    include "includes/header.php";
?>

    <!-- Navigation -->
    <?php 
        include "includes/navigation.php";
    ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
            <?php 
                if(isset($_GET["page"])){
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }

                if($page == "" || $page == 1){
                    $page_start = 0;
                } else {
                    $page_start = ($page * 5) - 5;
                }

                // get num rows from table
                $query = "SELECT * FROM posts";
                $get_rows = mysqli_query($connection, $query);
                $row_count = mysqli_num_rows($get_rows);
                
                $row_count = $row_count / 5;
                $row_count = ceil($row_count);


                $query = "SELECT * FROM posts LIMIT $page_start, 5";
                $select_all_posts_query = mysqli_query($connection, $query);

                if(mysqli_num_rows($select_all_posts_query) > 0){
                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row["post_id"];
                        $post_title = $row["post_title"];
                        $post_author = $row["post_author"];
                        $post_date = $row["post_date"];
                        $post_image = $row["post_image"];
                        $post_content = substr($row["post_content"], 0, 100) . "...";
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="author_posts.php?author=<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            <?php
                    }
                } else {
                    echo "<h1 class='text-center'>No posts found!</h1>";
                }
            ?> 
                
                <!-- <hr> -->

                <!-- Pager -->
                <?php 
                    if(mysqli_num_rows($select_all_posts_query) > 0){ 
                        echo "<ul class='pager'>";
                        for($i = 1; $i<=$row_count; $i++){
                            if($page == $i){
                                echo "<li><a class='active_link' href='index.php?page=$i'>$i</a></li>";
                            } else {
                                echo "<li><a href='index.php?page=$i'>$i</a></li>";
                            }
                        }
                        echo "</ul>";
                    }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php 
                include "includes/sidebar.php";
            ?>

        </div>
        <!-- /.row -->

        


<?php 
    include "includes/footer.php";
?> 
