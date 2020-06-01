<?php 
    include "includes/header.php";
?>

    <!-- Navigation -->
    <?php 
        include "includes/navigation.php";
    ?>
    <?php 
        if(isset($_GET["author"])){
            $author =  $_GET["author"];
            $author = mysqli_real_escape_string($connection, $author);
            if($author == ""){
                return header("Location: index.php");
            } else {
                $query = "SELECT * FROM posts WHERE post_author='$author'";
                $select_all_posts_query = mysqli_query($connection, $query);

            }
        }
    ?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">   
            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <?php 
                // $post = mysqli_fetch_assoc($select_all_categories_query);
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
                        by <a href="index.php"><?php echo $post_author; ?></a>
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
                    echo "<h1 class='text-center'>This author does not exist or has not posted anything yet!</h1>";
                }
            ?> 
                <!-- <hr> -->

                <!-- Pager -->
                <?php 
                    if(mysqli_num_rows($select_all_posts_query) > 0){
                ?>
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>
                <?php
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
