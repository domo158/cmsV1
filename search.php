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
                if(isset($_POST["submit"])){
                    $search = $_POST["search"];

                    $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' && post_status='published'";
                    $search_query = mysqli_query($connection, $query);

                   confirm($query, $connection);

                    $count = mysqli_num_rows($search_query);
                    if($count == 0){
                        echo "<h1>No posts found!</h1>";
                    } else {
                        while($row = mysqli_fetch_assoc($search_query)) {
                            $post_title = $row["post_title"];
                            $post_author = $row["post_author"];
                            $post_date = $row["post_date"];
                            $post_image = $row["post_image"];
                            $post_content = $row["post_content"];
                       ?>
                        <!-- First Blog Post -->
                        <h2>
                            <a href="#"><?php echo $post_title; ?></a>
                        </h2>
                        <p class="lead">
                            by <a href="index.php"><?php echo $post_author; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                        <hr>
                        <p><?php echo $post_content; ?></p>
                        <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
        
                        <hr>
                    <?php
                        }
                    }
                }
                ?> 
                <!-- <hr> -->

                <!-- Pager -->
                <?php 
                    if($count > 0){
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
