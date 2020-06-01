<?php 
    include "includes/admin_header.php";
?>
    <div id="wrapper">
    
        <!-- Navigation -->
        <?php 
            include "includes/admin_navigation.php";
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small><?php echo $_SESSION["user_firstname"]; ?> </small>
                        </h1>
                        
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <?php 
                            $posts = "SELECT * FROM posts";
                            $postsResult = mysqli_query($connection, $posts);
                            confirm($posts, $connection);

                            $postsCount = mysqli_num_rows($postsResult);
                        ?>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                <div class='huge'><?php echo $postsCount; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                    <?php 
                        $comments = "SELECT * FROM comments";
                        $commentsResult = mysqli_query($connection, $comments);
                        confirm($comments, $connection);
                        $commentsCount = mysqli_num_rows($commentsResult);
                    ?>
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $commentsCount; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                    <?php 
                        $users = "SELECT * FROM users";
                        $usersResult = mysqli_query($connection, $users);
                        confirm($users, $connection);
                        $usersCount = mysqli_num_rows($usersResult);
                    ?>
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $usersCount; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                    <?php 
                        $cat_query = "SELECT * FROM categories";
                        $cat_result = mysqli_query($connection, $cat_query);
                        confirm($cat_query, $connection);
                        $categoriesCount = mysqli_num_rows($cat_result);
                    ?>
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $categoriesCount; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                <?php 
                    // Published Posts
                    $queryPublished = "SELECT * FROM posts WHERE post_status = 'published'";
                    $resultPublished = mysqli_query($connection, $queryPublished);
                    confirm($queryPublished, $connection);
                    $postsPublished = mysqli_num_rows($resultPublished);

                    // Draft Posts
                    $queryDraft = "SELECT * FROM posts WHERE post_status = 'draft'";
                    $resultDraft = mysqli_query($connection, $queryDraft);
                    confirm($queryDraft, $connection);
                    $postsDraft = mysqli_num_rows($resultDraft);

                    // Unapproved Comments
                    $queryCommentsU = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                    $commentsUnResult = mysqli_query($connection, $queryCommentsU);
                    confirm($queryCommentsU, $connection);
                    $commentsUnapproved = mysqli_num_rows($commentsUnResult);

                    // Users Role
                    $queryUsers = "SELECT * FROM users WHERE user_role='subscriber'";
                    $resultUser = mysqli_query($connection, $queryUsers);
                    confirm($queryUsers, $connection);
                    $countSubs = mysqli_num_rows($resultUser);
                ?>
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', 'Count'],
                            <?php
                            $element_text = ["All Posts", "Active Posts", "Draft Posts", "Comments", "Unapproved Comments", "Users", "Subscribers", "Categories"];
                            $element_count = [$postsCount, $postsPublished, $postsDraft, $commentsCount, $commentsUnapproved, $usersCount, $countSubs, $categoriesCount]; 
                            for($i = 0; $i<count($element_text); $i++){
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";  
                            }
                            ?>
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>
                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php
    include "includes/admin_footer.php";
?> 
