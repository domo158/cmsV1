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
                    <?php 
                    if(isset($_SESSION["message"])){
                        $message = $_SESSION["message"];
                        echo "<h1 class='alert alert-$message[1]'>$message[0]</h1>";
                        unset($_SESSION["message"]);
                    }
                    ?>
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Users
                            <!-- <small>Subheading</small> -->
                        </h1>
                        <!-- TABLE -->
                        <?php 
                            if(isset($_GET["source"])){
                                $source = $_GET["source"];
                            } else {
                                $source = "";
                            }

                            switch($source){
                                case "add_user":
                                    include "includes/add_user.php";
                                break;
                                case "edit_user";
                                    include "includes/edit_user.php";
                                break;
                                default:
                                    include "includes/view_all_users.php";
                                break;
                            }

                        ?>
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
